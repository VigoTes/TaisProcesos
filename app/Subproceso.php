<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subproceso extends Model
{
    protected $table = "subproceso";
    protected $primaryKey = "idSubproceso";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nroEnProceso','nombre','idProceso'];

        public function getListaIndicadores(){
            return Indicador::where('idSubproceso','=',$this->idSubproceso)->get();

        }

        public function getCantidadIndicadores(){
            return count($this->getListaIndicadores());
        }


        public function getEmpresa(){
            return $this->getProceso()->getEmpresa();
        }
        public function getProceso(){
            return Proceso::findOrFail($this->idProceso);
        }

        public function proceso(){
            return $this->hasOne('App\Proceso','idProceso','idProceso');
        }
        public function nombre(){
            return $this->nombre;
        }
        public function id(){
            return $this->idSubproceso;
        }
}
