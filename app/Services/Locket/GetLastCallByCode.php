<?php

namespace App\Services\Locket;

use App\Enum\LocketList;
use App\Http\Resources\LastCallTicketResource;
use App\Models\Company;
use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Models\QueueCaller;
use App\Services\Printer\LocketPrint;
use App\Utils\Result;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class GetLastCallByCode extends \App\Services\AbstractService
{
    protected $code;
    protected bool $isLocket;
    protected string $locketCode;
    public function __construct($code)
    {
        $this->code = $code;
        $this->isLocket = $this->isALocketByCode($code);
        $this->locketCode = $this->isLocket ? substr($code, 1) : 0;
    }

    public function handle()
    {
        try {
            $data = null;
            if ($this->isLocket) {
                $locket = LocketStaff::where('locket_number', $this->letterToNumber($this->locketCode))->first();
                if (!$locket) {
                    return Result::failure(Lang::get('messages.locket_not_found', [], 'id'), null);
                }
                $data = QueueCaller::LastCallByOwnerId($locket->id, 'locket', 1)->first();
            } else {
                $data = QueueCaller::LastCallByCode($this->code)->first();
            }

            return Result::success($data !== null ? new LastCallTicketResource($data) : $data, Lang::get('messages.success_retrive_data', [], 'id'));
        } catch (\Exception $e) {
            return Result::failure('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
