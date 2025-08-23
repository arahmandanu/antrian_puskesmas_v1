<?php

namespace App\Services\Locket;

use App\Models\LocketQueue;
use App\Utils\Result;
use Illuminate\Support\Facades\Lang;

class GetRestQueue extends \App\Services\AbstractService
{
    public function __construct() {}

    public function handle()
    {
        $allTotal = (new LocketQueue())->locketTotal();
        $result = $allTotal->pluck('total', 'locket_code')->toArray();

        return Result::success($result, Lang::get('messages.success_retrive_data', [], 'id'));
    }
}
