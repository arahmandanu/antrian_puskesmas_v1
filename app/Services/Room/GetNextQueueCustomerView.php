<?php

namespace App\Services\Room;

use App\Models\Room;
use App\Models\RoomQueue;

class GetNextQueueCustomerView extends \App\Services\AbstractService
{
    protected Room $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        if ($lastCalled = $this->room->queuesCalled()->first()) {
            return [
                'data' => $lastCalled,
                'error' => false,
                "message" => 'Success!'
            ];
        }

        return [
            'data' => null,
            'error' => true,
            "message" => 'Antrian kosong!'
        ];
    }
}
