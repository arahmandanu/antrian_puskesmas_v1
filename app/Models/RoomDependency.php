<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomDependency extends Model
{
    use HasFactory;

    protected $table = 'room_dependencies';

    protected $fillable = [
        'room_id',
        'required_room_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function dependentRoom()
    {
        return $this->belongsTo(Room::class, 'required_room_id', 'id');
    }
}
