<?php

namespace App\Http\Resources\Room;

use App\Http\Resources\Room\RoomQueueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'lantai' => $this->lantai,
            'display_name' => $this->name,
            'show' => $this->show,
            'type' => 'poli',
            'current_queue' => $this->current_queue,
            'last_queue' => $this->whenLoaded('lastQueue', function () {
                return (new RoomQueueResource($this->lastQueue))->toArray(request());
            }),
        ];
    }
}
