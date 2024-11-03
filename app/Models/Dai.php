<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dai extends Model
{
    protected $fillable = ['nik','nama','tempat_lahir','tanggal_lahir','alamat','pendidikan_akhir','status_kawin','foto_dai'];
    
}
