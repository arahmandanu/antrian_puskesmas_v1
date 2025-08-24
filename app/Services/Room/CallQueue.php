<?php

namespace App\Services\Room;

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
    protected  $currentTime;

    public function __construct($room, $roomCode, $numberQueue)
    {
        $this->room = $room;
        $this->roomCode = $roomCode;
        $this->numberQueue = $numberQueue;
        $this->currentTime = now();
    }

    public function handle()
    {
        $isExist = null;
        $error = false;
        DB::beginTransaction();
        try {
            $pendingExist = (new QueueCaller)->isExistPendingByOwnerid($this->room->id, 'poli');
            if ($pendingExist) {
                DB::rollBack();
                return Result::failure(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'), null);
            }

            $isExist = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberQueue);
            if ($isExist = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberQueue)) {
                if ($isExist->called) {
                    $message = Lang::get('messages.already_called', [], 'id');
                } else {
                    $isExist->called = true;
                    if ($isExist->save()) {
                        $message = Lang::get('messages.success_call', [], 'id');
                        QueueCaller::create([
                            'owner_id' => $this->room->id,
                            'number_code' =>  $this->roomCode,
                            'called' => false,
                            'type' => 'poli',
                            'lantai' => $this->room->lantai,
                            'number_queue' => $this->numberQueue,
                            'called_to' => $this->room->name,
                            'initiator_name' => "Poli"
                        ]);

                        RoomQueueHistoryCall::create([
                            'room_code' => $this->room->code,
                            'number_queue' =>  $this->room->last_call_queue,
                            'process_time_queue_room' => $this->currentTime->diffInSeconds($this->room->last_call_time),
                        ]);

                        $this->room->last_call_queue = $this->numberQueue;
                        $this->room->last_call_time = $this->currentTime;
                        $this->room->save();
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $error = true;
            $message = $th->getMessage();
        }

        return Result::take($error, $isExist, $message);
    }
}
