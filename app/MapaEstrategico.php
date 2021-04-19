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

    
    public function getCadenaParaVerMapa(){
        if($this->esDeProceso()){
            $cad = $this->idProceso."*1";

        }else{
            $cad = $this->idSubproceso."*0";
        return $cad;
            
    }
    public function esDeProceso(){
        if($this->idSubproceso=="" || is_null($this->idSubproceso=="") )
            return true;

        return false;
    }

    public function esDeSubproceso(){
        return !$this->esDeProceso();

    }
    public function getStringTipo(){
        if( $this->esDeProceso())
            return "Proceso";

        return "Subproceso";

    }

    //retorna el nombre del subproceso o proceso al que pertenece
    public function getNombreProSub(){
        if( $this->esDeProceso())
            return Proceso::findOrFail($this->idProceso)->nombre;
        
        return Proceso::findOrFail($this->idSubproceso)->nombre;

    }

}
