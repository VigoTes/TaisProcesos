<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = "puesto";
    protected $primaryKey = "idPuesto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nroEnArea','nombre','idArea'];

        public function proceso(){
            return $this->hasOne('App\Area','idArea','idArea');
        }

        public function nombre(){
            return $this->nombre;
        }
        public function id(){
            return $this->idPuesto;
        }

}
