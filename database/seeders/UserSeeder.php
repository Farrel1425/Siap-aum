<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Kambing Terbang',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'role_id' => 3,
            ],
            [
                'name' => 'Kambing Rebahan',
                'email' => 'verifikator@example.com',
                'password' => bcrypt('password'),
                'role_id' => 2,
            ],
            [
                'name' => 'Kambing Ganteng',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            $data = [
                'is_filled_data_register' => true,
            ];
            User::firstOrCreate($user, $data);
        }
    }
}
