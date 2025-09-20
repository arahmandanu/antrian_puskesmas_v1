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

    public function isExistPendingByOwnerid($ownerId, $type)
    {
        return $this->where('owner_id', $ownerId)
            ->where('type', $type)
            ->where('called', false)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->limit(1)
            ->first();
    }

    public function scopeLastCallByOwnerid($query, $ownerId, $type, $limit = 10)
    {
        return $query->where('owner_id', $ownerId)
            ->where('type', $type)
            ->where('called', true)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->limit($limit)
            ->orderBy('id', 'desc');
    }

    public function scopeNextCalledByLantai($query, $lantai)
    {
        return $query
            ->where('lantai', $lantai)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('called', false)
            ->orderBy('id', 'asc');
    }

    public function scopeLastCallByCode($query, $code, $limit = 10)
    {
        return $query
            ->where('number_code', $code)
            ->where('called', true)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->limit($limit)
            ->orderBy('id', 'desc');
    }

    public function scopeLastCalled($query, $lantai, $limit = 10)
    {
        return $query
            ->where('lantai', $lantai)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('called', true)
            ->limit($limit)
            ->orderBy('created_at', 'desc');
    }

    public function formatAsQueueNumber()
    {
        return $this->number_code . $this->number_queue;
    }
}
