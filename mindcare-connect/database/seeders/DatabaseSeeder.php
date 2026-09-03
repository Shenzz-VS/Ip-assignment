<?php

namespace Database\Seeders;

use App\Models\User;
use App\Factories\UserProfileFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run():void
    {
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@mindcare.com',
            'password'=> Hash::make('AdminPass123!'),
            'role' => 'admin',
        ]);
    }
}
