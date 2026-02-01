<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('adminbro'),
        ]);

        $siswas = [
            '12042008',
        ];

        foreach ($siswas as $nisn) {
            User::create([
                'username' => $nisn,
                'password' => Hash::make($nisn),
            ]);
        }
    }
}