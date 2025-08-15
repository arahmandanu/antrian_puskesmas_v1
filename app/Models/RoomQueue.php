<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomQueue extends Model
{
    use HasFactory;

    protected $table = 'room_queues';

    protected $fillable = [
        'room_code',
        'number_queue',
        'created_at',
        'updated_at'
    ];
}
