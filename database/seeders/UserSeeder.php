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
                'name' => 'User',
                'email' => 'user@example.com',
                'role_id' => 3,
            ],
            [
                'name' => 'Verifikator',
                'email' => 'verifikator@example.com',
                'role_id' => 2,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate($user, [
                'password' => bcrypt('P@ssw0rd'),
                'is_filled_data_register' => true,
            ]);
        }
    }
}
