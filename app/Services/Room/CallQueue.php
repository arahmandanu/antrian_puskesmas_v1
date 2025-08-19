<?php

namespace App\Services\Room;

use App\Models\Room;
use App\Models\RoomQueue;

class CallQueue extends \App\Services\AbstractService
{
    protected Room $room;
    protected string $roomCode;
    protected string $numberCode;

    public function __construct($room, $roomCode, $numberCode)
    {
        $this->room = $room;
        $this->roomCode = $roomCode;
        $this->numberCode = $numberCode;
    }

    public function handle()
    {
        $isExist = null;
        $error = false;
        try {
            $isExist = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberCode);

            if ($isExist = (new RoomQueue)->isExistByCode($this->roomCode, $this->numberCode)) {
                if ($isExist->called) {
                    $message = 'Antrian sudah dipanggil, silahkan klik recall.';
                } else {
                    $isExist->called = true;
                    if ($isExist->save()) {
                        $message = 'Success call';
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
}
