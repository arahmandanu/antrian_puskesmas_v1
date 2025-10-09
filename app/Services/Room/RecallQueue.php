<?php

namespace App\Services\Room;

use App\Models\QueueCaller;
use App\Models\Room;
use App\Models\RoomQueue;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class ReCallQueue extends \App\Services\AbstractService
{
    protected Room $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        DB::beginTransaction();
        try {
            if ($this->room->requiredBy()->exists()) {
                $roomRequired = $this->room->requiredBy;
                $pendingExist = (new QueueCaller())->isExistPendingByOwnerid($this->room->id, 'poli');
                if ($pendingExist) {
                    DB::rollBack();
                    return Result::failure(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'));
                }

                $roomIds = $roomRequired->pluck('code')->toArray();
                $result = RoomQueue::whereIn('room_code', $roomIds)
                    ->where('called', true)
                    ->where('status', \App\Enum\RoomQueueStatus::WAITING->value)
                    ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                    ->orderByDesc('id')
                    ->take(1)->first();
            } else {
                $pendingExist = (new QueueCaller())->isExistPendingByOwnerid($this->room->id, 'poli');
                if ($pendingExist) {
                    DB::rollBack();
                    return Result::failure(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'));
                }

                $result = $this->room->queuesCalled()
                    ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                    ->take(1)->first();
            }

            if (!$result) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.empty_history', [], 'id'), null);
            }

            QueueCaller::create([
                'owner_id' => $this->room->id,
                'number_code' =>  $result->room_code,
                'called' => false,
                'type' => 'poli',
                'lantai' => $this->room->lantai,
                'number_queue' => $result->number_queue,
                'called_to' => $this->room->name,
                'initiator_name' => "Poli"
            ]);

            DB::commit();
            return Result::success($result, Lang::get('messages.success_retrive_data', [], 'id'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage(), null);
        }
    }
}
