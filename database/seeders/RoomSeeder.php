<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =  [
            [
                'name' => 'TB',
                'code' => 'D',
                'lantai' => 2,
            ],
            [
                'name' => 'IMS',
                'code' => 'E',
                'lantai' => 2,
            ],
            [
                'name' => 'FARMASI',
                'code' => 'F',
                'lantai' => 2,
            ],
            [
                'name' => 'SURVEILANS',
                'code' => 'G',
                'lantai' => 2,
            ],
            [
                'name' => 'BPU',
                'code' => 'H',
                'lantai' => 2,
            ],
            [
                'name' => 'GIGI',
                'code' => 'I',
                'lantai' => 2,
            ],
            [
                'name' => 'LAB',
                'code' => 'J',
                'lantai' => 2,
            ],
            [
                'name' => 'LANSIA',
                'code' => 'K',
                'lantai' => 2,
            ],
            [
                'name' => 'CATEN',
                'code' => 'L',
                'lantai' => 2,
            ],
            [
                'name' => 'PSIKOLOG',
                'code' => 'M',
                'lantai' => 2,
            ],
            [
                'name' => 'HAJI',
                'code' => 'N',
                'lantai' => 2,
            ],
            [
                'name' => 'AKUPRESUR',
                'code' => 'O',
                'lantai' => 2,
            ],
            [
                'name' => 'PTM',
                'code' => 'P',
                'lantai' => 2,
            ],
            [
                'name' => 'MTBS',
                'code' => 'Q',
                'lantai' => 2,
            ],
            [
                'name' => 'PKPR',
                'code' => 'R',
                'lantai' => 2,
            ],
            [
                'name' => 'JIWA GIZI',
                'code' => 'S',
                'lantai' => 2,
            ]
        ];
        foreach ($data as $value) {
            Room::create($value);
        }
    }
}
