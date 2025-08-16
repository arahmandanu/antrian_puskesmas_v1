<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketCall;
use App\Models\LocketQueue;

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
        $next = LocketQueue::nextQueue($this->locket_code)->first();
        if (!$next) {
            return null;
        }

        $next->called = true;
        $next->locket_number = $this->locket_number;
        $next->save();

        return [
            'locket_code' => $this->locket_code,
            'number_queue' => $next->number_queue,
            'locket_number' => $this->locket_number,
            'poli' => LocketList::from($this->locket_code)->name,
        ];
    }
}
