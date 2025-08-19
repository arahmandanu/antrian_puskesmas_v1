<?php

namespace App\Services\Room;

use App\Models\QueueCaller;
use App\Models\Room;
use App\Models\RoomQueue;
use App\Models\RoomQueueHistoryCall;

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
        try {
            $isExist = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberQueue);

            if ($isExist = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberQueue)) {
                if ($isExist->called) {
                    $message = 'Antrian sudah dipanggil, silahkan klik recall.';
                } else {
                    $isExist->called = true;
                    if ($isExist->save()) {
                        $message = 'Success call';
                        $this->createHistoryRoom($isExist);
                    }
                }
            }
        } catch (\Throwable $th) {
            $error = true;
            $message = $th->getMessage();
        }

        return [
            'data' => $isExist,
            'error' => $error,
            "message" => $message
        ];
    }

    private function createHistoryRoom($queue)
    {
        QueueCaller::create([
            'number_code' =>  $this->roomCode,
            'called' => false,
            'type' => 'poli',
            'lantai' => $this->room->lantai,
            'number_queue' => $this->numberQueue,
            'called_to' => $this->room->name
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
