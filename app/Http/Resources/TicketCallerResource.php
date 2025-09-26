<?php

namespace App\Http\Resources;

use App\Models\LocketStaff;
use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TicketCallerResource extends JsonResource
{
    protected $owner;
    private $listSound = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => 'sepuluh',
        '11' => 'sebelas',
        'se' => 'se',
        'seratus' => 'seratus',
        'puluh' => 'puluh',
        'ratus' => 'ratus',
        'belas' => 'belas',
    ];
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

        $data['middle_sound'] = $this->formatSoundArray($this->numberToSound($this->number_queue));

        return $data;
    }

    private function numberToSound($number)
    {
        $sound = [];
        $number = (int) $number;
        // 1 digit
        if ($number < 10) {
            $sound[] = $this->listSound[(string) $number];
        }

        // Belasan & 10/11 special case
        elseif ($number < 20) {
            if ($number == 10 || $number == 11) {
                $sound[] = $this->listSound[(string) $number];
            } else {
                $sound[] = $this->listSound[(string) ($number % 10)];
                $sound[] = $this->listSound['belas'];
            }
        }

        // Puluhan
        elseif ($number < 100) {
            $sound[] = $this->listSound[(string) floor($number / 10)];
            $sound[] = $this->listSound['puluh'];

            $remainder = $number % 10;
            // dd($remainder);
            if ($remainder > 0) {
                $sound = array_merge($sound, $this->numberToSound($remainder));
            }
        }

        // Ratusan
        elseif ($number < 1000) {
            $hundreds = floor($number / 100);
            if ($hundreds == 1) {
                $sound[] = $this->listSound['seratus'];
            } else {
                $sound[] = $this->listSound[(string) $hundreds];
                $sound[] = $this->listSound['ratus'];
            }

            $remainder = $number % 100;
            if ($remainder > 0) {
                $sound = array_merge($sound, $this->numberToSound($remainder));
            }
        }

        return $sound;
    }

    private function formatSoundArray($array)
    {
        $formatedSound = [];
        foreach ($array as $item) {
            $formatedSound[] = asset('sound/' . $item . '.mp3');
        }
        return $formatedSound;
    }
}
