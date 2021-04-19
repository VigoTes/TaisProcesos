<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapaEstrategico extends Model
{
    protected $table = "mapaEstrategico";
    protected $primaryKey = "idMapaEstrategico";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = ['idProceso','idSubproceso'];

    
    public function esDeProceso(){
        if($this->idSubproceso=="" || is_null($this->idSubproceso=="") )
            return true;

        return false;
    }

    public function esDeSubproceso(){
        return !$this->esDeProceso();

    }

}
