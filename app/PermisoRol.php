<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
    protected $table = "permisoRol";
    protected $primaryKey ="idPermisoRol";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    // le indicamos los campos de la tabla 
    protected $fillable = ['idPermiso','idRol'];

    public function getPermiso(){
        return Permiso::findOrFail($this->idPermiso);
    }
    
    public function getRol(){
        return Rol::findOrFail($this->idRol);
    }

}
