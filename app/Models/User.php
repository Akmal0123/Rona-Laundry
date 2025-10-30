<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_whatsapp',
        'alamat',
        'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Provide a computed property so existing views using nama_user still work
    public function getNamaUserAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
