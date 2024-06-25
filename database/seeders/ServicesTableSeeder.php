<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $src = '/src/assets/images/services/';
        $now = Carbon::now();
        $services = [
            [
                'id' => 1,
                'name' => 'Pánsky strih',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.',
                'price' => '15',
                'duration' => '30',
                'image' => $src . 'man-hair.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'Úprava brady',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit.',
                'price' => '10',
                'duration' => '15',
                'image' => $src . 'beard.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'name' => 'Pánsky strih a úprava brady',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.',
                'price' => '20',
                'duration' => '45',
                'image' => $src . 'beard-hair.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'name' => 'Holenie do hladka Hot Towel',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.',
                'price' => '12',
                'duration' => '20',
                'image' => $src . 'hot-towel.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'name' => 'Farbenie vlasov',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.',
                'price' => '20',
                'duration' => '30',
                'image' => $src . 'hair-brush.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 6,
                'name' => 'Starostlivosť o pleť',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.',
                'price' => '11.50',
                'duration' => '15',
                'image' => $src . 'cream.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 7,
                'name' => 'Depilácia uši a nosa voskom',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.',
                'price' => '5',
                'duration' => '10',
                'image' => $src . 'wax.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 8,
                'name' => 'Balíček Extra',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. Lorem ipsum dolor sit amet',
                'price' => '25',
                'duration' => '60',
                'image' => $src . 'pack-extra.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 9,
                'name' => 'Balíček Super',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit.',
                'price' => '32',
                'duration' => '75',
                'image' => $src . 'pack-super.png',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('services')->insert($services);
    }
}
