<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketHistoryCall;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\QueueCaller;
use Illuminate\Support\Facades\Lang;

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
        $locketStaff = LocketStaff::where('locket_number', $this->locket_number)->first();
        $pendingExist = ((new QueueCaller)->isExistPendingByOwnerid($locketStaff->id, 'locket'));
        if ($pendingExist) {
            return [
                'error' => true,
                'message' => Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'),
                'data' => null
            ];
        }

        $next = LocketQueue::nextQueue($this->locket_code)->first();
        if (!$next) {
            return [
                'error' => true,
                'message' => 'Tidak ada antrian yang belum terpanggil!',
                'data' => null
            ];
        }

        $next->called = true;
        $next->locket_number = $this->locket_number;
        $next->save();

        if ($locketStaff) {
            QueueCaller::create([
                'owner_id' => $locketStaff->id,
                'number_code' =>  $this->locket_code,
                'called' => false,
                'type' => 'locket',
                'lantai' => $locketStaff->lantai,
                'number_queue' => $next->number_queue,
                'called_to' => "loket {$this->locket_number}",
                'initiator_name' => LocketList::from($this->locket_code)->name
            ]);

            if ($lastCall = LocketQueue::lastCallByLocketCode($this->locket_code, $this->locket_number)->first()) {
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
            'error' => false,
            'message' => 'Success memanggil antrian!',
            'data' =>  [
                'locket_code' => $this->locket_code,
                'number_queue' => $next->number_queue,
                'locket_number' => $this->locket_number,
                'poli' => LocketList::from($this->locket_code)->name,
            ]
        ];
    }
}
