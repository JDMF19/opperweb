<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['nombre', 'email', 'password'];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function api_user(){
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
        ];
    }


}
