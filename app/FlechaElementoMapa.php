<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlechaElementoMapa extends Model
{
    protected $table = "flechaElementoMapa";
    protected $primaryKey = "idFlecha";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
    protected $fillable = ['idElementoOrigen','idElementoDestino'];


    public function getColor(){
        $R = 5222*$this->idFlecha + 7001*$this->idElementoOrigen*$this->idFlecha + 1275*$this->idElementoDestino;
        $G = $this->idFlecha + $this->idElementoOrigen*9899 + 12878*$this->idElementoDestino*$this->idElementoOrigen;
        $B = 1500*$this->idFlecha + $this->idElementoOrigen + 1625*$this->idElementoDestino*$this->idFlecha ;
        $R = $R%255;
        $G = $G%255;
        $B = $B%255;

        $color = "rgb(".$R.",".$G.",".$B.")";

        return $color;
    }

    //retorna true si existe
    public static function comprobarExistencia($idOrigen,$idDestino){
        $lista = FlechaElementoMapa::where('idElementoOrigen','=',$idOrigen)->where('idElementoDestino','=',$idDestino)->get();
        return count($lista) > 0;
    }

}
