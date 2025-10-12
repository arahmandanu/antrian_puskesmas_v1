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
            // LANTAI 1
            [
                'name' => '24 JAM',
                'code' => 'E',
                'lantai' => 1,
            ],
            [
                'name' => 'RB',
                'code' => 'F',
                'lantai' => 1,
            ],
            [
                'name' => 'IMS',
                'code' => 'G',
                'lantai' => 1,
            ],
            [
                'name' => 'PDP',
                'code' => 'H',
                'lantai' => 1,
            ],
            [
                'name' => 'TB',
                'code' => 'I',
                'lantai' => 1,
            ],

            // LANTAI 2
            [
                'name' => 'UMUM',
                'code' => 'J',
                'lantai' => 2,
            ],
            [
                'name' => 'Gigi',
                'code' => 'K',
                'lantai' => 2,
            ],
            [
                'name' => 'Laborate',
                'code' => 'L',
                'lantai' => 2,
            ],
            [
                'name' => 'Lansia',
                'code' => 'M',
                'lantai' => 2,
            ],
            [
                'name' => 'UBM',
                'code' => 'N',
                'lantai' => 2,
            ],
            [
                'name' => 'CATIN',
                'code' => 'O',
                'lantai' => 2,
            ],
            [
                'name' => 'Psikologi',
                'code' => 'P',
                'lantai' => 2,
            ],
            [
                'name' => 'Haji',
                'code' => 'Q',
                'lantai' => 2,
            ],
            [
                'name' => 'PTM',
                'code' => 'R',
                'lantai' => 2,
            ],
            [
                'name' => 'MTBS',
                'code' => 'S',
                'lantai' => 2,
            ],
            [
                'name' => 'PKPR',
                'code' => 'T',
                'lantai' => 2,
            ],
            [
                'name' => 'Jiwa',
                'code' => 'U',
                'lantai' => 2,
            ],
            [
                'name' => 'Gizi',
                'code' => 'V',
                'lantai' => 2,
            ],
            [
                'name' => 'CKG',
                'code' => 'W',
                'lantai' => 2,
            ],
            [
                'name' => 'Nurse Station',
                'code' => 'X',
                'lantai' => 2,
            ]
        ];
        foreach ($data as $value) {
            Room::create($value);
        }
    }
}
