<?php

namespace App\Http\Resources;

use App\Models\LocketStaff;
use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TicketCallerResource extends JsonResource
{
    protected $owner;

    public function __construct($resource, $owner = null)
    {
        parent::__construct($resource);
        $this->owner = $owner;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($ticket)
    {
        $data = parent::toArray($ticket);
        if ($this->type == 'poli') {
            $owner = Room::where('code', $this->number_code)->first();
            $data['sound'] = [
                asset('sound/ruang.mp3'),
                asset('sound/' .  Str::lower($owner->name) . '.mp3'),
            ];
        } else {
            $owner = LocketStaff::where('id', $this->owner_id)->first();
            $data['sound'] = [
                asset('sound/loket.mp3'),
                asset('sound/' . Str::lower($owner->locket_number) . '.mp3'),
            ];
        }
        return $data;
    }
}
