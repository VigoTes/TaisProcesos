<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Caja;
class Proyecto extends Model
{
    protected $table = "proyecto";
    protected $primaryKey ="codProyecto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = [ 'codProyecto', 'codigoPresupuestal', 'nombre', 'codEmpleadoDirector', 'activo', 'codSedePrincipal',
     'nombreLargo', 'codEntidadFinanciera', 'codPEI', 'objetivoGeneral', 'fechaInicio', 'importePresupuestoTotal', 
     'codMonedaPresupuestoTotal', 'importeContrapartidaCedepas', 'codMonedaContrapartidaCedepas', 
     'importeContrapartidaPoblacionBeneficiaria', 'codMonedaContrapartidaPoblacionBeneficiaria', 'importeContrapartidaOtros', 
     'codMonedaContrapartidaOtros', 'codTipoFinanciamiento'];
    
    public function getGerente(){
        return Empleado::findOrFail($this->codEmpleadoDirector);

    }
    public function estaActivo(){
        if($this->activo=='1')
            return 'SÍ';

        return 'NO';

    }



    public function getPorcentajesObjEstrategicos(){
        
        return RelacionProyectoObj::where('codProyecto','=',$this->codProyecto)->get();

    }

    public function eliminarPorcentajesDeObjetivos(){
        RelacionProyectoObj::where('codProyecto','=',$this->codProyecto)->delete();

    }

    public static function getProyectosActivos(){ //FALTA METER EN PROYECTO EL int ACTIVO
        //return Proyecto::All();
        return Proyecto::where('activo','=','1')->get();
    }

    public function getContadores(){
        $detalles=ProyectoContador::where('codProyecto','=',$this->codProyecto)->get();
        $arr=[];
        foreach ($detalles as $itemdetalle) {
            $arr[]=$itemdetalle->codEmpleadoContador;
        }
        return Empleado::whereIn('codEmpleado',$arr)->get();
    }

    public function nroContadores(){
        $detalles=ProyectoContador::where('codProyecto','=',$this->codProyecto)->get();
        return count($detalles);
    }

    public function evaluador(){
        $empleado=Empleado::find($this->codEmpleadoDirector);
        return $empleado;
    }

    public function getFechaInicio(){
        return date('d/m/Y', strtotime($this->fechaInicio));
    }
}
