<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    
    protected $table = "rol";
    protected $primaryKey = "idRol";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = ['idRol','nombre','descripcion'];

    public function verificarPermiso($nombre){
        $permisos = Permiso::where('nombre','=',$nombre)->get();
        if(count($permisos) == 0)
            return false;

        $permiso = $permisos[0];
        

        $lista = PermisoRol::where('idRol','=',$this->idRol)
            ->where('idPermiso','=',$permiso->idPermiso)
            ->get();
        
        if(count($lista) == 0 )
            return false;

        return true;

    }
    

}
