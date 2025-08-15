<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocketCall extends Model
{
    use HasFactory;

    protected $table = 'locket_call';

    protected $fillable = [
        'number_queue',
        'locket_code',
        'called',
        'created_at',
        'updated_at'
    ];
}
