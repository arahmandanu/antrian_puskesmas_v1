<?php

namespace App\Http\Controllers;

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

        $allRoomLantai = Room::where('lantai', $lantai)->where('show', true)->get()->toArray();
        $allLocketLantai = LocketStaff::where('lantai', $lantai)->get()->toArray();

        $sub = DB::table('queue_callers')
            ->selectRaw('number_code, MAX(id) as max_id')
            ->where('called', true)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->groupBy('number_code');

        $latestCalled = DB::table('queue_callers as q')
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->joinSub($sub, 't', function ($join) {
                $join->on('q.id', '=', 't.max_id');
            })->get();

        $allList = [];
        foreach (array_merge($allLocketLantai, $allRoomLantai) as $staff) {
            $collect = ['staff' => $staff];
            foreach ($latestCalled as $calledQueue) {
                if ($calledQueue->type == 'locket') {
                    if ($calledQueue->owner_id == $staff['id'] && isset($staff['locket_number'])) {
                        $collect['queue'] =  (array) $calledQueue;
                    }
                } else {
                    if (!isset($staff['locket_number'])) {
                        if ($staff['code'] == $calledQueue->number_code) {
                            $collect['queue'] =  (array) $calledQueue;
                        }
                    }
                }
            }

            $collect['name'] = isset($staff['locket_number']) ? "Loket {$staff['locket_number']}" : $staff['name'];
            $collect['type'] = isset($staff['locket_number']) ? "locket" : 'poli';
            $allList[] = $collect;
        }

        return view('show-all-queue', [
            'calledList' => $allList,
            'lantai' => $lantai
        ]);
    }

    public function showAllQueueByLantaiV2(Request $request, $lantai)
    {
        if (!in_array($lantai, range(1, config('mysite.total_lantai')))) return abort(404);

        $videos = File::files('public/iklan_videos');
        $mp4Files = array_filter($videos, function ($file) {
            return $file->getExtension() === 'mp4';
        });

        $filesImage = File::files('public/iklan_images');
        $images = array_filter($filesImage, function ($file) {
            $ext = strtolower($file->getExtension());
            return in_array($ext, ['jpg', 'jpeg', 'webp']);
        });

        $allRoomLantai = Room::where('lantai', $lantai)->where('show', true)->get()->toArray();
        $allLocketLantai = LocketStaff::where('lantai', $lantai)->get()->toArray();

        $sub = DB::table('queue_callers')
            ->selectRaw('number_code, MAX(id) as max_id')
            ->where('called', true)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->groupBy('number_code');

        $latestCalled = DB::table('queue_callers as q')
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->joinSub($sub, 't', function ($join) {
                $join->on('q.id', '=', 't.max_id');
            })->get();

        $allList = [];
        foreach (array_merge($allLocketLantai, $allRoomLantai) as $staff) {
            $collect = ['staff' => $staff];
            foreach ($latestCalled as $calledQueue) {
                if ($calledQueue->type == 'locket') {
                    if ($calledQueue->owner_id == $staff['id'] && isset($staff['locket_number'])) {
                        $collect['queue'] =  (array) $calledQueue;
                    }
                } else {
                    if (!isset($staff['locket_number'])) {
                        if ($staff['code'] == $calledQueue->number_code) {
                            $collect['queue'] =  (array) $calledQueue;
                        }
                    }
                }
            }

            $collect['name'] = isset($staff['locket_number']) ? "Loket {$staff['locket_number']}" : $staff['name'];
            $collect['type'] = isset($staff['locket_number']) ? "locket" : 'poli';
            $allList[] = $collect;
        }

        return view('show-all-queue-v2', [
            'calledListright' => array_slice($allList, 0, 4),
            'calledListbottom' => array_slice($allList, 4, 5),
            'lantai' => $lantai,
            'iklanVideos' => $mp4Files,
            'iklanImages' => $images
        ]);
    }
}
