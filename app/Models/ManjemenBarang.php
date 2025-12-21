<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\PenjualanProduk;

class ManjemenBarang extends Model
{
    use HasFactory;

    protected $table = 'manajemenbarang';

    protected $fillable = [
        'namaproduk',
        'kategori',
        'harga',
    ];

    public function penjualanProduk()
    {
        return $this->hasMany(PenjualanProduk::class, 'produk_id');
    }
}
