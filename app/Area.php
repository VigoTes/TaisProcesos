<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "area";
    protected $primaryKey = "idArea";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nroEnEmpresa','descripcionArea','idEmpresa','nombreArea'];

        public function empresa(){
            return $this->hasOne('App\Empresa','idEmpresa','idEmpresa');
        }

        public function nombre(){
            return $this->nombreArea;
        }
        public function id(){
            return $this->idArea;
        }

}
