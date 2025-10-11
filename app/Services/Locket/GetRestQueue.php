<?php

namespace App\Services\Locket;

use App\Models\LocketQueue;
use App\Models\LocketStaff;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;

class GetRestQueue extends \App\Services\AbstractService
{
    protected LocketStaff $locketStaff;
    public function __construct($locketStaff)
    {
        $this->locketStaff = $locketStaff;
    }

    public function handle()
    {
        $allTotal = (new LocketQueue())->locketTotal($this->locketStaff->allowed_codes);
        $result = $allTotal->pluck('total', 'locket_code')->toArray();

        return Result::success($result, Lang::get('messages.success_retrive_data', [], 'id'));
    }
}
