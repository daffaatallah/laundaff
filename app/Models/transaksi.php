<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'layanan_id',
        'berat_kg',
        'total_harga',
        'status_pengerjaan',
        'tanggal_masuk',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}