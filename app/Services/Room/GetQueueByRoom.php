<?php

namespace App\Services\Room;

use App\Helpers\DateRangeHelper;
use App\Models\Room;
use App\Models\RoomQueue;
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
        if ($this->room->requiredBy()->exists()) {
            $roomIds = $this->room->requiredBy->pluck('code')->toArray();
            $resultsNotCalled =  RoomQueue::whereIn('room_code', $roomIds)
                ->where('called', false)
                ->where('status', \App\Enum\RoomQueueStatus::WAITING->value)
                ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
                ->orderBy('id', 'asc')
                ->take(5)
                ->get()
                ->map(fn($q) => $q->room_code . $q->number_queue);

            $totalNotCalled = RoomQueue::whereIn('room_code', $roomIds)
                ->where('called', false)
                ->where('status', \App\Enum\RoomQueueStatus::WAITING->value)
                ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
                ->orderBy('id', 'asc')
                ->take(5)
                ->count();
        } else {
            $resultsNotCalled =  $this->room->queuesNotCalled()
                ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
                ->take(5)
                ->get()->map(function ($queue) {
                    return $queue->room_code . $queue->number_queue;
                });

            $totalNotCalled =  $this->room->queuesNotCalled()
                ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
                ->count();
        }


        return Result::success(['total' => $totalNotCalled, 'pagination' => $resultsNotCalled], Lang::get('messages.success_retrive_data', [], 'id'));
    }
}
