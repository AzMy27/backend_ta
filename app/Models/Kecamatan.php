<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable=[
        'nama_kecamatan',
        'nama_koordinator',
        'no_telp_koordinator',
        'user_id'
    ];
    public function desa(){
        return $this->hasMany(Desa::class);
    }
}
