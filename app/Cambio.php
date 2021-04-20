<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cambio extends Model
{
    protected $table = "cambio";
    protected $primaryKey = "idCambio";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = ['descripcion','idEmpresa','idEmpleado','fechaHora'];


    public function getEmpresa(){
        return Empresa::findOrFail($this->idEmpresa);

    }

    public function getEmpleado(){
        return Empleado::findOrFail($this->idEmpleado);
    }

    
    public static function registrarCambio($idEmpresa,$descripcion){
        
        $cambio = new Cambio();

        $cambio->fechaHora = Carbon::now();
        $cambio->idEmpresa = $idEmpresa;
        $cambio->idEmpleado = Empleado::getEmpleadoLogeado()->idEmpleado; 
        $cambio->descripcion = $descripcion;

        $cambio->save();
    }
    

}
