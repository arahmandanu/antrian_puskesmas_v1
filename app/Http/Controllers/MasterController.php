<?php

namespace App\Http\Controllers;

use App\Helpers\DateRangeHelper;
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
        $allRoomLantai = Room::with('lastQueue')->where('lantai', $lantai)->where('show', true)->get()->toArray();
        $allLocketLantai = LocketStaff::with('lastCalledQueue')->where('lantai', $lantai)->get()->toArray();

        $sub = DB::table('queue_callers')
            ->selectRaw('owner_id, type, MAX(id) as max_id')
            ->where('called', true)
            ->where('lantai', $lantai)
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow(1))
            ->groupBy('owner_id', 'type');

        $latestCalled = DB::table('queue_callers as q')
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow(1))
            ->joinSub($sub, 't', function ($join) {
                $join->on('q.id', '=', 't.max_id');
            })
            ->where('q.lantai', $lantai)
            ->get();

        $allList = [];
        dd(array_merge($allLocketLantai, $allRoomLantai));
        foreach (array_merge($allLocketLantai, $allRoomLantai) as $staff) {
            $collect = ['staff' => $staff];
            foreach ($latestCalled as $calledQueue) {
                if ($calledQueue->type == 'locket') {
                    if ($calledQueue->owner_id == $staff['id'] && array_key_exists('locket_number', $staff)) {
                        $collect['queue'] =  (array) $calledQueue;
                    }
                } else {
                    if (!array_key_exists('locket_number', $staff)) {
                        if ($staff['code'] == $calledQueue->number_code) {
                            $collect['queue'] =  (array) $calledQueue;
                        }
                    }
                }
            }

            $collect['name'] = array_key_exists('locket_number', $staff)
                ? (isset($staff['locket_number'])
                    ? "{$staff['staff_name']} {$staff['locket_number']}"
                    : $staff['staff_name'])
                : $staff['name'];
            $collect['type'] = array_key_exists('locket_number', $staff) ? "locket" : 'poli';
            $collect['type'] = array_key_exists('locket_number', $staff) ? "locket" : 'poli';
            $allList[] = $collect;
        }

        return $allList;
    }
}
