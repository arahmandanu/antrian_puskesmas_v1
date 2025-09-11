<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LastCallTicketResource extends JsonResource
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
            'number_code' => $this->number_code,
            'number_queue' => $this->number_queue,
            'type' => $this->type,
            'owner_id' => $this->owner_id,
            'called' => $this->called,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
