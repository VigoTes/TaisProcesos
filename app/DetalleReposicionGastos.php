<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleReposicionGastos extends Model
{
    protected $table = "detalle_reposicion_gastos";
    protected $primaryKey ="codDetalleReposicion";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codReposicionGastos','fechaComprobante','nroComprobante',
    'concepto','importe',
    'codigoPresupuestal','codTipoCDP','nroEnRendicion'];

    public function setTipoCDPPorNombre($nombreCDP){
        $listacdp = CDP::where('nombreCDP','=',$nombreCDP)->get();
        $cdp = $listacdp[0];
        $this->codTipoCDP = $cdp->codTipoCDP;
        
    }
    public function getNombreTipoCDP(){
        $cdp = CDP::findOrFail($this->codTipoCDP);
        return $cdp->nombreCDP;
    }

    public function getCDP(){
        return CDP::findOrFail($this->codTipoCDP);

    }

    public function getFechaComprobante(){
        return str_replace('-','/',$this->fechaComprobante);

    }

}
