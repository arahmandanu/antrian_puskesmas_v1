<?php

namespace App\Services\Sound;

use App\Models\QueueCaller;
use App\Models\Room;
use App\Models\RoomQueue;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;

class GetNextCallByFloor extends \App\Services\AbstractService
{
    protected int $lantai;

    public function __construct($lantai)
    {
        $this->lantai = $lantai;
    }

    public function handle()
    {
        $nextQueue = Result::success(null, Lang::get('messages.success_retrive_data', [], 'id'));
        if ($existQueue = QueueCaller::nextCalledByLantai($this->lantai)->first()) {
            $existQueue->called = true;
            if ($existQueue->save()) {
                $nextQueue = Result::success($existQueue, Lang::get('messages.success_retrive_data', [], 'id'));
            }
        }

        return $nextQueue;
    }
}
