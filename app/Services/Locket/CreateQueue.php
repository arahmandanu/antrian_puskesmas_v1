<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\Company;
use App\Models\LocketQueue;
use App\Services\Printer\LocketPrint;
use App\Utils\Result;

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
        $response = null;
        $generateNumberQueue = $this->generateQueueNumber();
        $company = Company::first();
        if (!$company || $company->printer === null) return Result::failure('Printer belum terpasang');

        if ($response = LocketQueue::create([
            'poli' => $this->poli,
            'locket_code' => $this->code,
            'number_queue' => $generateNumberQueue,
        ])) {
            $response = (new LocketPrint($response, $company))->handle();
        } else {
            return Result::failure('Gagal membuat antrian!');
        }

        return $response;
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
