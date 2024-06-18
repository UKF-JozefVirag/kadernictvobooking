<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        for ($i = 0; $i < 10; $i++) {

            DB::table('services')->insert([
                'name' => Str::random(10),
                'desc' => Str::random(20),
                'price' => rand(1,20),
            ]);
            DB::table('employees')->insert([
                'first_name' => Str::random(10),
                'last_name' => Str::random(10),
                'image' => Str::random(10),
                'phone_number' => Str::random(10),
                'email' => Str::random(10).'@gmail.com'
            ]);


        }


    }
}
