<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title',
        'place',
        'date',
        'description',
        'images',
        'coordinate_point',
        'dai_id',
        'koreksi_desa',
        'validasi_desa',
        'koreksi_kecamatan',
        'validasi_kecamatan'
    ];
    public function dai(){
        return $this->belongsTo(Dai::class);
    }
}
