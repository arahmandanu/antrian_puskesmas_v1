<?php

namespace App\Http\Controllers;

use App\Helpers\DateRangeHelper;
use App\Http\Resources\Locket\LocketStaffResource;
use App\Http\Resources\Room\RoomResource;
use App\Models\LocketStaff;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MasterController extends Controller
{
    public function showAllQueueByLantai(Request $request, $lantai)
    {
        if (!in_array($lantai, range(1, config('mysite.total_lantai')))) return abort(404);

        return view('show-all-queue', [
            'calledList' => $this->listQueue($lantai),
            'lantai' => $lantai
        ]);
    }

    public function showAllQueueByLantaiV2(Request $request, $lantai)
    {
        if (!in_array($lantai, range(1, config('mysite.total_lantai')))) return abort(404);

        $videos = File::files(public_path('iklan_videos'));
        $mp4Files = array_filter($videos, function ($file) {
            return $file->getExtension() === 'mp4';
        });
        $filesImage = File::files(public_path('iklan_images'));
        $images = array_filter($filesImage, function ($file) {
            $ext = strtolower($file->getExtension());
            return in_array($ext, ['jpg', 'jpeg', 'webp']);
        });

        $allList = $this->listQueue($lantai);
        return view('show-all-queue-v2', [
            'calledListright' => array_slice($allList, 0, 4),
            'calledListbottom' => array_slice($allList, 4, 5),
            'lantai' => $lantai,
            'iklanVideos' => $mp4Files,
            'iklanImages' => $images
        ]);
    }

    private function listQueue($lantai)
    {
        $allRoomLantai = Room::with('lastQueue')
            ->where('lantai', $lantai)
            ->where('show', true)
            ->get()
            ->map(fn($room) => (new RoomResource($room))->toArray(request()));

        $allLocketLantai = LocketStaff::with('lastCalledQueue')
            ->where('lantai', $lantai)
            ->get()
            ->map(fn($locket) => (new LocketStaffResource($locket))->toArray(request()));

        $combined = $allLocketLantai->merge($allRoomLantai);
        return $combined->values()->all();
    }
}
