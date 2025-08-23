<?php

namespace App\Http\Controllers;

use App\Models\QueueCaller;
use App\Models\Room;
use App\Services\Room\CallQueue;
use App\Services\Room\GetNextQueueCustomerView;
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
        $resultsNotCalled =  $room->queuesNotCalled()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->take(5)
            ->get()->map(function ($queue) {
                return $queue->room_code . $queue->number_queue;
            });

        $totalNotCalled =  $room->queuesNotCalled()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();

        return $this->successResponse(Result::success(['total' => $totalNotCalled, 'pagination' => $resultsNotCalled], Lang::get('messages.success_retrive_data', [], 'id')));
    }

    public function callQueueByRoom(Request $request, Room $room)
    {
        $numberCode = $request->input('number_queue');
        $roomCode = substr($numberCode, 0, 1);
        $numberCode  = substr($numberCode, 1);
        $result = (new CallQueue($room, $roomCode, $numberCode))->handle();
        return $this->resultResponseData($result, 201);
    }

    public function recallQueueByRoom(Request $request, Room $room)
    {
        $pendingExist = (new QueueCaller())->isExistPendingByOwnerid($room->id, 'poli');
        if ($pendingExist) return $this->errorResponse(Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'), 422);

        $result = $room->queuesCalled()
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->take(1)->first();
        if (!$result) return $this->errorResponse('Anda tidak memiliki riwayat antrian!', 422);

        QueueCaller::create([
            'owner_id' => $room->id,
            'number_code' =>  $result->room_code,
            'called' => false,
            'type' => 'poli',
            'lantai' => $room->lantai,
            'number_queue' => $result->number_queue,
            'called_to' => $room->name,
            'initiator_name' => "Poli"
        ]);

        return $this->successResponse(Result::success($result, Lang::get('messages.success_retrive_data', [], 'id')));
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

    public function getNextQueueByRoom(Request $request, Room $room)
    {
        $result = (new GetNextQueueCustomerView($room))->handle();
        return $this->resultResponseData($result);
    }
}
