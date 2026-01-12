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
                'name' => 'Admin System',
                'email' => 'admin@crm.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Marketing Lead Manager',
                'email' => 'marketing1@crm.com',
                'password' => Hash::make('password'),
                'role' => 'marketing1',
            ],
            [
                'name' => 'Marketing Contact Manager',
                'email' => 'marketing2@crm.com',
                'password' => Hash::make('password'),
                'role' => 'marketing2',
            ],
            [
                'name' => 'Marketing Email Manager',
                'email' => 'marketing3@crm.com',
                'password' => Hash::make('password'),
                'role' => 'marketing3',
            ],
            [
                'name' => 'Marketing Calendar Manager',
                'email' => 'marketing4@crm.com',
                'password' => Hash::make('password'),
                'role' => 'marketing4',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('✅ Users berhasil di-seed!');
    }
}
