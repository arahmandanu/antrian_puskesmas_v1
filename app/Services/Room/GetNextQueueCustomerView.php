<?php

namespace App\Services\Room;

use App\Models\Room;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;

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
            return Result::success($lastCalled,  Lang::get('messages.success_retrive_data', [], 'id'));
        }

        return Result::failure(Lang::get('messages.empty_queue', [], 'id'), null);
    }
}
