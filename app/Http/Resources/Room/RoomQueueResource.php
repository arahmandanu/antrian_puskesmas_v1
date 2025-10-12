<?php

namespace App\Http\Resources\Room;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\MyHelper;

class RoomQueueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['number_queue'] = MyHelper::formatNumberQueue($this->number_queue);
        $data['code_queue'] = $this->room_code;
        $data['display_queue'] = $this->room_code . MyHelper::formatNumberQueue($this->number_queue);
        return $data;
    }
}
