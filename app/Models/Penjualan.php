<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PenjualanProduk;
use App\Models\ManjemenBarang as ManajemenBarang;
use App\Models\User;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = ['tanggal', 'total_harga', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penjualanProduk()
    {
        return $this->hasMany(PenjualanProduk::class, 'penjualan_id');
    }
    
    public function produk()
    {
        return $this->belongsToMany(ManajemenBarang::class, 'penjualan_produk', 'penjualan_id', 'produk_id')->withPivot('jumlah', 'harga_saat_itu')->withTimestamps();
    }
}
