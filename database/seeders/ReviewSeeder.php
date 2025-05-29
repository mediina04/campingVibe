<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Review::create([
            'user_id' => 2,
            'camping_id' => 1,
            'rating' => 4,
            'comment' => 'Muy tranquilo y limpio. Repetiremos.'
        ]);

        \App\Models\Review::create([
            'user_id' => 2,
            'camping_id' => 2,
            'rating' => 5,
            'comment' => '¡Increíble experiencia frente al mar!'
        ]);
    }
}
