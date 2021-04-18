<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Proyecto;
use Illuminate\Http\Request;
use App\Empleado;
use App\ProyectoContador;
use App\Puesto;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
use App\LugarEjecucion;
use App\Sede;
use App\Debug;
use App\Departamento;
use App\Provincia;
use App\Distrito;
use App\PoblacionBeneficiaria;
use App\EntidadFinanciera;
use App\IndicadorObjEspecifico;
use App\ObjetivoEstrategico;
use App\PlanEstrategicoInstitucional;
use App\RelacionProyectoObj;
use App\ObjetivoEspecifico;
use App\ResultadoEsperado;
use App\IndicadorResultado;

use App\Moneda;
use App\TipoFinanciamiento;

class ProyectoController extends Controller
{
    
    function crear(){
        $listaSedes = Sede::All();

        return view('Proyectos.Create',compact('listaSedes'));
    }

    function editar($codProyecto){
        $proyecto = Proyecto::findOrFail($codProyecto);
        $lugaresEjecucion = LugarEjecucion::where('codProyecto','=',$codProyecto)->get();
        $poblacionesBeneficiarias = PoblacionBeneficiaria::where('codProyecto','=',$codProyecto)->get();
        $listaDepartamentos = Departamento::All();
        $listaFinancieras = EntidadFinanciera::All();
        $listaPorcentajes = $proyecto->getPorcentajesObjEstrategicos();
        $listaPEIs = PlanEstrategicoInstitucional::All();
        $listaObjetivosEspecificos = ObjetivoEspecifico::where('codProyecto','=',$codProyecto)->get();
        $listaResultadosEsperados = ResultadoEsperado::where('codProyecto','=',$codProyecto)->get();
        $listaMonedas = Moneda::All();
        $listaSedes = Sede::All();
        $listaTipoFinanciamiento = TipoFinanciamiento::All();


        return view('Proyectos.EditarProyecto',compact('listaSedes','proyecto','lugaresEjecucion','listaDepartamentos',
            'poblacionesBeneficiarias','listaFinancieras','listaPorcentajes','listaPEIs','listaObjetivosEspecificos',
            'listaResultadosEsperados','listaMonedas','listaTipoFinanciamiento'));
    }

    
    function getCodigoPresupuestal($id){
        error_log('['.Proyecto::findOrFail($id)->codigoPresupuestal.']');
        return Proyecto::findOrFail($id)->codigoPresupuestal;
    } 



    function actualizarPEI(Request $request){
        $proyecto = Proyecto::findOrFail($request->codProyecto);
        $proyecto->codPEI = $request->codPEI;
        $proyecto->eliminarPorcentajesDeObjetivos();

        $listaNuevosObj = ObjetivoEstrategico::where('codPEI','=',$request->codPEI)->get();

        foreach($listaNuevosObj as $itemObj){
            
            $rela = new RelacionProyectoObj();
            $rela->codObjetivoEstrategico = $itemObj->codObjetivoEstrategico;
            $rela->codProyecto = $proyecto->codProyecto;
            $rela->porcentajeDeAporte = 0;
            $rela->save();

            Debug::mensajeSimple($rela);
        }


        $proyecto->save();


        return redirect()->route('GestiónProyectos.editar',$proyecto->codProyecto)->with('datos','PEI Actualizado correctamente');
    }

    function actualizarPorcentajesObjetivos(Request $request){
        
        $proyecto = Proyecto::findOrFail($request->codProyecto);
        
        $listaPorcentajes = RelacionProyectoObj::where('codProyecto','=',$proyecto->codProyecto)->get();
        foreach($listaPorcentajes as $itemPorcentaje){
            $itemPorcentaje->porcentajeDeAporte = $request->get('porcentaje'.$itemPorcentaje->codRelacion);
            $itemPorcentaje->save();

        }

        
        return redirect()->route('GestiónProyectos.editar',$proyecto->codProyecto)->with('datos','Porcentajes de Objetivos Actualizados correctamente');
    }


    function store(Request $request){
        try {
            DB::beginTransaction();

            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->activo = 1;
            $proyecto->codSedePrincipal = $request->codSede;
            $proyecto->codigoPresupuestal = $request->codigoPresupuestal;
            $proyecto->nombreLargo = $request->nombreLargo;
            
            $proyecto->save();

            DB::commit();

            return redirect()->route('GestiónProyectos.Listar')->with('datos','Proyecto creado exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
            return redirect()->route('GestiónProyectos.Listar')->with('datos','Ha ocurrido un ERROR.');
        }


    }

    function update(Request $request){
        try {
            DB::beginTransaction();

            $proyecto = Proyecto::findOrFail($request->codProyecto);
            $proyecto->nombre = $request->nombre;
            
            $proyecto->codigoPresupuestal = $request->codigoPresupuestal;
            $proyecto->nombreLargo = $request->nombreLargo;
            $proyecto->codEntidadFinanciera = $request->codEntidadFinanciera;

            $proyecto->codMoneda = $request->codMoneda;
            
            $proyecto->importePresupuestoTotal = $request->importePresupuestoTotal;
            $proyecto->importeContrapartidaCedepas = $request->importeContrapartidaCedepas;
            $proyecto->importeContrapartidaPoblacionBeneficiaria = $request->importeContrapartidaPoblacionBeneficiaria;
            $proyecto->importeContrapartidaOtros = $request->importeContrapartidaOtros;

            
            $proyecto->codTipoFinanciamiento = $request->codTipoFinanciamiento;
            $proyecto->codSedePrincipal = $request->codSede;
            $proyecto->objetivoGeneral = $request->objetivoGeneral;


            $proyecto->save();

            DB::commit();

            return redirect()->route('GestiónProyectos.Listar')->with('datos','Proyecto actualizado exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
            return redirect()->route('GestiónProyectos.Listar')->with('datos','Ha ocurrido un ERROR.');
        }


    }


    function darDeBaja($codProyecto){
        try {
            DB::beginTransaction();

            $proyecto = Proyecto::findOrFail($codProyecto);
            $proyecto->activo = 0;
            $proyecto->save();

            DB::commit();

            return redirect()->route('GestiónProyectos.Listar')->with('datos','Proyecto Dado de baja exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
            return redirect()->route('GestiónProyectos.Listar')->with('datos','Ha ocurrido un ERROR.');
        }


    }
    //VISTA INDEX de proyectos
    function index(){
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaGerentes = Empleado::getListaGerentesActivos();
        $listaContadores = Empleado::getListaContadoresActivos();

        return view('Proyectos.ListarProyectos',
            compact('listaProyectos','listaGerentes','listaContadores'));


    }


    function listarContadores($id){
        $proyecto=Proyecto::findOrFail($id);
        $contadoresSeleccionados=$proyecto->getContadores();
        $arr=[];
        foreach ($contadoresSeleccionados as $itemcontador) {
            $arr[]=$itemcontador->idEmpleado;
        }
        $contadores=Empleado
            ::where('codPuesto','=',Puesto::getCodigo('Contador'))
            ->whereNotIn('idEmpleado',$arr)->get();
            

        return view('Proyectos.ContadoresProyecto',compact('proyecto','contadores','contadoresSeleccionados'));
    }

    function agregarContador(Request $request){
        $detalle=new ProyectoContador();
        $detalle->codProyecto=$request->codProyecto;
        $detalle->idEmpleadoContador=$request->idEmpleadoConta;
        $detalle->save();

        return redirect()->route('GestiónProyectos.ListarContadores',$request->codProyecto);
    }

    function eliminarContador($id){
        $detalle=ProyectoContador::where('idEmpleadoContador','=',$id)->get();
        $detalle[0]->delete();

        return redirect()->route('GestiónProyectos.ListarContadores',$detalle[0]->codProyecto);
    }


    function actualizarProyectosYGerentesContadores($id){
        try{
            $arr = explode('*', $id);
            DB::beginTransaction();
            $proyecto=Proyecto::findOrFail($arr[0]);
            $gerente=Empleado::findOrFail($arr[1]);
            if($arr[2]==1){
                $proyecto->idEmpleadoDirector=$gerente->idEmpleado;
            }else{
                $proyecto->idEmpleadoConta=$gerente->idEmpleado;
            }
            $proyecto->save();
            DB::commit();
            return true;
        }catch(\Throwable $th){
            DB::rollBack();
            return false;
        }
    }

    
    /**PARA RELLENAR PROYECTO_CONTADOR */
    public function RellenarProyectoContador(){

        //borramos todos los actuales
        $listaActual = ProyectoContador::where('codProyectoContador','>','0')->delete();
        
        $contadores=Empleado::getListaContadoresActivos();
        $proyectos=Proyecto::getProyectosActivos();

        foreach ($proyectos as $itemproyecto) {
            foreach ($contadores as $itemcontador) {
                $detalle=new ProyectoContador();
                $detalle->idEmpleadoContador=$itemcontador->idEmpleado;
                $detalle->codProyecto=$itemproyecto->codProyecto;
                $detalle->save();
            }
        }

        Debug::mensajeSimple('Rellenando todos los proyectos con contadores');
        return redirect()->route('GestiónProyectos.Listar')->with('datos','Se han rellenado todos los proyectos con los contadores.');


    }



    public function agregarResultadoEsperado(Request $request){
        
        $resultado = new ResultadoEsperado();
        $resultado->descripcion = $request->descripcionNuevoResultado;
        $resultado->codProyecto = $request->codProyecto;
        $resultado->save();

        return redirect()->route('GestiónProyectos.editar',$request->codProyecto)->with('datos','Se ha añadido el resultado esperado.');

    }

    public function agregarIndicadorResultado(Request $request){

        $indicador = new IndicadorResultado();
        $indicador->descripcion = $request->descripcionNuevoIndicadorResultado;
        $indicador->codResultadoEsperado = $request->ComboBoxResultadoEsperado;
        $indicador->save();

        return redirect()->route('GestiónProyectos.editar',$request->codProyecto)->with('datos','Se ha añadido el indicador de resultado esperado.');

    }



    //agrega un indicador a un obj especifico
    public function agregarIndicador(Request $request){
        
        $indicador = new IndicadorObjEspecifico();
        $indicador->descripcion = $request->descripcionNuevoIndicador;
        $indicador->codObjEspecifico = $request->ComboBoxObjetivoEspecifico;

        $indicador->save();

        return redirect()->route('GestiónProyectos.editar',$request->codProyecto)->with('datos','Se ha añadido el indicador.');
    }

    public function eliminarIndicador($codIndicadorObj){
        $indicador = IndicadorObjEspecifico::findOrFail($codIndicadorObj);
        $objetivo = ObjetivoEspecifico::findOrFail($indicador->codObjEspecifico);
        $indicador->delete();

        
        return redirect()->route('GestiónProyectos.editar',$objetivo->codProyecto)->with('datos','Se ha eliminado el indicador.');

    }


    public function agregarObjetivoEspecifico(Request $request ){

        $nuevo = new ObjetivoEspecifico();
        $nuevo->descripcion = $request->descripcionObjetivo;
        $nuevo->codProyecto = $request->codProyecto;
        $nuevo->save();

        return redirect()->route('GestiónProyectos.editar',$request->codProyecto)->with('datos','Se ha añadido el obj específico.');

    }


    public function eliminarObjetivoEspecifico($codObjEspecifico){


        $obj = ObjetivoEspecifico::findOrFail($codObjEspecifico);
        $codProyecto = $obj->codProyecto;
        $obj->delete();
        
        return redirect()->route('GestiónProyectos.editar',$codProyecto)->with('datos','Se ha eliminado el objetivo específico.');
    
        }
    

    public function agregarLugarEjecucion(Request $request ){
        
         $nuevo = new LugarEjecucion();
         $nuevo->codDistrito = $request->ComboBoxDistrito;
         $nuevo->codProyecto = $request->codProyecto;
         $nuevo->save();

         return redirect()->route('GestiónProyectos.editar',$request->codProyecto);

    }


    public function eliminarLugarEjecucion($codLugarEjecucion){


        $lugarEjecucion = LugarEjecucion::findOrFail($codLugarEjecucion);
        $codProyecto = $lugarEjecucion->codProyecto;
        $lugarEjecucion->delete();

        return redirect()->route('GestiónProyectos.editar',$codProyecto);

    }

    public function agregarPoblacionBeneficiaria(Request $request ){
        
        $nuevo = new PoblacionBeneficiaria();
        $nuevo->descripcion = $request->descripcionPob;
        $nuevo->codProyecto = $request->codProyecto;
        $nuevo->save();

        return redirect()->route('GestiónProyectos.editar',$request->codProyecto)->with('datos','Se ha añadido una nueva población beneficiaria.');

   }

   public function eliminarPoblacionBeneficiaria($codPoblacionBeneficiaria){


    $pob = PoblacionBeneficiaria::findOrFail($codPoblacionBeneficiaria);
    $codProyecto = $pob->codProyecto;
    $pob->delete();
    
    return redirect()->route('GestiónProyectos.editar',$codProyecto);

    }


    public function listarProvinciasDeDepartamento($codDepartamento){
        return Provincia::where('codDepartamento','=',$codDepartamento)->get();

    }
    public function listarDistritosDeProvincia($codProvincia){
        return Distrito::where('codProvincia','=',$codProvincia)->get();

    }
    
}
