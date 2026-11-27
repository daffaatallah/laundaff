<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan', 50);
            $table->integer('harga_per_kg');
            $table->string('estimasi_waktu', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
