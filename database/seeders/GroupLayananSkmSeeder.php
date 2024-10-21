<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupLayananSkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // using faker
        $faker = \Faker\Factory::create();

        // generate group layanan skm
        for ($i = 0; $i < 5; $i++) {
            \App\Models\GroupLayananSkm::create([
                'nama' => $faker->sentence(2),
            ])->layananSkm()->createMany([
                [
                    'nama' => $faker->sentence(3),
                ],
                [
                    'nama' => $faker->sentence(3),
                ],
                [
                    'nama' => $faker->sentence(3),
                ],
            ]);
        }
    }
}
