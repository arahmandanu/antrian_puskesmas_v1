<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Models\Company;
use App\Models\LocketQueue;
use App\Services\Printer\LocketPrint;
use App\Utils\Result;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $response = null;
            $generateNumberQueue = $this->generateQueueNumber();
            $company = Company::first();
            if ((config('mysite.printer_on', true) === true) && (!$company || $company->printer === null)) {
                DB::rollBack();
                return Result::failure('Printer belum terpasang');
            }

            $queue = LocketQueue::create([
                'poli' => $this->poli,
                'locket_code' => $this->code,
                'number_queue' => $generateNumberQueue,
            ]);

            if ($queue) {
                $response = (new LocketPrint($queue, $company))->handle();
                DB::commit();
            } else {
                DB::rollBack();
                return Result::failure('Gagal membuat antrian!');
            }

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage());
        }
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
