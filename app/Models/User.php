<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'image',
        'email',
        'password',
        'level',
        'token_firebase',
    ];
    public function kecamatan(){
        return $this->hasOne(Kecamatan::class);
    }
    public function desa(){
        return $this->hasOne(Desa::class);
    }
    public function dai(){
        return $this->hasOne(Dai::class);
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isKecamatan(){
        return $this->level =='kecamatan';
    }
    public function isDai(){
        return $this->level == 'dai';
    }
    public function isDesa(){
        return $this->level == 'desa';
    }



    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
