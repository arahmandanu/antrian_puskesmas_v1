<?php

namespace App\Http\Resources\Locket;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\MyHelper;

class LocketQueueResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = parent::toArray($request);
        $data['number_queue'] = MyHelper::formatNumberQueue($this->number_queue);
        $data['code_queue'] = $this->locket_code;
        $data['display_queue'] = $this->locket_code . MyHelper::formatNumberQueue($this->number_queue);
        return $data;
    }
}
