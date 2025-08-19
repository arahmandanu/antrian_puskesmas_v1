<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomQueue;
use App\Services\Room\CallQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        return view('loket_staff.call', [
            'poli' => $room,
            'queuesCalled' => $queueCalled,
            'queueNotCalled' => $resultsNotCalled,
            'totalQueueNotCalled' => $room->queuesNotCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count(),
            'lastCalled' => $lastDataCall
        ]);
    }

    public function getQueueByRoom(Request $request, Room $room)
    {
        if ($request->wantsJson()) {
            $resultsNotCalled =  $room->queuesNotCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->take(5)
                ->get()->map(function ($queue) {
                    return $queue->room_code . $queue->number_queue;
                });

            $totalNotCalled =  $room->queuesNotCalled()
                ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->count();
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }

        return $this->successResponse(['total' => $totalNotCalled, 'pagination' => $resultsNotCalled], 'Data Retrieved!');
    }

    public function callQueueByRoom(Request $request, Room $room)
    {
        if ($request->wantsJson()) {
            $numberCode = $request->input('number_queue');
            $roomCode = substr($numberCode, 0, 1);
            $numberCode  = substr($numberCode, 1);

            $result = (new CallQueue($room, $roomCode, $numberCode))->handle();
            return $this->resultResponseData($result, 201);
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }
    }


    public function showQueueByRoom(Request $request, Room $room)
    {
        return view('pasien.poli_terpanggil', [
            'poli' => $room
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
