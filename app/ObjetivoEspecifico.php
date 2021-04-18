<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjetivoEspecifico extends Model
{
    public $timestamps = false;
    protected $table = 'objetivo_especifico';

    protected $primaryKey = 'codObjEspecifico';

    protected $fillable = [
        'descripcion','codProyecto'
    ];


    public function getDescripcionAbreviada(){
        
        // Si la longitud es mayor que el límite...
        $limiteCaracteres = 25;
        $cadena = $this->descripcion;
        if(strlen($cadena) > $limiteCaracteres){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limiteCaracteres) . '...';
        }

        // Si no, entonces devuelve la cadena normal
        return $cadena;
    
    }

    public function getCantidadIndicadores(){
        $cantidad = count($this->getListaDeIndicadores());
        if($cantidad!=0)
            return $cantidad;

        return 1;
    }
    public function getListaDeIndicadores(){
        return IndicadorObjEspecifico::where('codObjEspecifico','=',$this->codObjEspecifico)->get();
        
    }

    public function getProyecto(){
        return Proyecto::findOrFail($this->codProyecto);


    }
}
