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
        $list = LocketList::getString();
        $validated = $request->validate([
            'code' => ['required', "in:$list"],
        ]);

        return response()->json([
            'message' => "Antrian untuk {$poli} dengan kode {$code} berhasil dibuat.",
        ]);
    }
}
