<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';

    protected $fillable = [
        'nama_layanan',
        'harga_per_kg',
        'estimasi_waktu',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'layanan_id');
    }
}