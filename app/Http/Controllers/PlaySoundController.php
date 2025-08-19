<?php

namespace App\Http\Controllers;

use App\Models\QueueCaller;
use Illuminate\Http\Request;

class PlaySoundController extends Controller
{
    public function index(Request $request, $lantai)
    {
        return view('play_suara.choosed_lantai', ['lantai' => $lantai]);
    }

    public function getNextCall(Request $request, $lantai)
    {
        $nextQueue = QueueCaller::nextCalledByLantai($lantai)->first();
        return response()->json([
            "id" => 123,
            "locket_code" => "A",
            "number_queue" => 5,
            "poli_name" => "Pendaftaran"
        ], 200);
    }
}
