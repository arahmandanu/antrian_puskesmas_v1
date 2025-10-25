<?php

namespace App\Http\Controllers;

use App\Http\Resources\Locket\LocketStaffResource;
use App\Http\Resources\Room\RoomResource;
use App\Models\LocketStaff;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MasterController extends Controller
{
    /**
     * Display all queues for a given floor (legacy view).
     */
    public function showAllQueueByLantai(Request $request, int $lantai)
    {
        $this->abortIfInvalidLantai($lantai);

        return view('show-all-queue', [
            'calledList' => $this->listQueue($lantai),
            'lantai' => $lantai,
        ]);
    }

    /**
     * Display all queues for a given floor (V2 view, includes videos).
     */
    public function showAllQueueByLantaiV2(Request $request, int $lantai)
    {
        $this->abortIfInvalidLantai($lantai);

        $mp4Files = collect(File::files(public_path('iklan_videos')))
            ->filter(fn($file) => $file->getExtension() === 'mp4')
            ->values();

        return view('show-all-queue-v2', [
            'calledListright' => $this->listQueue($lantai),
            'lantai' => $lantai,
            'iklanVideos' => $mp4Files,
        ]);
    }

    /**
     * Get merged queue list for rooms and lockets by floor.
     */
    private function listQueue(int $lantai): array
    {
        $rooms = Room::with('lastQueue')
            ->where([
                ['lantai', '=', $lantai],
                ['show', '=', true],
            ])
            ->get();

        $lockets = LocketStaff::with('lastCalledQueue')
            ->where('lantai', $lantai)
            ->get();

        return collect([
            ...RoomResource::collection($rooms)->resolve(),
            ...LocketStaffResource::collection($lockets)->resolve(),
        ])->values()->all();
    }

    /**
     * Validate lantai input.
     */
    private function abortIfInvalidLantai(int $lantai): void
    {
        if (! in_array($lantai, range(1, config('mysite.total_lantai')), true)) {
            abort(404);
        }
    }
}
