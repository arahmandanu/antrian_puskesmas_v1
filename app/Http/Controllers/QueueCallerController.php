<?php

namespace App\Http\Controllers;

use App\Models\QueueCaller;
use App\Http\Requests\StoreQueueCallerRequest;
use App\Http\Requests\UpdateQueueCallerRequest;

class QueueCallerController extends Controller
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
     * @param  \App\Http\Requests\StoreQueueCallerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQueueCallerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QueueCaller  $queueCaller
     * @return \Illuminate\Http\Response
     */
    public function show(QueueCaller $queueCaller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QueueCaller  $queueCaller
     * @return \Illuminate\Http\Response
     */
    public function edit(QueueCaller $queueCaller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQueueCallerRequest  $request
     * @param  \App\Models\QueueCaller  $queueCaller
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQueueCallerRequest $request, QueueCaller $queueCaller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QueueCaller  $queueCaller
     * @return \Illuminate\Http\Response
     */
    public function destroy(QueueCaller $queueCaller)
    {
        //
    }
}
