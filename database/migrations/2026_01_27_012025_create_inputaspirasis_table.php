<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inputaspirasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelaporan')->constrained('aspirasis', 'id_pelaporan');
            $table->foreignId('kategoris_id')->constrained('kategoris');
            $table->foreignId('id_siswas')->constrained('siswas');           
            $table->string('lokasi', 50);
            $table->text('ket');
            $table->datetime('tanggal_lapor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */  
    public function down(): void
    {
        Schema::dropIfExists('inputaspirasis');
    }
};