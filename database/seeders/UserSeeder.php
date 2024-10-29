<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Emmanuel Baleztena',
            'email' => 'emma@gmail.com',
            'password' => Hash::make('123'),
        ]);
        User::create([
            'name' => 'Doctor Amado',
            'email' => 'amado@gmail.com',
            'password' => Hash::make('123'),
        ]);
        User::create([
            'name' => 'Administrativa',
            'email' => 'administrativa@gmail.com',
            'password' => Hash::make('123'),
        ]);
        User::create([
            'name' => 'facturador OS',
            'email' => 'facturador@gmail.com',
            'password' => Hash::make('123'),
        ]);
    }
}
