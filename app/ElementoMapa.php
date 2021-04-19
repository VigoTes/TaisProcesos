<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementoMapa extends Model
{
    protected $table = "elemento_mapa";
    protected $primaryKey = "idElemento";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = ['nombre','idNivel','idMapaEstrategico'];


    public function getListaFlechasOrigen(){
        return FlechaElementoMapa::where('idElementoOrigen','=',$this->idElemento)->get();

    }

    
    public function getListaFlechasDestino(){
        return FlechaElementoMapa::where('idElementoDestino','=',$this->idElemento)->get();

    }



}
