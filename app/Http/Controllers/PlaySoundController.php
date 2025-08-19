<?php

namespace App\Http\Controllers;

use App\Models\QueueCaller;
use Illuminate\Http\Request;

class PlaySoundController extends Controller
{
    public function index(Request $request, $lantai)
    {
        return view('play_suara.choosed_lantai', [
            'lantai' => $lantai,
            'histories' => QueueCaller::lastCalled($lantai, 5)->get()
        ]);
    }

    public function getNextCall(Request $request, $lantai)
    {
        $nextQueue = null;
        if ($nextQueue = QueueCaller::nextCalledByLantai($lantai)->first()) {
            $nextQueue->called = true;
            $nextQueue->save();
        }

        return $this->successResponse($nextQueue, 'success retrive data');
    }
}
