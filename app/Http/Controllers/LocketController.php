<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enum\LocketList;

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
        return view('loket_antrian.list_locket');
    }
}
