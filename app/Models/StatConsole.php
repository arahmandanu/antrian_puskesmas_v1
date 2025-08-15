<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatConsole extends Model
{
    use HasFactory;
    protected $table = 'stat_consoles';

    protected $fillable = [
        'tanggal',
        'Status',
        'ActiveDate',
        'created_at',
        'updated_at'
    ];
}
