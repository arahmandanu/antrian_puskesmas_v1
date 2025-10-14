<?php

namespace App\Services\Room;

use App\Helpers\DateRangeHelper;
use App\Models\QueueCaller;
use App\Models\Room;
use App\Models\RoomQueue;
use App\Models\RoomQueueHistoryCall;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class CallQueue extends \App\Services\AbstractService
{
    protected Room $room;
    protected string $roomCode;
    protected string $numberQueue;
    protected $currentTime;

    public function __construct($room, $roomCode, $numberQueue)
    {
        $this->room = $room;
        $this->roomCode = $roomCode;
        $this->numberQueue = $numberQueue;
        $this->currentTime = now();
    }

    public function handle()
    {
        try {
            $result = DB::transaction(function () {
                // 1️⃣ Check if this room’s required rooms already have an active queue
                if ($this->room->requiredBy()->exists()) {
                    $roomRequired = $this->room->requiredBy;

                    $exist = RoomQueue::whereIn('room_code', $roomRequired->pluck('code'))
                        ->where('called', true)
                        ->where('status', \App\Enum\RoomQueueStatus::WAITING->value)
                        ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
                        ->first();

                    if ($exist) {
                        return Result::failure(
                            Lang::get('messages.have_unfinished_queue', [
                                'queue' => $exist->formatAsQueueNumber()
                            ], 'id'),
                            null
                        );
                    }
                }

                // 2️⃣ Check if there’s already a pending queue call for this room
                $pendingExist = (new QueueCaller)->isExistPendingByOwnerid($this->room->id, 'poli');
                if ($pendingExist) {
                    return Result::failure(
                        Lang::get('messages.pending_queue', [
                            'queue' => $pendingExist->formatAsQueueNumber()
                        ], 'id'),
                        null
                    );
                }

                // 3️⃣ Find target queue
                $queue = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberQueue);
                if (!$queue) {
                    $this->updateLastHistory();
                    return Result::failure(
                        Lang::get('messages.queue_not_found', [], 'id'),
                        null
                    );
                }

                // 4️⃣ Already called?
                if ($queue->called) {
                    return Result::failure(
                        Lang::get('messages.already_called', [], 'id'),
                        $queue
                    );
                }

                // 5️⃣ Update queue as called
                $queue->called = true;
                $queue->save();

                // 6️⃣ Create QueueCaller entry
                QueueCaller::create([
                    'owner_id'      => $this->room->id,
                    'number_code'   => $this->roomCode,
                    'called'        => false,
                    'type'          => 'poli',
                    'lantai'        => $this->room->lantai,
                    'number_queue'  => $this->numberQueue,
                    'called_to'     => $this->room->name,
                    'initiator_name' => $this->room->name,
                ]);

                RoomQueueHistoryCall::create([
                    'room_code'               => $this->room->code,
                    'number_queue'            => $queue->number_queue,
                    'number_code'          => $queue->room_code,
                    'process_time_queue_room' => null,
                    'room_id' => $this->room->id,
                    'room_queue_id' => $queue->id,
                    'called_at' => now(),
                    'awaiting_called_duration' => $this->currentTime->diffInSeconds($queue->created_at)
                ]);

                // 7️⃣ Save call history
                $this->updateLastHistory();

                // 8️⃣ Update room
                $this->room->update([
                    'last_call_queue'   => $this->numberQueue,
                    'last_call_time'    => $this->currentTime,
                    'last_room_queue_id' => $queue->id,
                ]);

                return Result::success(
                    Lang::get('messages.success_call', [], 'id'),
                    $queue
                );
            });

            return $result;
        } catch (\Throwable $th) {
            return Result::failure($th->getMessage(), null);
        }
    }

    private function updateLastHistory()
    {
        if ($history = RoomQueueHistoryCall::where('room_queue_id', $this->room->last_room_queue_id)
            ->whereNull('process_time_queue_room')
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow(0))
            ->first()
        ) {
            $updated = $history->update([
                'process_time_queue_room' => $this->currentTime->diffInSeconds($history->created_at)
            ]);

            if (!$updated) {
                throw new \RuntimeException("Failed to update process_time_queue_room for history ID: {$history->id}");
            }
        }
    }
}
