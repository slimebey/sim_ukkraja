<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model 
{
    use HasFactory;

   
    protected $fillable = [
        'nisn',   
        'password',  
        'nama',
        'kelas',
        'jurusan',  
    ];

    protected $hidden = [
        'password',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'nisn', 'username');
    }

    public function inputAspirasis()
    {
        return $this->hasMany(inputaspirasi::class, 'id_siswas');
    }
}