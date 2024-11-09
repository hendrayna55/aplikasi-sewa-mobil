<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'data_peminjamans';
    protected $guarded = ['id'];

    public function mobil(){
        return $this->belongsTo(DataMobil::class, 'mobil_id');
    }

    public function metode_pembayaran(){
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
    }

    public function peminjam(){
        return $this->belongsTo(User::class, 'peminjam_id');
    }
}
