<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadFrecuenciaIndicador extends Model
{
    protected $table = "unidadFrecuenciaIndicador";
    protected $primaryKey = "idUnidad";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nombre'];
}
