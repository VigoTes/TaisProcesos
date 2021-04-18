<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    public $table = "usuario";
    protected $primaryKey = 'codUsuario';
    public $timestamps = false;

    protected $fillable = [
        'usuario', 'email', 'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function empleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\Empleado','codUsuario','codUsuario');//el tercer parametro es de Producto
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
