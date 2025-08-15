<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomQeueueCall extends Model
{
    use HasFactory;

    protected $table = 'room_queue_calls';

    protected $fillable = [
        'room_code',
        'number_queue',
        'called',
        'created_at',
        'updated_at'
    ];
}
