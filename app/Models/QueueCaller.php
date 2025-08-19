<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueCaller extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'number_code',
        'called',
        'type',
        'lantai',
        'number_queue',
        'initiator_name',
        'called_to',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'called' => 'boolean',
    ];

    public function isExistPendingByOwnerid($ownerId)
    {
        return $this->where('owner_id', $ownerId)
            ->where('called', false)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->limit(1)
            ->first();
    }

    public function scopeNextCalledByLantai($query, $lantai)
    {
        return $query
            ->where('lantai', $lantai)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('called', false)
            ->orderBy('id', 'asc');
    }

    public function scopeLastCalled($query, $lantai, $limit = 10)
    {
        return $query
            ->where('lantai', $lantai)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('called', true)
            ->limit($limit)
            ->orderBy('id', 'asc');
    }
}
