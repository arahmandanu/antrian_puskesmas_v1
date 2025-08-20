<?php

namespace App\Services\Printer;

use App\Enum\LocketList;
use App\Models\Company;
use App\Models\LocketQueue;
use App\Utils\Result;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class LocketPrint extends \App\Services\AbstractService
{
    protected LocketQueue $queue;
    protected Company $company;

    public function __construct($queue, $company)
    {
        $this->queue = $queue;
        $this->company = $company;
    }

    public function handle()
    {
        try {
            $connector = new WindowsPrintConnector($this->company->printer);
            $printer = new Printer($connector);

            // Format struk antrian
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("ANTRIAN\n\n");
            $printer->setTextSize(4, 4);
            $printer->text($this->queue->locket_code . $this->queue->number_queue . "\n\n");

            $printer->setTextSize(1, 1);
            $printer->text(LocketList::from($this->queue->locket_code)->name . "\n\n");
            $printer->text(date("d-m-Y H:i") . "\n\n");

            $printer->cut();
            $printer->close();

            $error = false;
            $message = 'Sukses print nomor antrian loket';
        } catch (\Exception $e) {
            $error = true;
            $message = "Pastikan printer ada sudah benar {$this->company->printer}";
        }

        return Result::take($error, $this->queue, $message);
    }
}
