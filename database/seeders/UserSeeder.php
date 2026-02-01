<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@crm.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Susan',
                'email' => 'marketing1@crm.com',
                'password' => Hash::make('password'),
                'role' => 'marketing1',
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('✅ Users berhasil di-seed!');
    }
}
