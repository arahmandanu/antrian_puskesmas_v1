<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LocketQueue extends Model
{
    use HasFactory;

    protected $table = 'locket_queue';

    protected $fillable = [
        'locket_code',
        'locket_number',
        'number_queue',
        'called',
        'created_at',
        'updated_at'
    ];

    public function scopeNextQueue($query, $locketCode)
    {
        return $query->where('locket_code', $locketCode)
            ->where('called', false)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->orderBy('id', 'asc');
    }

    public function scopeLastCallByLocketCode($query, $locketCode, $locketNumber)
    {
        return $query->where('locket_code', $locketCode)
            ->where('locket_number', $locketNumber)
            ->where('called', true)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->orderBy('id', 'desc');
    }

    public function locketTotal()
    {
        return $this->select('locket_code', DB::raw('count(*) as total'))
            ->where('called', false)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->groupBy('locket_code')
            ->get();
    }

    public function getHistoryBy($locketNumber)
    {
        return $this->where('called', true)
            ->where('locket_number', $locketNumber)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->limit(5)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
