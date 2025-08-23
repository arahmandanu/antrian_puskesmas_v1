<?php

namespace App\Http\Controllers;

use App\Models\QueueCaller;
use App\Utils\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PlaySoundController extends Controller
{
    public function start(Request $request)
    {
        return view('play_suara.index');
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
        $nextQueue = Result::success(null, Lang::get('messages.success_retrive_data', [], 'id'));
        if ($existQueue = QueueCaller::nextCalledByLantai($lantai)->first()) {
            $existQueue->called = true;
            if ($existQueue->save()) {
                $nextQueue = Result::success($existQueue, Lang::get('messages.success_retrive_data', [], 'id'));
            }
        }

        return $this->successResponse($nextQueue, 'success retrive data');
    }
}
