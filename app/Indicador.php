<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $table = "indicador";
    protected $primaryKey ="idIndicador";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['idProceso','idSubproceso','P_QueMedira','P_QuienMedira',
        'P_Mecanismos','P_Tolerancia','P_QueSeHara','formula'];


    public function esDeProceso(){
        if($this->idSubproceso=="" || is_null($this->idSubproceso=="") )
            return true;

        return false;
    }

    public function esDeSubproceso(){
        return !$this->esDeProceso();

    }

    public function getCompletarNombre(){
        $mensaje = "";

        if($this->esDeProceso())
            $mensaje = " proceso '".$this->getProceso()->nombre."'";
        else 
            $mensaje = " subproceso '".$this->getSubproceso()->nombre."'";

        return $mensaje;

    }

    public function getProceso(){
        return Proceso::findOrFail($this->idProceso);
    }
    public function getSubproceso(){
        return Subproceso::findOrFail($this->idSubproceso);
    }
    
    public function getProcesoSuperior(){
        if($this->esDeProceso())
            return $this->getProceso();
        else 
            return $this->getSubproceso()->getProceso();

    }

    public function getEmpresa(){
        return $this->getProcesoSuperior()->getEmpresa();

    }
    public function volverAlListar(){
        if($this->esDeProceso())
            return route('proceso.verIndicadores',$this->idProceso);
        else
            return route('subproceso.verIndicadores',$this->idSubproceso);


    }
}
