<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomQueue;
use App\Services\Room\CallQueue;
use App\Services\Room\GetNextQueueCustomerView;
use App\Services\Room\GetQueueByRoom;
use App\Services\Room\ReCallQueue;
use App\Utils\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('loket_staff.list_poli', [
            'polis' => Room::show()->orderBy('code', 'asc')->get(),
        ]);
    }

    public function generateView(Request $request, Room $room)
    {
        if ($room->requiredBy()->exists()) {
            $roomRequired = $room->requiredBy;
            $showHistory = false;
            $roomIds = $roomRequired->pluck('code')->toArray();
            $queueCalled = RoomQueue::whereIn('room_code', $roomIds)
                ->where('called', true)
                ->where('status', \App\Enum\RoomQueueStatus::WAITING->value)
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->orderByDesc('id')
                ->take(5)
                ->get()
                ->map(fn($q) => $q->room_code . $q->number_queue);

            $resultsNotCalled =  RoomQueue::whereIn('room_code', $roomIds)
                ->where('called', false)
                ->where('status', \App\Enum\RoomQueueStatus::WAITING->value)
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->orderBy('id', 'asc')
                ->take(5)
                ->get()
                ->map(fn($q) => $q->room_code . $q->number_queue);

            $lastDataCall = null;
            if ($lastCalled = $queueCalled) {
                $lastDataCall = $lastCalled->first();
            }
        } else {
            $showHistory = true;
            $queueCalled = $room->queuesCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->take(5)->get()->map(function ($queue) {
                    return $queue->room_code . $queue->number_queue;
                });

            $resultsNotCalled =  $room->queuesNotCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->take(5)->get()->map(function ($queue) {
                    return $queue->room_code . $queue->number_queue;
                });

            $lastDataCall = null;
            if ($lastCalled = $room->queuesCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->take(1)->first()
            ) {
                $lastDataCall = $lastCalled->room_code . $lastCalled->number_queue;
            }
        }


        return view('loket_staff.call', [
            'poli' => $room,
            'queuesCalled' => $queueCalled,
            'queueNotCalled' => $resultsNotCalled,
            'totalQueueNotCalled' => $room->queuesNotCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count(),
            'lastCalled' => $lastDataCall,
            'showHistory' => $showHistory
        ]);
    }

    public function showQueueByRoom(Request $request, Room $room)
    {
        $currentQueue = "-";
        $nextQueue = "-";
        if ($lastCalled = $room->queuesCalled()->first()) {
            $currentQueue = $lastCalled->room_code . $lastCalled->number_queue;
            $nextQueue = $lastCalled->room_code . str_pad($lastCalled->number_queue + 1, config('mysite.total_locket_queue', 4), '0', STR_PAD_LEFT);
        }

        return view('pasien.poli_terpanggil', [
            'poli' => $room,
            'currentQueue' => $currentQueue,
            'nextQueue' => $nextQueue
        ]);
    }

    public function getQueueByRoom(Request $request, Room $room)
    {
        return $this->customResponse((new GetQueueByRoom($room))->handle());
    }

    public function callQueueByRoom(Request $request, Room $room)
    {
        $numberCode = $request->input('number_queue');
        $roomCode = substr($numberCode, 0, 1);
        $numberCode  = substr($numberCode, 1);
        return $this->customResponse((new CallQueue($room, $roomCode, $numberCode))->handle());
    }

    public function recallQueueByRoom(Room $room)
    {
        return $this->customResponse((new ReCallQueue($room))->handle());
    }

    public function finishQueueByRoom(Request $request, Room $room)
    {
        $numberCode = $request->input('number_queue');
        $roomCode = substr($numberCode, 0, 1);
        $numberCode  = substr($numberCode, 1);

        $queue = RoomQueue::where('room_code', '=', $roomCode)
            ->where('number_queue', '=', $numberCode)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->first();

        if (!$queue) {
            return $this->customResponse(Result::failure(Lang::get('messages.empty_queue', [], 'id'), null));
        }

        if ($queue->called == false) {
            return $this->customResponse(Result::failure(Lang::get('messages.queue_not_called_yet', [], 'id'), null));
        }

        if ($queue->status == \App\Enum\RoomQueueStatus::COMPLETED->value) {
            return $this->customResponse(Result::failure(Lang::get('messages.queue_already_completed', [], 'id'), null));
        }

        $queue->status = \App\Enum\RoomQueueStatus::COMPLETED->value;
        $queue->called = false;
        $error = false;
        $message = Lang::get('messages.success_retrive_data', [], 'id');
        try {
            $queue->save();
        } catch (\Throwable $th) {
            $error = true;
            $message = $th->getMessage();
        }

        return $this->customResponse(Result::take($error, $queue, $message));
    }

    public function getNextQueueByRoom(Request $request, Room $room)
    {
        return $this->customResponse((new GetNextQueueCustomerView($room))->handle());
    }
}
