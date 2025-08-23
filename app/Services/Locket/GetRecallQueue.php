<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\QueueCaller;
use Illuminate\Support\Facades\Lang;

class GetRecallQueue extends \App\Services\AbstractService
{
    protected $locketCode;
    protected $locketNumber;

    public function __construct($locketCode, $locketNumber)
    {
        $this->locketCode = $locketCode;
        $this->locketNumber = $locketNumber;
    }

    public function handle()
    {
        $locketStaff = LocketStaff::where('locket_number', $this->locketNumber)->first();
        $pendingExist = ((new QueueCaller())->isExistPendingByOwnerid($locketStaff->id, 'locket'));
        if ($pendingExist) {
            return [
                'error' => true,
                'message' => Lang::get('messages.pending_queue', ['queue' => $pendingExist->formatAsQueueNumber()], 'id'),
                'data' => null
            ];
        }

        $lastCall = LocketQueue::lastCallByLocketCode($this->locketCode, $this->locketNumber)->first();
        if ($lastCall) {
            QueueCaller::create([
                'owner_id' => $locketStaff->id,
                'number_code' =>  $this->locketCode,
                'called' => false,
                'type' => 'locket',
                'lantai' => $locketStaff->lantai,
                'number_queue' => $lastCall->number_queue,
                'called_to' => "loket {$this->locketNumber}",
                'initiator_name' => LocketList::from($this->locketCode)->name
            ]);

            return [
                'error' => false,
                'message' => 'Success recall antrian!',
                'data' => [
                    'locket_code' => $this->locketCode,
                    'number_queue' => $lastCall->number_queue,
                    'locket_number' => $this->locketNumber,
                    'poli' => LocketList::from($this->locketCode)->name,
                ]
            ];
        }

        return [
            'error' => true,
            'message' => 'History panggil kosong!',
            'data' => null,
        ];
    }
}
