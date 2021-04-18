<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\RequerimientoBS;
use App\Empleado;
use App\Proyecto;
use Illuminate\Http\Request;
use App\DetalleSolicitudFondos;
use App\Banco;
use App\Sede;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use App\CDP;
use App\EstadoOrden;
use App\EstadoSolicitudFondos;
use App\SolicitudFalta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Throw_;
use App\Moneda;
use App\Debug;
use App\DetalleRequerimientoBS;
use App\Numeracion;
use App\ProyectoContador;
use App\UnidadMedida;
use DateTime;

class RequerimientoBSController extends Controller
{
    //

    const PAGINATION = 20;
    public function listarOfEmpleado(Request $request){
        //filtros
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';



        $empleado = Empleado::getEmpleadoLogeado();

        if($codProyectoBuscar==0){
            $requerimientos= RequerimientoBS::where('codEmpleadoSolicitante','=',$empleado->codEmpleado);
        }else
            $requerimientos= RequerimientoBS::where('codEmpleadoSolicitante','=',$empleado->codEmpleado)->where('codProyecto','=',$codProyectoBuscar);
            
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $requerimientos=$requerimientos->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }

        $requerimientos = $requerimientos->orderBy('fechaHoraEmision','DESC')->get();
        $requerimientos = RequerimientoBS::ordenarParaEmpleado($requerimientos)->paginate($this::PAGINATION);
        

        $proyectos = Proyecto::getProyectosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('RequerimientoBS.Empleado.ListarRequerimientos',
            compact('requerimientos','fechaInicio','fechaFin','proyectos','codProyectoBuscar'));
    }

    public function listarRequerimientos(){

        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            return redirect()->route('RequerimientoBS.Gerente.Listar')->with($datos,$msj);
        }
        if($empleado->esJefeAdmin()){
            //return redirect()->route('ReposicionGastos.Administracion.Listar')->with($datos,$msj);
        }
        if($empleado->esContador()){
            //return redirect()->route('ReposicionGastos.Contador.Listar')->with($datos,$msj);
        }
        return redirect()->route('RequerimientoBS.Empleado.Listar')->with($datos,$msj);

    }

    //para consumirlo en js
    public function listarDetalles($idRequerimiento){
        $vector = [];
        $listaDetalles = DetalleRequerimientoBS::where('codRequerimiento','=',$idRequerimiento)->get();
        for ($i=0; $i < count($listaDetalles) ; $i++) { 
            
            $itemDet = $listaDetalles[$i];
            $itemDet['codUnidadMedida'] = UnidadMedida::findOrFail($itemDet->codUnidadMedida)->nombre; //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
            array_push($vector,$itemDet);            
        }
        return $vector  ;
    }



    public function crear(){
        $listaUnidadMedida = UnidadMedida::All();
        $proyectos = Proyecto::getProyectosActivos();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionREP();

        return view('RequerimientoBS.Empleado.CrearRequerimientoBS',
            compact('empleadoLogeado','listaUnidadMedida','proyectos','objNumeracion'));

    }
    public function store(Request $request){
        try{
            DB::beginTransaction(); 
            $requerimiento=new RequerimientoBS();
            $requerimiento->codEstadoRequerimiento=1;
            $requerimiento->codEmpleadoSolicitante=Empleado::getEmpleadoLogeado()->codEmpleado;
        
            $requerimiento->codProyecto = $request->codProyecto;
            $requerimiento->fechaHoraEmision=Carbon::now();
            $requerimiento->justificacion=$request->justificacion;//cambiar a justificacion (se tiene que cambiar en la vista xdxdxd)
            $requerimiento->fechaHoraRevision=null;
            $requerimiento->fechaHoraAtendido=null;//sisi xd
            $requerimiento->fechaHoraConta=null;
            $requerimiento->observacion=null;
    
            $requerimiento->codigoCedepas = RequerimientoBS::calcularCodigoCedepas(Numeracion::getNumeracionREQ());
            Numeracion::aumentarNumeracionREQ();

            $requerimiento->save();
            
            //creacion de detalles
            $vec[] = '';
            $codREQRecienInsertado = $requerimiento->codRequerimiento;
                
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) 
            {
                    $detalle=new DetalleRequerimientoBS();
                    $detalle->codRequerimiento=$requerimiento->codRequerimiento ;//ultimo insertad            
                    $detalle->codUnidadMedida=UnidadMedida::where('nombre','=',$request->get('colTipo'.$i))->get()[0]->codUnidadMedida;

                    $detalle->descripcion=              $request->get('colDescripcion'.$i);
                    $detalle->cantidad=               $request->get('colCantidad'.$i);
                    $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                    //$detalle->nroEnReposicion = $i+1;
                    $detalle->save();  
                    $i=$i+1;
            }
           
            $requerimiento->save();
            
            $nombresArchivos = explode(', ',$request->nombresArchivos);
            $j=0;
            $nombresArchivosEmp='';
            foreach ($request->file('filenames') as $archivo)
            {   
                
                
                $nombresArchivosEmp=$nombresArchivosEmp.'/'.$nombresArchivos[$j];
               
                //               CDP-   000002                           -   5   .  jpg

                $nombreImagen = RequerimientoBS::getFormatoNombreArchivoEmp($codREQRecienInsertado, $j+1);
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                $fileget = \File::get( $archivo );
                
                Storage::disk('requerimientos')->put($nombreImagen,$fileget );
                $j++;
            }

            
            $requerimiento->cantArchivosEmp = $j;
            $requerimiento->nombresArchivosEmp=trim($nombresArchivosEmp,'/');
            $requerimiento->save();

            DB::commit();
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Se ha Registrado el requerimiento N°'.$requerimiento->codigoCedepas);
        }catch(\Throwable $th){
            
            Debug::mensajeError('REQUERIMIENTO BS CONTROLLER STORE', $th);
            DB::rollBack();
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Ha ocurrido un error.');
        }
        
    }

    public function ver($id){
        $requerimiento=RequerimientoBS::findOrFail($id);
        $detalles=$requerimiento->detalles();

        //$listaUnidadMedida = UnidadMedida::All();
        //$proyectos = Proyecto::getProyectosActivos();
        //$monedas=Moneda::All();
        //$bancos=Banco::All();
        //$empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        //$objNumeracion = Numeracion::getNumeracionREP();

        return view('RequerimientoBS.Empleado.VerRequerimientoBS',
        compact('requerimiento','empleadoLogeado','detalles'));

    }


    //$cadena = "6*5" para descargar el quinto archivo del req numero 6
    public function descargarArchivoEmp($cadena){


        $vector = explode('*',$cadena);
        $codReq = $vector[0];
        $i = $vector[1];
        $req = RequerimientoBS::findOrFail($codReq);
        $nombreArchivo = RequerimientoBS::getFormatoNombreArchivoEmp($req->codRequerimiento,$i);
        //                          UBICACION                       NOMBRE CON EL QUE SE DESCARGA
        return Storage::download("/requerimientos/".$nombreArchivo,$req->getNombreArchivoEmpNro($i));


    }


    //$cadena = "3*4" para descargar el cuarto archivo del req numero 3
    public function descargarArchivoAdm($cadena){
        $vector = explode('*',$cadena);
        $codReq = $vector[0];
        $i = $vector[1];
        $req = RequerimientoBS::findOrFail($codReq);
        $nombreArchivo = RequerimientoBS::getFormatoNombreArchivoAdm($req->codRequerimiento,$i);
        return Storage::download("/requerimientos/".$nombreArchivo,$req->getNombreArchivoAdmNro($i));


    }

    public function editar($id){
        $requerimiento=RequerimientoBS::findOrFail($id);
        $listaUnidadMedida = UnidadMedida::All();
        $proyectos = Proyecto::getProyectosActivos();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        //$objNumeracion = Numeracion::getNumeracionREP();

        return view('RequerimientoBS.Empleado.EditarRequerimientoBS',
            compact('empleadoLogeado','listaUnidadMedida','proyectos','requerimiento'));
    }
    public function update( Request $request){
        
        try {
            $requerimiento=RequerimientoBS::findOrFail($request->codRequerimiento);

            
            if($requerimiento->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Error: la reposicion no puede ser actualizada por un empleado distinto al que la creó.');



            if(!$requerimiento->listaParaActualizar())
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Error: la reposicion no puede ser actualizada ahora puesto que está en otro proceso.');

             

            $requerimiento->codProyecto=$request->codProyecto;
            $requerimiento->justificacion=$request->justificacion;
            //si estaba observada, pasa a subsanada
            
            if($requerimiento->verificarEstado('Observada'))
                $requerimiento-> codEstadoRequerimiento = RequerimientoBS::getCodEstado('Subsanada');
            else
                $requerimiento-> codEstadoRequerimiento = RequerimientoBS::getCodEstado('Creada');
            
            $requerimiento-> save();        
            



            //$total=0;
            //borramos todos los detalles pq los ingresaremos again
            DB::select('delete from detalle_requerimiento_bs where codRequerimiento=" '.$requerimiento->codRequerimiento.'"');

            //creacion de detalles
            $vec[] = '';
            
                
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) 
            {
                $detalle=new DetalleRequerimientoBS();
                $detalle->codRequerimiento=$requerimiento->codRequerimiento ;//ultimo insertad            
                $detalle->codUnidadMedida=UnidadMedida::where('nombre','=',$request->get('colTipo'.$i))->get()[0]->codUnidadMedida;

                $detalle->descripcion=              $request->get('colDescripcion'.$i);
                $detalle->cantidad=               $request->get('colCantidad'.$i);
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                //$detalle->nroEnReposicion = $i+1;
                $detalle->save();  
                $i=$i+1;
            }
           
            $requerimiento->save();


            //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
            
            if( $request->nombresArchivos!='' ){
                $requerimiento->borrarArchivosEmp();
                
                $nombresArchivos = explode(', ',$request->nombresArchivos);
                $j=0;
                $nombresArchivosEmp='';
                foreach ($request->file('filenames') as $archivo)
                {   
                    
                    
                    $nombresArchivosEmp=$nombresArchivosEmp.'/'.$nombresArchivos[$j];
                
                    //               CDP-   000002                           -   5   .  jpg
                    $nombreImagen = RequerimientoBS::getFormatoNombreArchivoEmp($requerimiento->codRequerimiento, $j+1);
                    Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                    $fileget = \File::get( $archivo );
                    
                    Storage::disk('requerimientos')->put($nombreImagen,$fileget );
                    $j++;
                }

                $requerimiento->cantArchivosEmp = $j;
                $requerimiento->nombresArchivosEmp=trim($nombresArchivosEmp,'/');
                $requerimiento->save();
            }
            


            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Se ha Editado el requerimiento N°'.$requerimiento->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER UPDATE', $th);
            DB::rollBack();
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }


    public function cancelar($id){
        try {
            DB::beginTransaction();
    
            $requerimiento = RequerimientoBS::findOrFail($id);
            
            if(!$requerimiento->listaParaCancelar())
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Error: la reposicion no puede ser cancelada ahora puesto que está en otro proceso.');
            

            $requerimiento->codEstadoRequerimiento =  RequerimientoBS::getCodEstado('Cancelada');
            $requerimiento->save();
     
            DB::commit();
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Se cancelo correctamente la Reposicion '.$requerimiento->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER CANCELADA', $th);
            DB::rollBack();
            return redirect()->route('RequerimientoBS.Empleado.Listar')
                ->with('datos','Ha ocurrido un error.');
        }


    }



    /**GERENTE DE PROYECTOS */
    public function listarOfGerente(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado=Empleado::getEmpleadoLogeado();
        $proyectos= $empleado->getListaProyectos();
        
        if(count($proyectos)==0)
            return redirect()->route('error')->with('datos',"No tiene ningún proyecto asignado...");
        
        $arr=[];
        foreach ($proyectos as $itemproyecto) {
            $arr[]=$itemproyecto->codProyecto;
        }
        

        if($codProyectoBuscar==0){
            $requerimientos=RequerimientoBS::whereIn('codProyecto',$arr);
        }else{
            $requerimientos=RequerimientoBS::where('codProyecto','=',$codProyectoBuscar);
        }
        
        if($codEmpleadoBuscar!=0){
            $requerimientos=$requerimientos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $requerimientos=$requerimientos->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }

        //return $reposiciones->get();
        $requerimientos=$requerimientos->orderBy('fechaHoraEmision','DESC')->get();
        $requerimientos= RequerimientoBS::ordenarParaGerente($requerimientos)->paginate($this::PAGINATION);
        

        $empleados=Empleado::getEmpleadosActivos();
        $proyectos=Proyecto::whereIn('codProyecto',$arr)->get();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('RequerimientoBS.Gerente.ListarRequerimientos',compact('requerimientos','empleado','codProyectoBuscar','codEmpleadoBuscar','proyectos','empleados','fechaInicio','fechaFin'));
    }

    public function viewGeren($id){
      
        $requerimiento=RequerimientoBS::findOrFail($id);
        $detalles=$requerimiento->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('RequerimientoBS.Gerente.EvaluarRequerimientoBS',compact('requerimiento','empleadoLogeado','detalles'));
    }

    public function VerAtender($codRequerimiento){
        $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
        $detalles = DetalleRequerimientoBS::where('codRequerimiento','=',$codRequerimiento)->get();
        return view('RequerimientoBS.Administrador.AtenderRequerimientoBS',compact('requerimiento','detalles'));


    }

    public function listarOfAdministrador(Request $request){
        
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado=Empleado::getEmpleadoLogeado();
        $proyectos= Proyecto::getProyectosActivos();

        
        
        $arr=[];
        foreach ($proyectos as $itemproyecto) {
            $arr[]=$itemproyecto->codProyecto;
        }
        

        if($codProyectoBuscar==0){
            $requerimientos=RequerimientoBS::whereIn('codProyecto',$arr);
        }else{
            $requerimientos=RequerimientoBS::where('codProyecto','=',$codProyectoBuscar);
        }
        
        if($codEmpleadoBuscar!=0){
            $requerimientos=$requerimientos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $requerimientos=$requerimientos->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }

        //return $reposiciones->get();
        $requerimientos=$requerimientos->orderBy('fechaHoraEmision','DESC')->get(); //paginate($this::PAGINATION);
        
        $requerimientos= RequerimientoBS::ordenarParaAdministrador($requerimientos)->paginate($this::PAGINATION);
        
        $empleados=Empleado::getEmpleadosActivos();
        $proyectos=Proyecto::whereIn('codProyecto',$arr)->get();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('RequerimientoBS.Administrador.ListarRequerimientos',
            compact('requerimientos','empleado','codProyectoBuscar','codEmpleadoBuscar',
                    'proyectos','empleados','fechaInicio','fechaFin'));
    }


    
    /**CONTADOR */
    public function listarOfConta(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';

        
        $empleado=Empleado::getEmpleadoLogeado();
        $detalles=ProyectoContador::where('codEmpleadoContador','=',$empleado->codEmpleado)->get();
        if(count($detalles)==0)
            return redirect()->route('error')->with('datos',"No tiene ningún proyecto asignado...");
        
        //$proyectos=Proyecto::where('codEmpleadoConta','=',$empleado->codEmpleado)->get();
        $arr2=[];
        foreach ($detalles as $itemproyecto) {
            $arr2[]=$itemproyecto->codProyecto;
        }
        $arr=[3,4,5];
        

        if($codProyectoBuscar==0 || $codProyectoBuscar==null){
            //solo proyectos en el que esta participando
            $requerimientos=RequerimientoBS::whereIn('codEstadoRequerimiento',$arr)->whereIn('codProyecto',$arr2);
        }else{
            $requerimientos=RequerimientoBS::whereIn('codEstadoRequerimiento',$arr)->where('codProyecto','=',$codProyectoBuscar);
        }
        if($codEmpleadoBuscar!=0){
            $requerimientos=$requerimientos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $requerimientos=$requerimientos->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }
        $requerimientos=$requerimientos->orderBy('fechaHoraEmision','DESC')->get();
        $requerimientos= RequerimientoBS::ordenarParaContador($requerimientos)->paginate($this::PAGINATION);
        
        

        $proyectos=Proyecto::whereIn('codProyecto',$arr2)->get();
        $empleados=Empleado::getEmpleadosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('RequerimientoBS.Contador.ListarRequerimientos',compact('requerimientos','empleado','codProyectoBuscar','codEmpleadoBuscar','proyectos','empleados','fechaInicio','fechaFin'));
    }
    public function viewConta($id){
      
        $requerimiento=RequerimientoBS::findOrFail($id);
        $detalles=$requerimiento->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('RequerimientoBS.Contador.ContabilizarRequerimientoBS',compact('requerimiento','empleadoLogeado','detalles'));
    }


    /**CAMBIO DE ESTADOS */
    public function aprobar(Request $request){//gerente
        //return $request;
        try{
            DB::beginTransaction();
            $requerimiento=RequerimientoBS::find($request->codRequerimiento);

            //AQUI TA EL ERROR
            if(!$requerimiento->listaParaAprobar())
            return redirect()->route('RequerimientoBS.Gerente.Listar')
                ->with('datos','Error: la reposicion no puede ser aprobada ahora puesto que está en otro proceso.');
            

            $requerimiento->codEstadoRequerimiento =  RequerimientoBS::getCodEstado('Aprobada');
            $requerimiento->codEmpleadoEvaluador = Empleado::getEmpleadoLogeado()->codEmpleado;
            $requerimiento->justificacion = $request->justificacion;
            $requerimiento->fechaHoraRevision=new DateTime();
            $requerimiento->save();
            
            
            $listaDetalles = DetalleRequerimientoBS::where('codRequerimiento','=',$requerimiento->codRequerimiento)->get();
            foreach($listaDetalles as $itemDetalle ){
                $itemDetalle->codigoPresupuestal = $request->get('CodigoPresupuestal'.$itemDetalle->codDetalleRequerimiento);
                $itemDetalle->save();
            }
            


            DB::commit();
            //return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se aprobo correctamente la Reposicion '.$reposicion->codigoCedepas);
            return redirect()->route('RequerimientoBS.Listar')->with('datos','Se aprobo correctamente la Reposicion '.$requerimiento->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError('REQUERIMIENTO BS APROBAR', $th);
            DB::rollBack();
            
            return redirect()->route('RequerimientoBS.Listar')->with('datos','Ha ocurrido un error');
        }
    }
    public function rechazar($id){//gerente-jefe (codReposicion)
        try{
            DB::beginTransaction();
            $requerimiento=RequerimientoBS::findOrFail($id);

            if(!$requerimiento->listaParaRechazar())
            return redirect()->route('RequerimientoBS.Listar')
                ->with('datos','Error: la reposicion no puede ser rechazada ahora puesto que está en otro proceso.');


            $empleado=Empleado::getEmpleadoLogeado();
        

            if($empleado->esJefeAdmin()){
                $requerimiento->codEmpleadoAdministrador=$empleado->codEmpleado;
                $requerimiento->fechaHoraAtendido=new DateTime();
            }
            if($empleado->esGerente()){
                $requerimiento->codEmpleadoEvaluador=$empleado->codEmpleado;
                $requerimiento->fechaHoraRevision=new DateTime();
            }


            $requerimiento->codEstadoRequerimiento=RequerimientoBS::getCodEstado('Rechazada');
            $requerimiento->save();
            DB::commit();
            return redirect()->route('RequerimientoBS.Listar')->with('datos','Se rechazo correctamente la Reposicion '.$requerimiento->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('RequerimientoBS.Listar')->with('datos','Ha ocurrido un error');
        }

    }
    public function observar($id){//gerente-administracion (codReposicion-observacion)
        try{
            DB::beginTransaction();
            $empleado = Empleado::getEmpleadoLogeado();

            $arr = explode('*', $id);
            $requerimiento=RequerimientoBS::find($arr[0]);

            if(!$requerimiento->listaParaObservar())
            return redirect()->route('RequerimientoBS.Listar')
                ->with('datos','Error: la reposicion no puede ser observada ahora puesto que está en otro proceso.');


            
            if($empleado->esJefeAdmin()){
                $requerimiento->codEmpleadoAdministrador=$empleado->codEmpleado;
                $requerimiento->fechaHoraAtendido=new DateTime();
            }
            if($empleado->esGerente()){
                $requerimiento->codEmpleadoEvaluador=$empleado->codEmpleado;
                $requerimiento->fechaHoraRevision=new DateTime();
            }

            $requerimiento->codEstadoRequerimiento=RequerimientoBS::getCodEstado('Observada');
            $requerimiento->observacion=$arr[1];
            
            $requerimiento->save();
            DB::commit();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }else if($empleado->esContador()){
                return redirect()->route('ReposicionGastos.Contador.Listar')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }else{
                return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }
            */
            return redirect()->route('RequerimientoBS.Listar')->with('datos','Se observo correctamente la Reposicion '.$requerimiento->codigoCedepas);
            
        }catch(\Throwable $th){
            DB::rollBack();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Ha ocurrido un error');
            }else if($empleado->esContador()){
                return redirect()->route('ReposicionGastos.Contador.Listar')->with('datos','Ha ocurrido un error');
            }else{
                return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Ha ocurrido un error');
            }
            */
            return redirect()->route('RequerimientoBS.Listar')->with('datos','Ha ocurrido un error');
        }
    }


    /* FUNCION DEL ADMIN */
    public function atender(Request $request){
      
        try {
            
            DB::beginTransaction();

            $requerimiento = RequerimientoBS::findOrFail($request->codRequerimiento);


            
            if(!$requerimiento->listaParaAtender())
                return redirect()->route('RequerimientoBS.Administrador.Listar')
                    ->with('datos','ERROR: El requerimiento ya fue atendido o no está apto para serlo.');


            $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Atendida');
            $requerimiento->codEmpleadoAdministrador = Empleado::getEmpleadoLogeado()->codEmpleado;
            $requerimiento->fechaHoraAtendido = Carbon::now();

            $requerimiento->save();

            /* SUBIDA DE LOS ARCHIVOS DEL ADMINISTRADOR */

            
            $nombresArchivos = explode(', ',$request->nombresArchivos);
            $j=0;
            $terminacionesArchivos='';
            foreach ($request->file('filenames') as $archivo)
            {   
                
               
                $terminacionesArchivos=$terminacionesArchivos.'/'.$nombresArchivos[$j];
               
                //               CDP-   000002                           -   5   .  jpg

                $nombreImagen = RequerimientoBS::getFormatoNombreArchivoAdm($requerimiento->codRequerimiento, $j+1);
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                $fileget = \File::get( $archivo );
                
                Storage::disk('requerimientos')->put($nombreImagen,$fileget );
                $j++;
            }

            
            $requerimiento->cantArchivosAdmin = $j;
            $requerimiento->nombresArchivosAdmin=trim($terminacionesArchivos,'/');
            $requerimiento->save();



            DB::commit();

            return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos','Requerimiento '.$requerimiento->codigoCedepas.' Atendido satisfactoriamente.');


        } catch (\Throwable $th) {
        
            Debug::mensajeError('REQUERIMIENTO BS CONTROLLER ATENDER',$th);
            DB::rollBack();
            return redirect()->route('RequerimientoBS.Administrador.Listar')->with('datos','Ha oucrrido un error.');


        }


       

    }
    public function contabilizar($id){
        try 
        {
            DB::beginTransaction();
            $requerimiento = RequerimientoBS::findOrFail($id);
            
            if(!$requerimiento->listaParaContabilizar())
                return redirect()->route('RequerimientoBS.Listar')
                    ->with('datos','ERROR: El requerimiento ya fue contabilizada o no está apta para serlo.');


            $requerimiento->codEstadoRequerimiento = RequerimientoBS::getCodEstado('Contabilizada');
            $empleadoLogeado = Empleado::getEmpleadoLogeado();  

            $requerimiento->codEmpleadoContador = $empleadoLogeado->codEmpleado;
            $requerimiento->fechaHoraConta=new DateTime();
            
            $requerimiento->save();
            DB::commit();

            return redirect()->route('RequerimientoBS.Listar')
                ->with('datos','Requerimiento '.$requerimiento->codigoCedepas.' Contabilizado! ');
        } catch (\Throwable $th) {
           Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : CONTABILIZAR',$th);
           DB::rollBack();

           return redirect()->route('RequerimientoBS.Listar')
                ->with('datos','Ha ocurrido un error.');
        }

    }


    public function descargarPDF($codRequerimiento){
        $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
        $pdf = $requerimiento->getPDF();
        return $pdf->download('Requerimiento de Bienes y servicios '.$requerimiento->codigoCedepas.'.Pdf');
    }   
    
    public function verPDF($codRequerimiento){
        $requerimiento = RequerimientoBS::findOrFail($codRequerimiento);
        $pdf = $requerimiento->getPDF();
        return $pdf->stream('Requerimiento de Bienes y servicios '.$requerimiento->codigoCedepas.'.Pdf');
    }



}
