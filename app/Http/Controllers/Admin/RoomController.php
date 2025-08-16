<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.room.index', [
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room.create', [
            'availableCodes' => (new Room)->availableCodes(),
            'lantaiOptions' => range(1, config('mysite.total_lantai')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:1|unique:rooms,code',
            'name' => 'required|string|max:255',
            'lantai' => 'required|integer|in:' . implode(',', range(1, config('mysite.total_lantai'))),
        ]);

        if ($createdRoom = Room::create($validatedData)) {
            flash()->success('Poli berhasil dibuat.');
            return redirect()->route('admin.poli.edit', ['poli' => $createdRoom->id]);
        } else {
            return redirect()->back();
            flash()->error('Poli berhasil dibuat.');
        }
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
    public function edit(Room $poli)
    {
        return view('admin.room.edit', [
            'poli' => $poli,
            'availableCodes' => (new Room)->availableCodes($poli->code),
            'lantaiOptions' => range(1, config('mysite.total_lantai'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $poli)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:1|unique:rooms,code,' . $poli->id,
            'name' => 'required|string|max:255',
            'lantai' => 'required|integer|in:' . implode(',', range(1, config('mysite.total_lantai'))),
            'show' => 'required|boolean',
        ]);

        if ($poli->update($validatedData)) {
            flash()->success('Poli berhasil diperbarui.');
            return redirect()->route('admin.poli.edit', ['poli' => $poli->id]);
        } else {
            flash()->error('Poli gagal diperbarui.');
            return redirect()->back();
        }
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
