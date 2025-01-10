<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $fillable=[
        'nama_desa',
        'nama_kepala',
        'no_telp_desa',
        'user_id',
        'kecamatan_id',
    ];
    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class);
    }
    public function dai(){
        return $this->hasMany(Dai::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
