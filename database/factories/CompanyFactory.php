<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'active' => true,
            'logo' => $this->faker->imageUrl(100, 100, 'business', true, 'logo'),
            'printer' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
