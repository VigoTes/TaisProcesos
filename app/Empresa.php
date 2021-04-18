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

    
        public function matricesDeLaEmpresa(){
          //aqui haremos la union de empresas
          $listaEmpresass = Matriz::where('idEmpresa','=',$this->idEmpresa  )->get();
          //aqui ya tenemos la lista de matrices de esta empresa

          return $listaEmpresass;
      }


}
