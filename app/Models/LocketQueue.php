<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocketQueue extends Model
{
    use HasFactory;

    protected $table = 'locket_queue';

    protected $fillable = [
        'locket_code',
        'number_queue',
        'created_at',
        'updated_at'
    ];

    public function locketTotal()
    {
        return $this->select('locket_code', \DB::raw('count(*) as total'))
            ->groupBy('locket_code')
            ->get();
    }
}
