<?php

namespace App\Http\Controllers;

use App\Models\StatConsole;
use App\Http\Requests\StoreStatConsoleRequest;
use App\Http\Requests\UpdateStatConsoleRequest;

class StatConsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreStatConsoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatConsoleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatConsole  $statConsole
     * @return \Illuminate\Http\Response
     */
    public function show(StatConsole $statConsole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatConsole  $statConsole
     * @return \Illuminate\Http\Response
     */
    public function edit(StatConsole $statConsole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatConsoleRequest  $request
     * @param  \App\Models\StatConsole  $statConsole
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatConsoleRequest $request, StatConsole $statConsole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatConsole  $statConsole
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatConsole $statConsole)
    {
        //
    }
}
