<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accommodation;

class AccommodationSeeder extends Seeder
{
    public function run(): void
    {
        $accommodations = [
            [
                'camping_id' => 1,
                'name' => 'Parcela estándar',
                'type' => 'parcela',
                'price_per_night' => 20,
                'capacity' => 4,
            ],
            [
                'camping_id' => 1,
                'name' => 'Bungalow estándar',
                'type' => 'bungalow',
                'price_per_night' => 60,
                'capacity' => 5,
            ],
            [
                'camping_id' => 1,
                'name' => 'Bungalow premium',
                'type' => 'bungalow',
                'price_per_night' => 80,
                'capacity' => 6,
            ],
        ];

        foreach ($accommodations as $accommodation) {
            Accommodation::create($accommodation);
        }
    }
}

