<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelMapa extends Model
{
    protected $table = "nivel_mapa";
    protected $primaryKey = "idNivel";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];


    public function getCodNivel($nombre){
        return NivelMapa::where('nombre','=',$nombre)->get()[0]->idNivel;

    }
}
