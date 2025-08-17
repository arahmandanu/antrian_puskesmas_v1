<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketCall;
use App\Models\LocketHistoryCall;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use Illuminate\Support\Arr;

class GetNextQueue extends \App\Services\AbstractService
{
    protected $locket_code;
    protected $locket_number;

    public function __construct($locket_code, $locket_number)
    {
        $this->locket_code = $locket_code;
        $this->locket_number = $locket_number;
    }

    public function handle()
    {
        $lastCall = LocketQueue::lastCallByLocketCode($this->locket_code, $this->locket_number)->first();
        $next = LocketQueue::nextQueue($this->locket_code)->first();

        if (!$next) {
            return null;
        }

        $next->called = true;
        $next->locket_number = $this->locket_number;
        $next->save();

        if ($lastCall) {
            $locketStaff = LocketStaff::where('locket_number', $this->locket_number)->first();
            if ($locketStaff) {
                LocketHistoryCall::create([
                    'locket_code' => $this->locket_code,
                    'locket_number' =>  $locketStaff->locket_number,
                    'locket_staff_name' => $locketStaff->staff_name,
                    'number_queue' => $lastCall->number_queue,
                    'process_time_queue_locket' => now()->diffInSeconds($lastCall->created_at)
                ]);
            }
        }
        return [
            'locket_code' => $this->locket_code,
            'number_queue' => $next->number_queue,
            'locket_number' => $this->locket_number,
            'poli' => LocketList::from($this->locket_code)->name,
        ];
    }
}
