<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Http\Resources\LastCallTicketResource;
use App\Models\Company;
use App\Models\LocketQueue;
use App\Models\QueueCaller;
use App\Services\Printer\LocketPrint;
use App\Utils\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class GetLastCallByCode extends \App\Services\AbstractService
{
    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function handle()
    {
        try {
            $data = null;
            if ($data = QueueCaller::LastCallByCode($this->code)->first()) {
                $data = new LastCallTicketResource($data);
            }

            return Result::success($data, Lang::get('messages.success_retrive_data', [], 'id'));
        } catch (\Exception $e) {
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
