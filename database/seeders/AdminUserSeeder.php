<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bachatbooket.com'],
            [
                'name' => 'admiin_booklet',
                'password' => Hash::make('BB@@1800'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin user created successfully!');
    }
}
