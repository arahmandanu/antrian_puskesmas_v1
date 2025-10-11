<?php

namespace App\Models;

use App\Helpers\DateRangeHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;

class LocketQueue extends Model
{
    use HasFactory;

    protected $table = 'locket_queue';

    protected $fillable = [
        'locket_code',
        'locket_staff_id',
        'number_queue',
        'called',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'called' => 'boolean',
    ];

    public function scopeNextQueue($query, $locketCode)
    {
        return $query->where('locket_code', $locketCode)
            ->where('called', false)
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
            ->orderBy('id', 'asc');
    }

    public function scopeLastCallByLocketCode($query, $locketCode, $locketStaffId)
    {
        return $query->where('locket_code', $locketCode)
            ->where('locket_staff_id', $locketStaffId)
            ->where('called', true)
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
            ->orderBy('id', 'desc');
    }

    public function locketTotal()
    {
        return $this->select('locket_code', DB::raw('count(*) as total'))
            ->where('called', false)
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
            ->groupBy('locket_code')
            ->get();
    }

    public function getHistoryBy($locketStaffId)
    {
        return $this->where('called', true)
            ->where('locket_staff_id', $locketStaffId)
            ->whereBetween('created_at', DateRangeHelper::daysAgoToNow())
            ->limit(5)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function formatAsQueueNumber($withCode = true)
    {
        if (!$withCode) {
            return MyHelper::formatNumberQueue($this->number_queue);
        }
        return $this->locket_code . MyHelper::formatNumberQueue($this->number_queue);
    }
}
