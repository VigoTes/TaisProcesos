<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoblacionBeneficiaria extends Model
{
    protected $table = "poblacion_beneficiaria";
    protected $primaryKey ="codPoblacionBeneficiaria";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['descripcion','codProyecto'];

    
}
