<?php

namespace App\Models;

use App\Helpers\DateRangeHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomQueue extends Model
{
    use HasFactory;

    protected $table = 'room_queues';

    protected $casts = [
        'called' => 'boolean',
    ];

    protected $fillable = [
        'room_code',
        'number_queue',
        'called',
        'created_at',
        'updated_at',
        'status'
    ];

    public function isExistByCode($roomCode, $numberQueue)
    {
        return $this
            ->where('room_code', '=', $roomCode)
            ->where('number_queue', $numberQueue)
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
            ->first();
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_code', 'code');
    }

    public function formatAsQueueNumber()
    {
        return $this->room_code . $this->number_queue;
    }
}
