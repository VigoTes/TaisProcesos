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


        public function getListaIndicadores(){
            return Indicador::where('idProceso','=',$this->idProceso)->get();

        }

        public function getCantidadIndicadores(){

            return count($this->getListaIndicadores());
        }
        public function getEmpresa(){

            return Empresa::findOrFail($this->idEmpresa);

        }
        public function getListaSubprocesos(){
            return Subproceso::where('idProceso','=',$this->idProceso)->get();

        }
        public function empresa(){
            return $this->hasOne('App\Empresa','idEmpresa','idEmpresa');
        }

        public function nombre(){
            return $this->nombre;
        }
        public function id(){
            return $this->idProceso;
        }

}
