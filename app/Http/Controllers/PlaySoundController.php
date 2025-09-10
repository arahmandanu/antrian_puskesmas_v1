<?php

namespace App\Http\Controllers;

use App\Models\QueueCaller;
use App\Services\Sound\GetNextCallByFloor;
use App\Utils\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PlaySoundController extends Controller
{
    public function start(Request $request)
    {
        return view(
            'play_suara.index'
        );
    }

    public function index(Request $request, $lantai)
    {
        return view('play_suara.choosed_lantai', [
            'lantai' => $lantai,
            'histories' => QueueCaller::lastCalled($lantai, 5)->get()
        ]);
    }

    public function getNextCall(Request $request, $lantai)
    {
        return $this->customResponse((new GetNextCallByFloor($lantai))->handle());
    }
}
