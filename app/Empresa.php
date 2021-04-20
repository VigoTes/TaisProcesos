<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresa";
    protected $primaryKey = "idEmpresa";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nombreEmpresa','ruc','direccion',
        'mision','vision','factorDif','propuestaV','estadoAct'];
    
        /*
        tipoDeMatriz puede tener los valores
          1  PxA   Proceso vs Area
          2  PxP   Proceso vs Puesto
          3  SxA   Subpr vs Area
          4  SxP   Subpr vs Puesto
        */

    
        public static function getActivas(){
          //aqui haremos la union de empresas
          $listaEmpresass = Empresa::where('estadoAct','=','1')->get();
          //aqui ya tenemos la lista de matrices de esta empresa
          return $listaEmpresass;
      }
      
      //retorna lsita de los empleados que tienen acceso a esa empresa de alguna manera. RETORNA COLLECTION DE MODELO EmpresaUsuario
      public function getListaEmpleados(){
        return EmpresaUsuario::where('idEmpresa','=',$this->idEmpresa)->get();
      }

      public function tieneEmpleado($idEmpleado){
          $lista = EmpresaUsuario::where('idEmpleado','=',$idEmpleado)->get();
          return count($lista)>0;

      }

}
