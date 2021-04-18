<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = "proceso";
    protected $primaryKey = "idProceso";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nroEnEmpresa','descripcionProceso','idEmpresa','nombreProceso'];

        public function empresa(){
            return $this->hasOne('App\Empresa','idEmpresa','idEmpresa');
        }

        public function nombre(){
            return $this->nombreProceso;
        }
        public function id(){
            return $this->idProceso;
        }

}
