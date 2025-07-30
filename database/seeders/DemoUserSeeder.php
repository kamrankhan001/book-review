<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Demo User',
            'email' => 'demouser@kamrankhan.dev',
            'email_verified_at' => now(),
            'password' => Hash::make('demouser'),
            'remember_token' => Str::random(10),
        ]);
    }
}
