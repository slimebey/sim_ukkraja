<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model 
{
    use HasFactory;

    protected $table = 'inputaspirasis'; 
    protected $fillable = [
        'id_pelaporan',
        'kategoris_id',
        'id_siswas',
        'lokasi',
        'ket',
        'tanggal_lapor',
    ];

    protected $casts = [
        'tanggal_lapor' => 'datetime',
    ];

    
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoris_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswas');
    }
}