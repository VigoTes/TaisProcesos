<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFondos;
use App\Banco;
use App\DetalleSolicitudFondos;
use App\Proyecto;
use App\Sede;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use App\CDP;
use App\DetalleRendicionGastos;
use App\RendicionGastos;
use App\SolicitudFalta;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;


use App\Debug;
use App\Numeracion;
use App\ProyectoContador;
use DateTime;
use PhpOffice\PhpWord;
use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Style\Font;



class RendicionGastosController extends Controller
{
    

    const PAGINATION = '20';
    const raizArchivo = "RendGast-CDP-";

    //RUTA MAESTRA QUE REDIRIJE A LOS INDEX DE LOS 3 ACTORES
    public function listarRendiciones(){

        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            //lo enrutamos hacia su index
            return redirect()->route('RendicionGastos.Gerente.Listar')->with($datos,$msj);
        }

        if($empleado->esJefeAdmin())//si es jefe de Administracion
        {
            return redirect()->route('RendicionGastos.Administracion.Listar')->with($datos,$msj);
        }

        if($empleado->esContador())//si es jefe de Administracion
        {
            return redirect()->route('RendicionGastos.Contador.Listar')->with($datos,$msj);
        }

        


        return redirect()->route('RendicionGastos.Empleado.Listar')->with($datos,$msj);


    }

    public function listarContador(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado = Empleado::getEmpleadoLogeado();

        //solicitudes de un proyecto (filtro)
        $solicitudesDeProyecto=SolicitudFondos::where('codProyecto','=',$codProyectoBuscar)->get();
        $arr1=[];
        foreach ($solicitudesDeProyecto as $item) {
            $arr1[]=$item->codSolicitud;
        }

        //proyectos del Contador
        $detalles=ProyectoContador::where('codEmpleadoContador','=',$empleado->codEmpleado)->get();
        if(count($detalles)==0)
            return redirect()->route('error')->with('datos',"No tiene ningún proyecto asignado...");
         
        $arr2=[];
        foreach ($detalles as $itemproyecto) {
            $solicitudesDeProyecto=SolicitudFondos::where('codProyecto','=',$itemproyecto->codProyecto)->get();
            foreach ($solicitudesDeProyecto as $item) {
                $arr2[]=$item->codSolicitud;
            }
        }

        $estados =[];
        array_push($estados,RendicionGastos::getCodEstado('Aprobada') );
        array_push($estados,RendicionGastos::getCodEstado('Contabilizada') );
        
        $listaRendiciones = RendicionGastos::whereIn('codEstadoRendicion',$estados);
        if($codProyectoBuscar==0){
            $listaRendiciones=$listaRendiciones->whereIn('codSolicitud',$arr2);
        }else{
            $listaRendiciones=$listaRendiciones->whereIn('codSolicitud',$arr1);
        }
        if($codEmpleadoBuscar!=0){
            $listaRendiciones=$listaRendiciones->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $listaRendiciones=$listaRendiciones->where('fechaHoraRendicion','>',$fechaInicio)
                ->where('fechaHoraRendicion','<',$fechaFin);
        }
        $listaRendiciones=$listaRendiciones->orderBy('fechaHoraRendicion','DESC')->get();
        
        $listaRendiciones = RendicionGastos::ordenarParaContador($listaRendiciones)
            ->paginate($this::PAGINATION);
          

        //proyectos disponibles
        $arr2=[];
        foreach ($detalles as $itemproyecto) {
            $arr2[]=$itemproyecto->codProyecto;
        }
        $proyectos=Proyecto::whereIn('codProyecto',$arr2)->get();
        $empleados=Empleado::getEmpleadosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;




        return view('RendicionGastos.Contador.ListarRendiciones',compact('listaRendiciones','empleado','codEmpleadoBuscar','codProyectoBuscar','empleados','proyectos','fechaInicio','fechaFin'));
    }


    //retorna todas las rendiciones, tienen prioridad de ordenamiento las que están esperando reposicion
    public function listarJefeAdmin(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado = Empleado::getEmpleadoLogeado();
        //solo considera reposiciones hechas por empleados de su misma sede
        $empleados=Empleado::where('codSede','=',$empleado->codSede)->get();
        $arr2=[];
        foreach ($empleados as $itemempleado) {
            $arr2[]=$itemempleado->codEmpleado;
        }

        //solicitudes de un proyecto (filtro)
        $solicitudesDeProyecto=SolicitudFondos::where('codProyecto','=',$codProyectoBuscar)->get();
        $arr1=[];
        foreach ($solicitudesDeProyecto as $item) {
            $arr1[]=$item->codSolicitud;
        }

        $listaRendiciones = RendicionGastos::where('codEstadoRendicion','>','0');
        if($codProyectoBuscar!=0){
            $listaRendiciones=$listaRendiciones->whereIn('codSolicitud',$arr1);
        }
        if($codEmpleadoBuscar==0){
            $listaRendiciones=$listaRendiciones->whereIn('codEmpleadoSolicitante',$arr2);
        }else{
            $listaRendiciones=$listaRendiciones->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $listaRendiciones=$listaRendiciones->where('fechaHoraRendicion','>',$fechaInicio)
                ->where('fechaHoraRendicion','<',$fechaFin);
        }
        $listaRendiciones=$listaRendiciones->orderby('fechaHoraRendicion','DESC')->get();

        $listaRendiciones = RendicionGastos::ordenarParaGerente($listaRendiciones)
            ->paginate($this::PAGINATION);
          

        
        $proyectos=Proyecto::getProyectosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;
        
        return view('RendicionGastos.Administracion.ListarRendiciones',compact('listaRendiciones','empleado','empleados','proyectos','codEmpleadoBuscar','codProyectoBuscar','fechaInicio','fechaFin'));
        
    }


    //lista todas las rendiciones del gerente (pertenecientes a los  proyectos que este lidera)
    public function listarDelGerente(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';

        
        $empleado = Empleado::getEmpleadoLogeado();
        $proyectos= $empleado->getListaProyectos();
        
        if(count($proyectos)==0)
            return redirect()->route('error')->with('datos',"No tiene ningún proyecto asignado...");
        
        //solicitudes de un proyecto (filtro)
        $solicitudesDeProyecto=SolicitudFondos::where('codProyecto','=',$codProyectoBuscar)->get();
        $arr1=[];
        foreach ($solicitudesDeProyecto as $item) {
            $arr1[]=$item->codSolicitud;
        }
        //proyectos del gerente
      
        
        $arr2=[];
        foreach ($proyectos as $itemproyecto) {
            $solicitudesDeProyecto=SolicitudFondos::where('codProyecto','=',$itemproyecto->codProyecto)->get();
            foreach ($solicitudesDeProyecto as $item) {
                $arr2[]=$item->codSolicitud;
            }
        }

        if($codProyectoBuscar==0){
            $listaRendiciones=RendicionGastos::whereIn('codSolicitud',$arr2);
        }else{
            $listaRendiciones=RendicionGastos::whereIn('codSolicitud',$arr1);
        }
        if($codEmpleadoBuscar!=0){
            $listaRendiciones=$listaRendiciones->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $listaRendiciones=$listaRendiciones->where('fechaHoraRendicion','>',$fechaInicio)
                ->where('fechaHoraRendicion','<',$fechaFin);
        }

        $listaRendiciones=$listaRendiciones->orderBy('fechaHoraRendicion','DESC')->get();

        $listaRendiciones = RendicionGastos::ordenarParaGerente($listaRendiciones)
            ->paginate($this::PAGINATION);
          


        $empleados=Empleado::getEmpleadosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;


        return view('RendicionGastos.Gerente.ListarRendiciones',compact('listaRendiciones','empleado','proyectos','empleados','codEmpleadoBuscar','codProyectoBuscar','fechaInicio','fechaFin'));
        
    }

    //retorna las rendiciones del emp logeado, tienen prioridad de ordenamiento las que están esperando reposicion
    public function listarEmpleado(Request $request){
        //filtros
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado = Empleado::getEmpleadoLogeado();
        //primero agarramos las solicitudes del empleado logeado
        //$listaSolicitudes = SolicitudFondos::where('codEmpleadoSolicitante','=',$empleado->codEmpleado)->get();

        
        $listaSolicitudesPorRendir = $empleado->getSolicitudesPorRendir();
        //solicitudes de un proyecto
        $solicitudesDeProyecto=SolicitudFondos::where('codProyecto','=',$codProyectoBuscar)->get();
        $arr=[];
        foreach ($solicitudesDeProyecto as $item) {
            $arr[]=$item->codSolicitud;
        }
         
        $listaRendiciones = RendicionGastos::
            where('codEmpleadoSolicitante','=',Empleado::getEmpleadoLogeado()->codEmpleado);
            

        if($codProyectoBuscar==0){
            $listaRendiciones= RendicionGastos::
                where('codEmpleadoSolicitante','=',Empleado::getEmpleadoLogeado()->codEmpleado);
        }else
            $listaRendiciones= RendicionGastos::
                where('codEmpleadoSolicitante','=',Empleado::getEmpleadoLogeado()->codEmpleado)
                ->whereIn('codSolicitud',$arr);

        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $listaRendiciones=$listaRendiciones->where('fechaHoraRendicion','>',$fechaInicio)
                ->where('fechaHoraRendicion','<',$fechaFin);
        }
        
        $listaRendiciones = $listaRendiciones->orderBy('fechaHoraRendicion','DESC')->get();
        $listaRendiciones = RendicionGastos::ordenarParaEmpleado($listaRendiciones)
            ->paginate($this::PAGINATION);
            
        $proyectos=Proyecto::getProyectosActivos();


        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;
        
        return view('RendicionGastos.Empleado.ListarRendiciones',
            compact('listaRendiciones','empleado','listaSolicitudesPorRendir','proyectos','codProyectoBuscar','fechaInicio','fechaFin'));
        
    }


    
   




    //del empleado
    public function ver($id){ 
        $rendicion = RendicionGastos::findOrFail($id);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$solicitud->codSolicitud)->get();
        
        return view('RendicionGastos.Empleado.VerRendicion',compact('rendicion','solicitud','empleado','detallesRend','detallesSolicitud'));
    }
    
    //despliuega vista de  rendicion, del admiin
    public function verAdmin($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $rendicion = RendicionGastos::findOrFail($id);

        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.Administracion.VerRendicionGastos',compact('rendicion','solicitud','empleado','detallesRend'));     
    }


    //despliuega vista de  rendicion,
    public function verGerente($codRend){ 
        //le pasamos la id de la solicitud de fondos a la que está enlazada
        
        $rendicion = RendicionGastos::findOrFail($codRend);
        
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.Gerente.RevisarRendicionGastos',compact('rendicion','solicitud','empleado','detallesRend'));        
    }

    //despliuega vista de  contabilizar rendicion,
    public function verContabilizar($id){ //le pasamos la id de la rend
        $rendicion = RendicionGastos::findOrFail($id);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();

        return view('RendicionGastos.Contador.ContabilizarRendicionGastos',compact('rendicion','solicitud','empleado','detallesRend'));
    }




    public function contabilizar($cadena ){
        
        try {
            DB::beginTransaction(); 
            $vector = explode('*',$cadena);
            $codRendicion = $vector[0];
            $listaItems = explode(',',$vector[1]);

            $rendicion = RendicionGastos::findOrFail($codRendicion);

            if(!$rendicion->listaParaContabilizar())
                return redirect()->route('RendicionGastos.ListarRendiciones')
                    ->with('datos','Error: la rendicion ya fue contabilizada o no se encuentra lsita para serlo.');

            $rendicion->codEstadoRendicion =  RendicionGastos::getCodEstado('Contabilizada');
            $rendicion->codEmpleadoContador = Empleado::getEmpleadoLogeado()->codEmpleado;
            $rendicion->save();

            if( $vector[1] != "" )
                foreach ($listaItems as $item) {
                    $detGasto = DetalleRendicionGastos::findOrFail($item);
                    $detGasto->contabilizado = 1;
                    $detGasto->save();   
                }
            
            
            DB::commit();
            return redirect()->route('RendicionGastos.Contador.Listar')
                ->with('datos','Se contabilizó correctamente la Rendicion '.
                    $rendicion->codigoCedepas);

        } catch (\Throwable $th) {
            Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('RendicionGastos.Contador.Listar')
                ->with('datos','Ha ocurrido un error');
        }


    }




    //despliega vista de edicion EMPLEADO de la rend
    public function editar($idRendicion){
        $rendicion = RendicionGastos::findOrFail($idRendicion);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $listaCDP = CDP::All();
        return view('RendicionGastos.Empleado.EditarRendicionGastos',compact('rendicion','solicitud','listaCDP'));

    }



    public function revisar($id){ //le pasamos la id de la rendicion de gastos
        $rendicion = RendicionGastos::findOrFail($id);

        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.Gerente.RevisarRendicionGastos',compact('rendicion','solicitud','empleado','detallesRend'));
    }

    /* YA NO SE RECHAZAN RENDICIONES , SOLO SE LAS OBSERVA */
    
    public function aprobar(Request $request){
        try{

            DB::beginTransaction();
           
            $rendicion = RendicionGastos::findOrFail($request->codRendicionGastos);

            if(!$rendicion->listaParaAprobar())
                return redirect()->route('RendicionGastos.ListarRendiciones')
                    ->with('datos','Error: la rendicion ya fue aprobada o no se encuentra lsita para serlo.');

            $rendicion->codEstadoRendicion = RendicionGastos::getCodEstado('Aprobada');
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $rendicion->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $rendicion->fechaHoraRevisado = Carbon::now();
            
            $rendicion->resumenDeActividad = $request->resumen;
            $rendicion->save();

            $listaDetalles = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
            foreach($listaDetalles as $itemDet){
                $itemDet->codigoPresupuestal = $request->get('CodigoPresupuestal'.$itemDet->codDetalleRendicion);
                $itemDet->save();
            }

            DB::commit();
            return redirect()->route('RendicionGastos.Gerente.Listar')
            ->with('datos','Rendicion '.$rendicion->codigoCedepas.' Aprobada');

        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN RENDICION GASTOS CONTROLLER : APROBAR
            
                '.$th.'

            ');

            DB::rollBack();
            return redirect()->route('RendicionGastos.Gerente.Listar')
            ->with('datos','Ha ocurrido un error');
        }

    }




    public function observar($cadena){

        try{
            $vector = explode('*',$cadena);
            if(count($vector)<2)
                throw new Exception('El argumento cadena no es valido');

            $codRendicion = $vector[0];
            $textoObs = $vector[1];

            DB::beginTransaction();
            error_log('cod rend = '.$codRendicion);
            $rendicion = RendicionGastos::findOrFail($codRendicion);

            if(!$rendicion->listaParaObservar())
                return redirect()->route('RendicionGastos.ListarRendiciones')
                    ->with('datos','Error: la rendicion no se encuentra lista para ser observada.');




            $rendicion->codEstadoRendicion = RendicionGastos::getCodEstado('Observada');
            $rendicion->observacion = $textoObs;
            error_log('
            
            
            
            razon request:'.$textoObs);
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $rendicion->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $rendicion->fechaHoraRevisado = Carbon::now();
            

            $rendicion->save();
            DB::commit();
            return redirect()->route('RendicionGastos.ListarRendiciones')
            ->with('datos','Rendicion '.$rendicion->codigoCedepas.' Observada');

        } catch (\Throwable $th) {
            Debug::mensajeError('RENDICION GASTOS CONTROLLER : OBSERVAR',$th);
      
            DB::rollBack();
            return redirect()->route('RendicionGastos.ListarRendiciones')
            ->with('datos','Ha ocurrido un error');
        }

    }











    
    
    
    
    
    
    
    
    
    /* 
    ALMACENAR LOS DATOS Y LOS ARCHIVOS DE DETALLES QUE ESTAN SUBIENDO
    CADA ARCHIVO ES UNA FOTO DE UN CDP, pero están independientes xd o sea un archivo no está ligado necesariamente a un item de gasto 

    https://www.itsolutionstuff.com/post/laravel-7-multiple-file-upload-tutorialexample.html
    */
    public function store( Request $request){
        try {
           
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($request->codigoSolicitud);


            if($solicitud->estaRendida=='1')
                return redirect()->route('RendicionGastos.ListarRendiciones')
                    ->with('datos','Error: la solicitud ya se ha rendido.');

            if( !($solicitud->verificarEstado('Abonada') || $solicitud->verificarEstado('Contabilizada')) )
                return redirect()->route('RendicionGastos.ListarRendiciones')
                    ->with('datos','Esta solicitud no puede ser rendida puesto que está en el estado '.$solicitud->getNombreEstado().".");

            
            $solicitud ->estaRendida = 1; //cambiamos el estaod de la solicitud a rendida
            $solicitud->save();

            $rendicion = new RendicionGastos();
            $rendicion-> codSolicitud = $solicitud->codSolicitud;
            $rendicion->codEmpleadoSolicitante = Empleado::getEmpleadoLogeado()->codEmpleado;
            $rendicion-> totalImporteRecibido = $solicitud->totalSolicitado; //ESTE ES EL DE LA SOLICITUD
            $rendicion-> totalImporteRendido = $request->totalRendido;
            $rendicion-> saldoAFavorDeEmpleado = $rendicion->totalImporteRendido - $rendicion->totalImporteRecibido;
            $rendicion-> resumenDeActividad = $request->resumen;
            $rendicion-> fechaHoraRendicion = Carbon::now();
            $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Creada');
            $rendicion->codMoneda = $solicitud->codMoneda;

            $rendicion->codigoCedepas = RendicionGastos::calcularCodigoCedepas(Numeracion::getNumeracionREN());
            Numeracion::aumentarNumeracionREN();
            

            $rendicion-> save();    
            $codRendRecienInsertada = (RendicionGastos::latest('codRendicionGastos')->first())->codRendicionGastos;
            

            $vec[] = '';
            
            //PRIMERO RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleRendicionGastos();
                $detalle->codRendicionGastos=          $codRendRecienInsertada ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020
                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fecha=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnRendicion = $i+1;         
                $detalle->save(); 
                $i=$i+1;
            }    
            

            Debug::mensajeSimple('LLEGO 1 ');
            $nombresArchivos = explode(', ',$request->nombresArchivos);
            $j=0;
            $terminacionesArchivos='';
            foreach ($request->file('filenames') as $archivo)
            {   
                Debug::mensajeSimple('LLEGO 2 ');
                //separamos con puntos en un vector 
                $vectorS = explode('.',$nombresArchivos[$j]);
                $terminacion = end($vectorS); //ultimo elemento del vector
                $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
                Debug::mensajeSimple('LLEGO 3 ');
                //               CDP-   000002                           -   5   .  jpg
                $nombreImagen = $this::raizArchivo.$this->rellernarCerosIzq($codRendRecienInsertada,6).'-'.$this->rellernarCerosIzq($j+1,2).'.'.$terminacion  ;
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                $fileget = \File::get( $archivo );
                Debug::mensajeSimple('LLEGO 4 ');
                Storage::disk('rendiciones')
                ->put($nombreImagen,$fileget );
                $j++;
            }

            $rendicion->cantArchivos = $j;
            $terminacionesArchivos = trim($terminacionesArchivos,'/');
            $rendicion->terminacionesArchivos=$terminacionesArchivos;

            $rendicion->save();
            Debug::mensajeSimple('LLEGO 5 ');

            DB::commit();  
            return redirect()
                ->route('RendicionGastos.Empleado.Listar')
                ->with('datos','Se ha creado la rendicion N°'.$rendicion->codigoCedepas);
        }catch(Exception $e){
            
            error_log('\\n ---------------------- RENDICION GASTOS CONTROLLER STORE 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );

            DB::rollback();
            return redirect()
                ->route('RendicionGastos.Empleado.Listar')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }




















    public function prueba(){
        $lista = RendicionGastos::where('codRendicionGastos','>',50)->get(); 
        $lista->push("AAAAAAAAAAAA");
        return $lista;

    }  

    
    


    public function update( Request $request){
        try {

            
            DB::beginTransaction();   
            $rendicion = RendicionGastos::findOrFail($request->codRendicion);


            if(!$rendicion->listaParaActualizar())
            return redirect()->route('RendicionGastos.ListarRendiciones')
                ->with('datos','Error: la rendicion no puede ser actualizada ahora puesto que está en otro proceso.');







            $rendicion-> totalImporteRendido = $request->totalRendido;
            $rendicion-> saldoAFavorDeEmpleado = $rendicion->totalImporteRendido - $rendicion->totalImporteRecibido;
            $rendicion-> resumenDeActividad = $request->resumen;
            $rendicion->observacion = "";
            //si estaba observada, pasa a subsanada
            if($rendicion->verificarEstado('Observada'))
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Subsanada');
            else
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Creada');
            $rendicion-> save();        
            
            //borramos todos los detalles pq los ingresaremos again
            DB::select('delete from detalle_rendicion_gastos where codRendicionGastos=" '.$rendicion->codRendicionGastos.'"');

            //RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleRendicionGastos();
                $detalle->codRendicionGastos=          $rendicion->codRendicionGastos ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020
                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fecha=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnRendicion = $i+1;          
                $i=$i+1;
                $detalle->save();

            }    


            //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
            if( $request->nombresArchivos!='' ){
                $rendicion->borrarArchivosCDP();
                
                $nombresArchivos = explode(', ',$request->nombresArchivos);
                $terminacionesArchivos='';   $j=0;
                foreach ($request->file('filenames') as $archivo) //guardamos los que se insertaron ahora 
                {   
              
                    //separamos con puntos en un vector 
                    $vectorS = explode('.',$nombresArchivos[$j]);
                    $terminacion = end($vectorS); //ultimo elemento del vector
                    $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
                    
                    //               CDP-   000002                           -   5   .  jpg
                    $nombreImagen = RendicionGastos::getFormatoNombreCDP($rendicion->codRendicionGastos ,$j+1 ,$terminacion ) ;
                    Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                    $fileget = \File::get( $archivo );
                
                    Storage::disk('rendiciones')
                    ->put($nombreImagen,$fileget );
                    $j++;
                }

                $rendicion->cantArchivos = $j;
                $terminacionesArchivos = trim($terminacionesArchivos,'/');
                $rendicion->terminacionesArchivos=$terminacionesArchivos;
            }
            $rendicion->save();
            


            DB::commit();  
            return redirect()
                ->route('RendicionGastos.Empleado.Listar')
                ->with('datos','Se ha Editado la rendicion N°'.$rendicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError(' RENDICION GASTOS CONTROLLER UPDATE' ,$th);
            
            DB::rollback();
            return redirect()
                ->route('RendicionGastos.Empleado.Listar')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }


    



    function rellernarCerosIzq($numero, $nDigitos){
       return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);

    }


    //se le pasa el INDEX del archivo 
    function descargarCDP($cadena){
        
        $vector = explode('*',$cadena);
        $codRend = $vector[0];
        $i = $vector[1];
        
        $rendicion = RendicionGastos::findOrFail($codRend);
        $nombreArchivo = RendicionGastos::getFormatoNombreCDP(
                $rendicion->codRendicionGastos,$i,$rendicion->getTerminacionNro($i)
        );
 
        return Storage::download("/comprobantes/rendiciones/".$nombreArchivo);

    }








    public function Reportes(Request $request){

        try 
        {
              

            $fechaI = $request->fechaI;
            $fechaF = $request->fechaF;
            
            $tipoInforme = $request->tipoInforme;

           
            switch ($tipoInforme) {
                case '1': //POR SEDES
                    //Reporte de las sumas acumuladas de los gastos de cada sede, con fecha inicio y fecha final
                    $listaX = RendicionGastos::reportePorSedes($fechaI,$fechaF);
                    
                    return view('RendicionGastos.Administracion.Reportes.ReporteSedes',compact('listaX','fechaI','fechaF'));
                    


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = RendicionGastos::reportePorEmpleados($fechaI,$fechaF);
                    
                    return view('RendicionGastos.Administracion.Reportes.ReporteEmpleado',compact('listaX','fechaI','fechaF'));
                    break;
                case '3':

                    $listaX = RendicionGastos::reportePorProyectos($fechaI,$fechaF);
                    return view('RendicionGastos.Administracion.Reportes.ReporteProyectos',compact('listaX','fechaI','fechaF'));
                
                    break;
                
                case '4':
                    $sede  = Sede::findOrFail($request->ComboBoxSede);
                    $listaX = RendicionGastos::reportePorSedeYEmpleados($fechaI,$fechaF,$sede->codSede);

                return view('RendicionGastos.Administracion.Reportes.ReporteEmpleadoXSede',compact('listaX','fechaI','fechaF','sede'));
                    break;

                            
                default:
                    # code...
                    break;
            }

        } catch (\Throwable $th) {
            

            error_log('\\n ----------------------  RENDICION GASTOS : REPORTES
            Ocurrió el error:'.$th->getMessage().'


            ' );

            return $th->getMessage();

        }
    }



    public function descargarReportes($string){
        try 
        {
            error_log('----------------------------------------------------------'.$string);
            $vector = explode('*',$string);

            
            
            $fechaI      = $vector[0];
            $fechaF      = $vector[1];
            $tipoInforme = $vector[2];
            if ($tipoInforme == 4)
                $codSede = $vector[3];

            $nombreVista = '';
            $argumentosVista ='';
            switch ($tipoInforme) {
                case '1': //POR SEDES
                    //Reporte de las sumas acumuladas de los gastos de cada sede, con fecha inicio y fecha final
                    //return $fechaI;
                    //return $fechaF;
                    $listaX = RendicionGastos::reportePorSedes($fechaI,$fechaF);
                    
                // return  $listaX;
                $nombreVista = 'RendicionGastos.Administracion.Reportes.ReporteSedes';
                $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = RendicionGastos::reportePorEmpleados($fechaI,$fechaF);
                    

                    $nombreVista = 'RendicionGastos.Administracion.Reportes.ReporteEmpleado';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    break;
                case '3':

                    $listaX = RendicionGastos::reportePorProyectos($fechaI,$fechaF);
                    

                    $nombreVista = 'RendicionGastos.Administracion.Reportes.ReporteProyectos';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    
                break;
                case '4':
                    $sede = Sede::findOrFail($codSede);
                    $listaX = RendicionGastos::reportePorSedeYEmpleados($fechaI,$fechaF,$codSede);


                    $nombreVista = 'RendicionGastos.Administracion.Reportes.ReporteEmpleadoXSede';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI,'sede'=>$sede);
                            
                    
                    break;

                            
                default:
                    # code...
                    break;
            }
          

            $pdf = new PDF();
       
            
            $pdf = PDF::loadView($nombreVista,$argumentosVista)->setPaper('a4','landscape');
            return $pdf->download('informeMiau.Pdf');

        } catch (\Throwable $th) {
        
            error_log('\\n ----------------------  RENDICIONGASTOS: DESCARGAR REPORTES
            Ocurrió el error:'.$th->getMessage().'


            ' );

        }
    }

    
    //funcion servicio, será consumida solo por javascript
    public function listarDetalles($idRendicion){
        $vector = [];
        $listaDetalles = DetalleRendicionGastos::where('codRendicionGastos','=',$idRendicion)->get();
        for ($i=0; $i < count($listaDetalles) ; $i++) { 
            
            $itemDet = $listaDetalles[$i];
            $itemDet['nombreTipoCDP'] = $itemDet->getNombreTipoCDP(); //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
           
                // formato dado por sql 2021-02-11   
                //formato requerido por mi  12/02/2020
                $fechaDet = $itemDet->fecha;
                //DAMOS VUELTA A LA FECHA
                                // DIA                  MES                 AÑO
            $nuevaFecha=substr($fechaDet,8,2).'/'.substr($fechaDet,5,2).'/'.substr($fechaDet,0,4);
            $itemDet['fechaFormateada'] = $nuevaFecha;
            array_push($vector,$itemDet);            
        }
        return $vector  ;
    }

    public function descargarPDF($codRendicion){
        $rendicion = RendicionGastos::findOrFail($codRendicion);
        $pdf = $rendicion->getPDF();
        return $pdf->download('Rendición de Gastos '.$rendicion->codigoCedepas.'.Pdf');
    }   
    
    public function verPDF($codRendicion){
        $rendicion = RendicionGastos::findOrFail($codRendicion);
        $pdf = $rendicion->getPDF();
        return $pdf->stream('Rendición de Gastos '.$rendicion->codigoCedepas.'.Pdf');
    }


}
