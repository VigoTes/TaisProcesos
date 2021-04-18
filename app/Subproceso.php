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
