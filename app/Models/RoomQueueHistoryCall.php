<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomQueueHistoryCall extends Model
{
    use HasFactory;

    protected $table = 'room_queue_history_calls';

    protected $fillable = [
        'room_id',
        'room_queue_id',
        'room_code',
        'number_queue',
        'number_code',
        'process_time_queue_room',
        'called_at',
        'awaiting_called_duration',
        'created_at',
        'updated_at'
    ];
}
