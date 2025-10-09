<?php

namespace App\Models;

use App\Enum\RoomQueueStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public const CODE = [
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    ];

    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'code',
        'name',
        'current_queue',
        'show',
        'lantai',
        'last_call_queue',
        'last_call_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'show' => 'boolean',
    ];

    public function queues()
    {
        return $this->hasMany(RoomQueue::class, 'room_code', 'code');
    }

    public function availableCodes($except = null)
    {
        if ($except) {
            $usedCode = self::where('code', '!=', $except)->pluck('code')->toArray();
        } else {
            $usedCode = self::all()->pluck('code')->toArray();
        }

        return array_diff(self::CODE, $usedCode);
    }

    public function listRoomCode()
    {
        return self::show()->get()->pluck("code");
    }

    public function queuesCalled()
    {
        return $this->hasMany(RoomQueue::class, 'room_code', 'code')->where('called', true)->where('status', RoomQueueStatus::COMPLETED)->orderBy('id', 'desc');
    }

    public function queuesNotCalled()
    {
        return $this->hasMany(RoomQueue::class, 'room_code', 'code')->where('status', RoomQueueStatus::COMPLETED)->where('called', false);
    }

    public function scopeShow($query)
    {
        return $query->where('show', '=', true);
    }

    public function scopeCanAddAsRequired($query, $currentRoomId)
    {
        return $query->where('id', '!=', $currentRoomId)
            ->where(function ($q) use ($currentRoomId) {
                $q->where(function ($sub) {
                    // Room yang bebas (tidak punya dependency, dan tidak dibutuhkan)
                    $sub->whereDoesntHave('dependencies')
                        ->whereDoesntHave('requiredBy');
                })
                    ->orWhereHas('requiredBy', function ($sub) use ($currentRoomId) {
                        // Room yang sudah jadi dependency dari room yang sedang diedit
                        $sub->where('room_id', $currentRoomId);
                    });
            });
    }

    public function dependencies()
    {
        return $this->belongsToMany(
            Room::class,
            'room_dependencies',
            'room_id',
            'required_room_id'
        )->withTimestamps();
    }

    public function requiredBy()
    {
        return $this->belongsToMany(
            Room::class,
            'room_dependencies',
            'required_room_id',
            'room_id'
        )->withTimestamps();
    }
}
