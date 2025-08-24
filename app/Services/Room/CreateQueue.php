<?php

namespace App\Services\Room;

use App\Models\Room;
use App\Models\RoomQueue;
use App\Utils\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CreateQueue extends \App\Services\AbstractService
{
    protected Room $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        $newQueue = null;
        try {
            DB::beginTransaction();
            $newQueue = RoomQueue::create([
                'room_code' => $this->room->code,
                'number_queue' => self::generateNumberQueue()
            ]);

            $this->room->current_queue = $newQueue->number_queue;
            $this->room->save();
            $error = false;
            $message = Lang::get('messages.success_retrive_data', [], 'id');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $error = true;
            $message = $th->getMessage();
        }

        return Result::take($error, $newQueue, $message);
    }

    public function generateNumberQueue()
    {
        $current = RoomQueue::where('room_code', $this->room->code)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->orderBy('id', 'desc')
            ->first();

        $newNumber = $current
            ? (int)$current->number_queue + 1
            : 1;

        $digit = config('mysite.total_locket_queue', 4); // Default to 4 if not set
        return sprintf("%0{$digit}d", $newNumber); // If no current queue, start from 1
    }
}
