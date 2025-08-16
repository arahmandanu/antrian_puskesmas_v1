<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\LocketQueue;

class CreateQueue extends \App\Services\AbstractService
{
    protected $poli;
    protected $code;

    public function __construct($poli, $code)
    {
        $this->poli = $poli;
        $this->code = $code;
    }

    public function handle()
    {
        $generateNumberQueue = $this->generateQueueNumber();
        $numberQeueue = LocketQueue::create([
            'poli' => $this->poli,
            'locket_code' => $this->code,
            'number_queue' => $generateNumberQueue,
        ]);

        return $numberQeueue;
    }

    public function generateQueueNumber()
    {
        $current = LocketQueue::where('locket_code', $this->code)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->orderBy('id', 'desc')
            ->first();

        $newNumber = $current
            ? (int)$current->number_queue + 1
            : 1;

        $digit = config('mysite.total_locket_queue', 4); // Default to 4 if not set
        return sprintf("%0{$digit}d", $newNumber); // If no current queue, start from 1
    }
}
