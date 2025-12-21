<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penjualan;
use App\Models\ManjemenBarang as ManajemenBarang;

class PenjualanProduk extends Model
{
    use HasFactory;

    protected $table = 'penjualan_produk';

    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'jumlah',
        'harga_saat_itu',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function produk()
    {
        return $this->belongsTo(ManajemenBarang::class, 'produk_id');
    }
}
