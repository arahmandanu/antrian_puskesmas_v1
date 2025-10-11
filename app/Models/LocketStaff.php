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
        'lantai',
        'allowed_codes',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'allowed_codes' => 'array', // otomatis ubah JSON <-> array
    ];

    public function canCreateLocket()
    {
        // Logic to determine if a new locket can be created
        return $this->count() < config('mysite.total_loket');
    }

    public function availableLocket(?int $except = null)
    {
        // Logic to get available locket
        if ($except) {
            return array_diff(range(1, config('mysite.total_loket')), $this->where('locket_number', '!=', $except)->pluck('locket_number')->toArray());
        }

        $usedLocket = $this->all()->pluck('locket_number')->toArray();
        return array_diff(range(1, config('mysite.total_loket')), $usedLocket);
    }

    public function canHandle(string $code): bool
    {
        return in_array($code, $this->allowed_codes ?? []);
    }
}
