<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueCaller extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_code',
        'called',
        'type',
        'lantai',
        'number_queue',
        'called_to',
        'created_at',
        'updated_at'
    ];


    public function scopeNextCalledByLantai($query, $lantai)
    {
        return $query
            ->where('lantai', $lantai)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('called', false)
            ->orderBy('id', 'asc');
    }
}
