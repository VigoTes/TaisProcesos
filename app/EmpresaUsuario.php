<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rol;
class EmpresaUsuario extends Model
{
    protected $table = "empresausuario";
    protected $primaryKey = 'idAI';

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = [
            'idEmpleado', 'idEmpresa','idRol'
    ];

    public function getRol(){
        return Rol::findOrFail($this->idRol);
    }

    public function getEmpleado(){
        return Empleado::findOrFail($this->idEmpleado);

    }
    public function getEmpresa(){
        return Empresa::findOrFail($this->idEmpresa);

    }
    
}
