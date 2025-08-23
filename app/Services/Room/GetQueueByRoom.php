<?php

namespace App\Services\Room;

use App\Models\Room;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;

class GetQueueByRoom extends \App\Services\AbstractService
{
    protected Room $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        $resultsNotCalled =  $this->room->queuesNotCalled()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->take(5)
            ->get()->map(function ($queue) {
                return $queue->room_code . $queue->number_queue;
            });

        $totalNotCalled =  $this->room->queuesNotCalled()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();

        return Result::success(['total' => $totalNotCalled, 'pagination' => $resultsNotCalled], Lang::get('messages.success_retrive_data', [], 'id'));
    }
}
