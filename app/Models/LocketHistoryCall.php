<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocketHistoryCall extends Model
{
    use HasFactory;

    protected $table = 'locket_history_call';

    protected $fillable = [
        'locket_code',
        'locket_number',
        'locket_staff_name',
        'number_queue',
        'process_time_queue_locket',
        'created_at',
        'updated_at'
    ];
}
