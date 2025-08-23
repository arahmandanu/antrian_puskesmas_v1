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
use App\Utils\Result;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class LocketController extends Controller
{
    public function index()
    {
        $videos = File::files('public/iklan_videos');
        $mp4Files = array_filter($videos, function ($file) {
            return $file->getExtension() === 'mp4';
        });

        $filesImage = File::files('public/iklan_images');
        $images = array_filter($filesImage, function ($file) {
            $ext = strtolower($file->getExtension());
            return in_array($ext, ['jpg', 'jpeg', 'webp']);
        });

        return view('loket_antrian.index', [
            'pendaftaran' => LocketList::PENDAFTARAN,
            'laborate' => LocketList::LABORATE,
            'lansia' => LocketList::LANSIA,
            'iklanVideos' => $mp4Files,
            'iklanImages' => $images
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
        return $this->customResponse((new \App\Services\Locket\GetNextQueue($request->input('locket_code'), $request->input('locket_number')))->handle());
    }

    public function getSisaAntrian(Request $request)
    {
        return $this->customResponse((new GetRestQueue())->handle());
    }

    public function getRecallQueue(Request $request, $locket_code, $locket_number)
    {
        $result = (new GetRecallQueue($locket_code, $locket_number))->handle();
        return $this->customResponse($result);
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
        return $this->successResponse(Result::success($result['data'], Lang::get('messages.success_retrive_data', [], 'id')));
    }
}
