<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enum\LocketList;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\Room;
use App\Services\Locket\GetRecallQueue;
use App\Services\Locket\GetRestQueue;
use App\Services\Room\CreateQueue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class LocketController extends Controller
{
    public function index()
    {
        $videos = File::files(public_path('asset_loket'));
        $mp4Files = array_filter($videos, function ($file) {
            return $file->getExtension() === 'mp4';
        });

        $filesImage = File::files(public_path('asset_loket'));
        $images = array_filter($filesImage, function ($file) {
            $ext = strtolower($file->getExtension());
            return in_array($ext, ['jpg', 'jpeg', 'webp']);
        });

        return view('loket_antrian.index', [
            'pendaftaran' => LocketList::PENDAFTARAN,
            'laborate' => LocketList::LABORATE,
            'lansia' => LocketList::LANSIA,
            'farmasi' => LocketList::FARMASI,
            'iklanVideos' => $mp4Files,
            'iklanImages' => $images
        ]);
    }

    public function locketList()
    {
        return view('loket_antrian.list_locket', [
            'lokets' => LocketStaff::orderBy('locket_number', 'asc')->get(),
        ]);
    }

    public function generateView(Request $request, LocketStaff $locket_number)
    {
        $allTotal = (new LocketQueue())->locketTotal($locket_number->allowed_codes);
        $result = $allTotal->pluck('total', 'locket_code')->toArray();
        $menus = [];
        foreach (LocketList::cases() as $case) {
            if ($locket_number->canHandle($case->value)) {
                $menus[] = LocketList::from($case->value)->asMenuList();
            }
        }

        return view('loket_staff.index', [
            'loket' => $locket_number,
            'locket_totals' => $result,
            'histories' => (new LocketQueue())->getHistoryBy($locket_number->id),
            'menus' => $menus
        ]);
    }

    public function loketGetPoli(Request $request, LocketStaff $locket_number)
    {
        $allRoom = Room::show()->doesntHave('requiredBy')->get();
        $list = $allRoom->map(function ($room) {
            return [
                'nama' => Str::upper($room['name']),
                'nomor' => $room->queues()->count(),
                'code' => $room->code
            ];
        });

        return view('loket_antrian.list_poli', [
            'polis' => $list,
            'locket_number' => $locket_number,
        ]);
    }

    public function createQueue(Request $request)
    {
        $list = LocketList::allIntoString();
        $request->validate([
            'code' => ['required', "in:$list"],
        ]);

        return $this->customResponse((new \App\Services\Locket\CreateQueue($request->input('poli'), $request->input('code')))->handle());
    }

    public function getNextQeueue(Request $request)
    {
        return $this->customResponse((new \App\Services\Locket\GetNextQueue($request->input('locket_code'), $request->input('locket_number')))->handle());
    }

    public function getSisaAntrian(Request $request, LocketStaff $staff)
    {
        return $this->customResponse((new GetRestQueue($staff))->handle());
    }

    public function getRecallQueue(Request $request, $locket_code, LocketStaff $locket_number)
    {
        $result = (new GetRecallQueue($locket_code, $locket_number))->handle();
        return $this->customResponse($result);
    }

    public function loketCreatePoliQueue(Request $request)
    {
        $listCode = (new Room)->listRoomCode();
        $request->validate([
            'room_code' => 'required|in:' . join(",", $listCode->toArray()),
        ]);

        $result = (new CreateQueue(Room::where('code', '=', $request->input('room_code'))->first()))->handle();
        return $this->customResponse($result);
    }
}
