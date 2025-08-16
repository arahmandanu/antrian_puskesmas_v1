<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketQueue;

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
        $lastCall = LocketQueue::lastCallByLocketCode($this->locketCode, $this->locketNumber)->first();

        if ($lastCall) {
            return [
                'locket_code' => $this->locketCode,
                'number_queue' => $lastCall->number_queue,
                'locket_number' => $this->locketNumber,
                'poli' => LocketList::from($this->locketCode)->name,
            ];
        } else {
            return [];
        }
    }
}
