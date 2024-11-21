<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dai extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'pendidikan_akhir',
        'status_kawin',
        'foto_dai',
        'user_id',
        'desa_id',
        ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function reports(){
        return $this->hasMany(Report::class);
    }
    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}
