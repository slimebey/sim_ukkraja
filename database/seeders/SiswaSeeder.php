<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = [
            [
                'nisn' => '12042008',
                'password' => Hash::make('12042008'), 
                'nama' => 'Raja',
                'kelas' => 'XII',
                'jurusan' => 'RPL'
            ],
            
        ];

        foreach ($siswas as $siswa) {
            Siswa::create($siswa);
        }
    }
}