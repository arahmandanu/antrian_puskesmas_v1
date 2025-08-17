<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enum\LocketList;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\Room;
use App\Services\Locket\GetRecallQueue;
use App\Services\Room\CreateQueue;
use Illuminate\Support\Str;

class LocketController extends Controller
{
    public function index()
    {
        return view('loket_antrian.index', [
            'pendaftaran' => LocketList::PENDAFTARAN,
            'laborate' => LocketList::LABORATE,
            'lansia' => LocketList::LANSIA,
        ]);
    }

    public function createQueue(Request $request)
    {
        if ($request->wantsJson()) {
            $list = LocketList::allIntoString();

            $request->validate([
                'code' => ['required', "in:$list"],
            ]);

            $queue = (new \App\Services\Locket\CreateQueue($request->input('poli'), $request->input('code')))->handle();
            return $this->successResponse($queue, "Antrian untuk {$request->input('poli')} dengan kode {$request->input('code')} berhasil dibuat.");
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }
    }

    public function locketList()
    {
        return view('loket_antrian.list_locket', [
            'lokets' => \App\Models\LocketStaff::orderBy('locket_number', 'asc')->get(),
        ]);
    }

    public function generateView(Request $request, LocketStaff $locket_number)
    {
        $allTotal = (new LocketQueue())->locketTotal();
        $result = $allTotal->pluck('total', 'locket_code')->toArray();

        return view('loket_staff.index', [
            'loket' => $locket_number,
            'locket_totals' => $result,
            'histories' => (new LocketQueue())->getHistoryBy($locket_number->locket_number)
        ]);
    }

    public function getNextQeueue(Request $request)
    {
        if ($request->wantsJson()) {
            $next = (new \App\Services\Locket\GetNextQueue($request->input('locket_code'), $request->input('locket_number')))->handle();
            if ($next === null) {
                return $this->errorResponse('No more queues available for this locket.', 404);
            }

            return $this->successResponse($next);
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }
    }

    public function getSisaAntrian(Request $request)
    {
        if ($request->wantsJson()) {
            $allTotal = (new LocketQueue())->locketTotal();
            $result = $allTotal->pluck('total', 'locket_code')->toArray();

            return $this->successResponse($result);
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }
    }

    public function getRecallQueue(Request $request, $locket_code, $locket_number)
    {
        if ($request->wantsJson()) {
            $lastQueue = (new GetRecallQueue($locket_code, $locket_number))->handle();

            return $this->successResponse($lastQueue);
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }
    }

    public function loketGetPoli(Request $request, $locket_number)
    {
        $allRoom = Room::show()->get();
        $list = $allRoom->map(function ($room) {
            return [
                'nama' => Str::upper($room['name']),
                'nomor' => $room->queues()->count(),
                'code' => $room->code
            ];
        });

        return view('loket_antrian.list_poli', [
            'polis' => $list,
            'locket_number' => $locket_number
        ]);
    }

    public function loketCreatePoliQueue(Request $request)
    {
        if ($request->wantsJson()) {
            $listCode = (new Room)->listRoomCode();
            $request->validate([
                'room_code' => 'required|in:' . join(",", $listCode->toArray()),
            ]);

            $result = (new CreateQueue(Room::where('code', '=', $request->input('room_code'))->first()))->handle();
            if ($result['error']) {
                flash()->error($result['message']);
                return $this->errorResponse($result['message'], 422);
            }

            flash()->success($result['message']);
            return $this->successResponse($result['data']);
        } else {
            return $this->errorResponse('Invalid request format. Please use JSON.', 400);
        }
    }
}
