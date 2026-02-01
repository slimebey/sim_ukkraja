<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategoris',
        'ket_kategoris',
    ];

  
    public function inputAspirasis()
    {
        return $this->hasMany(InputAspirasi::class, 'kategoris_id');
    }
}