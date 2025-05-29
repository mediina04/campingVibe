<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Reservation::create([
            'user_id' => 2,
            'accommodation_id' => 1,
            'check_in' => '2025-05-31 08:12:24',
            'check_out' => '2025-06-04 08:12:24',
            'guests' => 2,
            'total_price' => 150.00,
            'status' => 'confirmed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
