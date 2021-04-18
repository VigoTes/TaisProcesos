<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRendicionGastos extends Model
{
    protected $table = "detalle_rendicion_gastos";
    protected $primaryKey ="codDetalleRendicion";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codRendicionGastos','fecha','nroComprobante',
    'concepto','importe',
    'codigoPresupuestal','codTipoCDP','nroEnRendicion','contabilizado'];

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
}
