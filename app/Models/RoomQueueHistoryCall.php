<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomQueueHistoryCall extends Model
{
    use HasFactory;

    protected $table = 'room_queue_history_calls';

    protected $fillable = [
        'room_code',
        'number_queue',
        'process_time_queue_room',
        'created_at',
        'updated_at'
    ];
}
