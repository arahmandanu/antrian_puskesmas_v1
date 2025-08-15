<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocketStaff extends Model
{
    use HasFactory;

    protected $table = 'locket_staff';

    protected $fillable = [
        'staff_name',
        'locket_number',
        'created_at',
        'updated_at'
    ];
}
