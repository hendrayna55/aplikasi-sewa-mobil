<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMobil extends Model
{
    use HasFactory;

    protected $table = 'data_mobils';
    protected $guarded = ['id'];

    public function peminjamans(){
        return $this->hasMany(DataPeminjaman::class, 'mobil_id');
    }
}
