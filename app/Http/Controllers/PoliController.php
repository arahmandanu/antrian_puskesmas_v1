<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

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
        $queueCalled = $room->queuesCalled()->take(5)->get()->map(function ($queue) {
            return $queue->room_code . $queue->number_queue;
        });
        $resultsNotCalled =  $room->queuesNotCalled()->take(5)->get()->map(function ($queue) {
            return $queue->room_code . $queue->number_queue;
        });
        $lastDataCall = null;
        if ($lastCalled = $room->queuesCalled()->take(1)->first()) {
            $lastDataCall = $lastCalled->room_code . $lastCalled->number_queue;
        }

        return view('loket_staff.call', [
            'poli' => $room,
            'queuesCalled' => $queueCalled,
            'queueNotCalled' => $resultsNotCalled,
            'totalQueueNotCalled' => $room->queuesNotCalled()->count(),
            'lastCalled' => $lastDataCall
        ]);
    }

    public function getQueueByRoom(Request $request, Room $room)
    {
        if ($request->wantsJson()) {
            $resultsNotCalled =  $room->queuesNotCalled()->take(5)->get()->map(function ($queue) {
                return $queue->room_code . $queue->number_queue;
            });
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }

        return $this->successResponse($resultsNotCalled, 'Data Retrieved!');
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
