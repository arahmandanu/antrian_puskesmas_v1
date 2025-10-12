<?php

namespace App\Http\Resources\Locket;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Locket\LocketQueueResource;

class LocketStaffResource extends JsonResource
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
            'type' => 'locket',
            'staff_name' => $this->staff_name,
            'locket_number' => $this->locket_number,
            'display_name' => $this->generateDisplayName($this->staff_name, $this->locket_number),
            'lantai' => $this->lantai,
            'allowed_codes' => $this->allowed_codes,
            'last_queue' => $this->whenLoaded('lastCalledQueue', fn() => (new LocketQueueResource($this->lastCalledQueue))->toArray($request)) ?? null,
        ];
    }

    private function generateDisplayName($name, $locketNumber)
    {
        return (isset($locketNumber)
            ? "{$name} {$locketNumber}"
            : $name);
    }
}
