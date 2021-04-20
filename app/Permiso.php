<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = "permiso";
    protected $primaryKey ="idPermiso";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];

    

}
