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
    Schema::create('aspirasis', function (Blueprint $table) {
        $table->id('id_pelaporan');
        $table->enum('status', ['menunggu', 'proses', 'selesai']);      
        $table->text('feedback')->nullable();
        $table->timestamp('tanggal_feedback')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('aspirasis');
}
};