<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRequerimientoBS extends Model
{
    protected $table = "detalle_requerimiento_bs";
    protected $primaryKey ="codDetalleRequerimiento";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codDetalleRequerimiento','codRequerimiento','cantidad',
        'codUnidadMedida','descripcion','codigoPresupuestal'];

    
    public function getNombreTipoUnidad(){
        $unidad = UnidadMedida::findOrFail($this->codUnidadMedida);
        return $unidad->nombre;
    }

}
