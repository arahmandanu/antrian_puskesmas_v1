<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocketHistoryCall extends Model
{
    use HasFactory;

    protected $table = 'locket_history_call';

    protected $fillable = [
        'locket_queue_id',
        'locket_code',
        'locket_number',
        'locket_staff_id',
        'locket_staff_name',
        'number_queue',
        'process_time_queue_locket',
        'called_at',
        'awaiting_called_duration',
        'created_at',
        'updated_at'
    ];

    public function staff()
    {
        return $this->belongsTo(LocketStaff::class, 'locket_staff_id');
    }
}
