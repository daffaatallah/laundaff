<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan', 100);
            $table->string('no_hp', 20);
            $table->foreignId('layanan_id')->constrained('layanans')->restrictOnDelete();
            $table->decimal('berat_kg', 5, 2);
            $table->integer('total_harga');
            $table->enum('status_pengerjaan', ['Proses', 'Selesai'])->default('Proses');
            $table->timestamp('tanggal_masuk')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};