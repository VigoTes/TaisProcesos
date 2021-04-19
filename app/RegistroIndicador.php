<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroIndicador extends Model
{
    protected $table = "registro_indicador";
    protected $primaryKey ="idRegistro";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = [ 'nombrePeriodo', 'valor', 'idIndicador'];


    public function getIndicador(){
        return Indicador::findOrFail($this->idIndicador);
    }
    public function getColor(){

        $indicador = $this->getIndicador();
        //calculamos en que seccion está
        /* 
            SECCION 1  LIMITE INFERIOR   SECCION 2         LIMITE SUPERIOR SECCION 3


        
        */
        
    
        
        //bccomp Devuelve 0 si los dos operandos son iguales, 1 si el izquierdo es mayor que el derecho, de lo contrario -1.
        if( $this->valor < $indicador->limite1  ){
            $seccion=1;
        }elseif( $this->valor <  $indicador->limite2 ){
            $seccion=2;
        }else{
            $seccion=3;
        }
        
        $color = "";
        if ($seccion==2) $color= "yellow";

        if($indicador->sentidoDeSemaforo==1){ // Rojo Amarillo Verde
            if($seccion==1) $color = "Red";
            if($seccion==3) $color = "Green";
            

        }else{ // VERDE AMARILLO ROJO
            if($seccion==1) $color = "Green";
            if($seccion==3) $color = "Red";
            

        }

        return $color;



    }
}
