<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Camping;

class CampingSeeder extends Seeder
{
    public function run()
    {
        Camping::create([
            'name' => 'Camping Montaña Verde',
            'location' => 'Pirineos',
            'description' => 'Un camping acogedor en plena naturaleza.',
        ]);

        Camping::create([
            'name' => 'Camping Playa Azul',
            'location' => 'Costa Brava',
            'description' => 'Camping frente al mar con muchas actividades.',
        ]);
    }
}
