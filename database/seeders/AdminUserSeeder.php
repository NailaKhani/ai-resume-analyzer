<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@resumeai.com'],
            [
                'name'     => 'Super Admin',
                'email'    => 'admin@resumeai.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Admin account created: admin@resumeai.com / admin123');
    }
}
