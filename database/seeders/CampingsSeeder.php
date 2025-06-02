<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('campings')->insert([
            [
                'name' => 'Camping El Escorial',
                'location' => 'Madrid, Comunidad de Madrid',
                'description' => 'Camping familiar con piscinas y muchas instalaciones al norte de Madrid.',
                'rating_avg' => 4.2,
                'website_url' => 'https://www.campingelescorial.com',
                'images' => json_encode([
                    '/images/CampingImg/Escorial1.jpg',
                    '/images/CampingImg/Escorial2.jpg',
                    '/images/CampingImg/Escorial3.jpg',
                    '/images/CampingImg/Escorial4.jpg',
                ]),
            ],
            [
                'name' => 'Camping Playa Joyel',
                'location' => 'Noja, Cantabria',
                'description' => 'Camping junto a la playa en Cantabria, ideal para vacaciones familiares.',
                'rating_avg' => 4.4,
                'website_url' => 'https://www.playajoyel.com',
                'images' => json_encode([
                    '/images/CampingImg/Joyel1.jpg',
                    '/images/CampingImg/Joyel2.jpg',
                    '/images/CampingImg/Joyel3.jpg',
                    '/images/CampingImg/Joyel4.jpg',
                ]),
            ],
            [
                'name' => 'Camping La Ballena Alegre',
                'location' => 'Sant Pere Pescador, Girona, Cataluña',
                'description' => 'Uno de los campings más conocidos de la Costa Brava, con acceso directo a la playa.',
                'rating_avg' => 4.6,
                'website_url' => 'https://www.ballena-alegre.com',
                'images' => json_encode([
                    '/images/CampingImg/Ballena1.jpg',
                    '/images/CampingImg/Ballena2.jpg',
                    '/images/CampingImg/Ballena3.jpg',
                    '/images/CampingImg/Ballena4.jpg',
                ]),
            ],
            [
                'name' => 'Camping Las Dunas',
                'location' => 'Sant Pere Pescador, Girona, Cataluña',
                'description' => 'Camping de gran capacidad frente al mar, ideal para familias y grupos.',
                'rating_avg' => 4.5,
                'website_url' => 'https://www.campinglasdunas.com',
                'images' => json_encode([
                    '/images/CampingImg/Dunas1.jpg',
                    '/images/CampingImg/Dunas2.jpg',
                    '/images/CampingImg/Dunas3.jpg',
                    '/images/CampingImg/Dunas4.jpg',
                ]),
            ],
            [
                'name' => 'Camping Cabopino',
                'location' => 'Marbella, Málaga, Andalucía',
                'description' => 'Camping con bungalows y parcelas cerca del mar en la Costa del Sol.',
                'rating_avg' => 4.3,
                'website_url' => 'https://www.campingcabopino.com',
                'images' => json_encode([
                    '/images/CampingImg/Cabopino1.jpg',
                    '/images/CampingImg/Cabopino2.jpg',
                    '/images/CampingImg/Cabopino3.jpg',
                    '/images/CampingImg/Cabopino4.jpg',
                    '',
                ]),
            ],
            [
                'name' => 'Camping Aínsa',
                'location' => 'Aínsa, Huesca, Aragón',
                'description' => 'Camping en el Pirineo Aragonés, cerca del Parque Nacional de Ordesa.',
                'rating_avg' => 4.7,
                'website_url' => 'https://www.campingainsa.com',
                'images' => json_encode([
                    '/images/CampingImg/Ainsa1.jpg',
                    '/images/CampingImg/Ainsa2.jpg',
                    '/images/CampingImg/Ainsa3.jpg',
                    '/images/CampingImg/Ainsa4.jpg',
                ]),
            ],
            [
                'name' => 'Camping El Delfín Verde',
                'location' => 'Torroella de Montgrí, Girona, Cataluña',
                'description' => 'Gran camping resort con múltiples piscinas y acceso a la playa.',
                'rating_avg' => 4.6,
                'website_url' => 'https://www.eldelfinverde.com',
                'images' => json_encode([
                    '/images/CampingImg/Delfin1.jpg',
                    '/images/CampingImg/Delfin2.jpg',
                    '/images/CampingImg/Delfin3.jpg',
                    '/images/CampingImg/Delfin4.jpg',
                ]),
            ],
            [
                'name' => 'Camping Internacional de Aranjuez',
                'location' => 'Aranjuez, Comunidad de Madrid',
                'description' => 'Camping cerca del Palacio Real de Aranjuez con zona de piscina.',
                'rating_avg' => 4.1,
                'website_url' => 'https://www.campingaranjuez.com',
                'images' => json_encode([
                    '/images/CampingImg/Aranjuez1.jpg',
                    '/images/CampingImg/Aranjuez2.jpg',
                    '/images/CampingImg/Aranjuez3.jpg',
                    '/images/CampingImg/Aranjuez4.jpg',
                ]),
            ],
            [
                'name' => 'Camping Río Mundo',
                'location' => 'Riopar, Albacete, Castilla-La Mancha',
                'description' => 'Camping en plena Sierra del Segura, ideal para senderismo y naturaleza.',
                'rating_avg' => 4.4,
                'website_url' => 'https://www.campingriomundo.com',
                'images' => json_encode([
                    '/images/CampingImg/Rmundo1.jpg',
                    '/images/CampingImg/Rmundo2.jpg',
                    '/images/CampingImg/Rmundo3.jpg',
                    '/images/CampingImg/Rmundo4.jpg',
                ]),
            ],
            [
                'name' => 'Camping Valldaro',
                'location' => 'Platja d’Aro, Girona, Cataluña',
                'description' => 'Camping familiar cerca de las playas de la Costa Brava.',
                'rating_avg' => 4.3,
                'website_url' => 'https://www.valldaro.com',
                'images' => json_encode([
                    '/images/CampingImg/Valldaro1.jpg',
                    '/images/CampingImg/Valldaro2.jpg',
                    '/images/CampingImg/Valldaro3.jpg',
                    '/images/CampingImg/Valldaro4.jpg',
                ]),
            ],
        ]);
    }
}
