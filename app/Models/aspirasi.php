<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelaporan';

    protected $fillable = [
        'status',
        'feedback',
        'tanggal_feedback',
    ];

    protected $casts = [
        'tanggal_feedback' => 'datetime',
    ];

    public function inputAspirasi() 
    {
        return $this->hasOne(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}