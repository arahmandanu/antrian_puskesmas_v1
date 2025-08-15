<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'code',
        'name',
        'current_queue',
        'number_display',
        'show',
        'lantai',
        'staff_name',
        'last_call_queue',
        'last_call_time',
    ];
}
