<?php

namespace App\Http\Controllers;

use App\Banco;
use App\CDP;
use App\Debug;
use App\DetalleReposicionGastos;
use App\Empleado;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Proyecto;
use App\ProyectoContador;
use App\Puesto;
use App\ReposicionGastos;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Numeracion;
class ReposicionGastosController extends Controller
{
    const PAGINATION = '20';

    public function listarReposiciones(){

        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            return redirect()->route('ReposicionGastos.Gerente.Listar')->with($datos,$msj);
        }
        if($empleado->esJefeAdmin()){
            return redirect()->route('ReposicionGastos.Administracion.Listar')->with($datos,$msj);
        }
        if($empleado->esContador()){
            return redirect()->route('ReposicionGastos.Contador.Listar')->with($datos,$msj);
        }
        return redirect()->route('ReposicionGastos.Empleado.Listar')->with($datos,$msj);

    }

    //funcion servicio, será consumida solo por javascript
    public function listarDetalles($idReposicion){
        $vector = [];
        $listaDetalles = DetalleReposicionGastos::where('codReposicionGastos','=',$idReposicion)->get();
        for ($i=0; $i < count($listaDetalles) ; $i++) { 
            
            $itemDet = $listaDetalles[$i];
            $itemDet['nombreTipoCDP'] = $itemDet->getNombreTipoCDP(); //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
            
                // formato dado por sql 2021-02-11   
                //formato requerido por mi  12/02/2020
                $fechaDet = $itemDet->fechaComprobante;
                //DAMOS VUELTA A LA FECHA
                                // DIA                  MES                 AÑO
            $nuevaFecha=substr($fechaDet,8,2).'/'.substr($fechaDet,5,2).'/'.substr($fechaDet,0,4);
            $itemDet['fechaFormateada'] = $nuevaFecha;
            array_push($vector,$itemDet);            
        }
        return $vector  ;
    }



    function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
    }
    /**EMPLEADO */



    public function listarOfEmpleado(Request $request){
        //filtros
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado=Empleado::getEmpleadoLogeado();

        if($codProyectoBuscar==0){
            $reposiciones= ReposicionGastos::
            where('codEmpleadoSolicitante','=',$empleado->codEmpleado);
        }else
            $reposiciones= ReposicionGastos::
            where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
                ->where('codProyecto','=',$codProyectoBuscar);
            
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $reposiciones=$reposiciones->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }

        $reposiciones= ReposicionGastos::ordenarParaEmpleado($reposiciones->orderBy('fechaHoraEmision','DESC')->get())
        ->paginate($this::PAGINATION);


        $proyectos=Proyecto::getProyectosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;
       
        return view('ReposicionGastos.Empleado.ListarReposiciones',
            compact('reposiciones','empleado','codProyectoBuscar','proyectos','fechaInicio','fechaFin'));
    }


    public function view($id){
         
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('ReposicionGastos.Empleado.VerReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function create(){
        $listaCDP = CDP::All();
        $proyectos = Proyecto::getProyectosActivos();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionREP();
        return view('ReposicionGastos.Empleado.CrearReposicionGastos',compact('empleadoLogeado','listaCDP','proyectos',
            'objNumeracion','empleadosEvaluadores','monedas','bancos'));
    }


    public function editar($id){
        $reposicion = ReposicionGastos::findOrFail($id);
        $listaCDP = CDP::All();
        $proyectos = Proyecto::getProyectosActivos();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('ReposicionGastos.Empleado.EditarReposicionGastos',compact('empleadoLogeado','listaCDP','proyectos',
            'empleadosEvaluadores','monedas','bancos','reposicion'));


    }




    /*  
    ALMACENAR LOS DATOS Y LOS ARCHIVOS DE DETALLES QUE ESTAN SUBIENDO
    CADA ARCHIVO ES UNA FOTO DE UN CDP, pero están independientes xd o sea un archivo no está ligado necesariamente a un item de gasto 

    https://www.itsolutionstuff.com/post/laravel-7-multiple-file-upload-tutorialexample.html
    */
    public function store(Request $request){
        try{
            DB::beginTransaction(); 
            $reposicion=new ReposicionGastos();
            $reposicion->codEstadoReposicion=1;
            $reposicion->codEmpleadoSolicitante=Empleado::getEmpleadoLogeado()->codEmpleado;
            //$reposicion->codEmpleadoEvaluador=Proyecto::find($request->codProyecto)->codEmpleadoDirector;
            $reposicion->codProyecto=$request->codProyecto;
            $reposicion->codMoneda=$request->codMoneda;
     
            $reposicion->fechaHoraEmision=Carbon::now();

            $reposicion->girarAOrdenDe=$request->girarAOrdenDe;
            $reposicion->numeroCuentaBanco=$request->numeroCuentaBanco;
            $reposicion->codBanco=$request->codBanco;
            $reposicion->resumen=$request->resumen;
            $reposicion->fechaHoraRevisionGerente=null;
            $reposicion->fechaHoraRevisionAdmin=null;
            $reposicion->observacion=null;
    
            $reposicion->codigoCedepas = ReposicionGastos::calcularCodigoCedepas(Numeracion::getNumeracionREP());
            Numeracion::aumentarNumeracionREP();

            $reposicion->save();
            $codRepRecienInsertada = (ReposicionGastos::latest('codReposicionGastos')->first())->codReposicionGastos;
            
            //creacion de detalles
            $vec[] = '';
            $total=0;
                
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) 
            {
                                    $detalle=new DetalleReposicionGastos();
                    $detalle->codReposicionGastos=$reposicion->codReposicionGastos ;//ultimo insertad
                    // formato requerido por sql 2021-02-11   
                    //formato dado por mi calnedar 12/02/2020
                    $fechaDet = $request->get('colFecha'.$i);
                    //DAMOS VUELTA A LA FECHA
                                                    // AÑO                  MES                 DIA
                    $detalle->fechaComprobante=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                    $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                    $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                    $detalle->concepto=              $request->get('colConcepto'.$i);
                    $detalle->importe=               $request->get('colImporte'.$i);
                    $total+=(float)$request->get('colImporte'.$i);
                    $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                    $detalle->nroEnReposicion = $i+1;
                    $detalle->save();  
                    $i=$i+1;
            }
            $reposicion->totalImporte=$total;
            $reposicion->save();
            
            $nombresArchivos = explode(', ',$request->nombresArchivos);
            $j=0;
            $terminacionesArchivos='';
            foreach ($request->file('filenames') as $archivo)
            {   
                
                //separamos con puntos en un vector 
                $vectorS = explode('.',$nombresArchivos[$j]);
                $terminacion = end($vectorS); //ultimo elemento del vector
                $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
               
                //               CDP-   000002                           -   5   .  jpg

                $nombreImagen = ReposicionGastos::getFormatoNombreCDP($codRepRecienInsertada, $j+1,$terminacion);
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                $fileget = \File::get( $archivo );
                Debug::mensajeSimple('LLEGO 4 ');
                Storage::disk('reposiciones')
                ->put($nombreImagen,$fileget );
                $j++;
            }

            
            $reposicion->cantArchivos = $j;
            $terminacionesArchivos = trim($terminacionesArchivos,'/');
            $reposicion->terminacionesArchivos=$terminacionesArchivos;

            $reposicion->save();

            DB::commit();
            return redirect()->route('ReposicionGastos.Empleado.Listar')
                ->with('datos','Se ha Registrado la reposicion N°'.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER STORE', $th);
            DB::rollBack();
            return redirect()->route('ReposicionGastos.Empleado.Listar')
                ->with('datos','Ha ocurrido un error.');
        }
        
    }





    
    public function update( Request $request){
        
        try {
            $reposicion=ReposicionGastos::findOrFail($request->codReposicionGastos);


            if($reposicion->codEmpleadoSolicitante != Empleado::getEmpleadoLogeado()->codEmpleado)
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser actualizada por un empleado distinto al que la creó.');



            if(!$reposicion->listaParaActualizar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser actualizada ahora puesto que está en otro proceso.');

                






            $reposicion->codProyecto=$request->codProyecto;
            $reposicion->codMoneda=$request->codMoneda;
     
            $reposicion->girarAOrdenDe=$request->girarAOrdenDe;
            $reposicion->numeroCuentaBanco=$request->numeroCuentaBanco;
            $reposicion->codBanco=$request->codBanco;
            $reposicion->resumen=$request->resumen;
            //si estaba observada, pasa a subsanada
            if($reposicion->verificarEstado('Observada'))
                $reposicion-> codEstadoReposicion = ReposicionGastos::getCodEstado('Subsanada');
            else
                $reposicion-> codEstadoReposicion = ReposicionGastos::getCodEstado('Creada');
            $reposicion-> save();        
            



            $total=0;
            //borramos todos los detalles pq los ingresaremos again
            DB::select('delete from detalle_reposicion_gastos where codReposicionGastos=" '.$reposicion->codReposicionGastos.'"');

            //RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleReposicionGastos();
                $detalle->codReposicionGastos=          $reposicion->codReposicionGastos ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020
                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fechaComprobante=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $total+=(float)$request->get('colImporte'.$i);
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnReposicion = $i+1;          
                $i=$i+1;
                $detalle->save();

            }  
            $reposicion->totalImporte=$total;
            $reposicion->save();  

            
            //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
            if( $request->nombresArchivos!='' ){
                $reposicion->borrarArchivosCDP(); /* FALTA HACER ESTA FUNCION */
                
                $nombresArchivos = explode(', ',$request->nombresArchivos);
                $terminacionesArchivos='';   $j=0;
                foreach ($request->file('filenames') as $archivo) //guardamos los que se insertaron ahora 
                {   
              
                    //separamos con puntos en un vector 
                    $vectorS = explode('.',$nombresArchivos[$j]);
                    $terminacion = end($vectorS); //ultimo elemento del vector
                    $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
                    
                    //               CDP-   000002                           -   5   .  jpg
                    $nombreImagen = ReposicionGastos::getFormatoNombreCDP($reposicion->codReposicionGastos ,$j+1 ,$terminacion ) ;
                    Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                    $fileget = \File::get( $archivo );
                
                    Storage::disk('reposiciones')
                    ->put($nombreImagen,$fileget );
                    $j++;
                }

                $reposicion->cantArchivos = $j;
                $terminacionesArchivos = trim($terminacionesArchivos,'/');
                $reposicion->terminacionesArchivos=$terminacionesArchivos;
            }
            $reposicion->save();
            


            DB::commit();  
            return redirect()
                ->route('ReposicionGastos.Empleado.Listar')
                ->with('datos','Se ha Editado la reposicion N°'.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError(' REPOSICION GASTOS CONTROLLER UPDATE' ,$th);
            
            DB::rollback();
            return redirect()
                ->route('ReposicionGastos.Empleado.Listar')
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
            $reposiciones=ReposicionGastos::whereIn('codProyecto',$arr);
        }else{
            $reposiciones=ReposicionGastos::where('codProyecto','=',$codProyectoBuscar);
        }
        
        if($codEmpleadoBuscar!=0){
            $reposiciones=$reposiciones->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $reposiciones=$reposiciones->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }

        //return $reposiciones->get();
        $reposiciones=$reposiciones->orderBy('fechaHoraEmision','DESC')->get();
        
        $reposiciones= ReposicionGastos::ordenarParaGerente($reposiciones)->paginate($this::PAGINATION);
        

        $empleados=Empleado::getEmpleadosActivos();
        $proyectos=Proyecto::whereIn('codProyecto',$arr)->get();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('ReposicionGastos.Gerente.ListarReposiciones',compact('reposiciones','empleado','codProyectoBuscar','codEmpleadoBuscar','proyectos','empleados','fechaInicio','fechaFin'));
    }



    

    public function viewGeren($id){
      
        $reposicion=ReposicionGastos::findOrFail($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('ReposicionGastos.Gerente.EvaluarReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }



    //se le pasa el INDEX del archivo 
    function descargarCDP($cadena){
        $vector = explode('*',$cadena);
        $codRend = $vector[0];
        $i = $vector[1];
        $repo = ReposicionGastos::findOrFail($codRend);
        $nombreArchivo = ReposicionGastos::getFormatoNombreCDP(
                $repo->codReposicionGastos,$i,$repo->getTerminacionNro($i)
        );
        return Storage::download("/comprobantes/reposiciones/".$nombreArchivo);

    }






    
    
    /**JEFE DE ADMINISTRACION */
    public function listarOfJefe(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        // AÑO                  MES                 DIA
        $fechaInicio=substr($request->fechaInicio,6,4).'-'.substr($request->fechaInicio,3,2).'-'.substr($request->fechaInicio,0,2).' 00:00:00';
        $fechaFin=substr($request->fechaFin,6,4).'-'.substr($request->fechaFin,3,2).'-'.substr($request->fechaFin,0,2).' 23:59:59';


        $empleado=Empleado::getEmpleadoLogeado();
       
        //solo considera reposiciones hechas por empleados de su misma sede
        $empleados=Empleado::all();
        /*
        $arr2=[];
        foreach ($empleados as $itemempleado) {
            $arr2[]=$itemempleado->codEmpleado;
        }
        */
        
        $reposiciones=ReposicionGastos::where('codProyecto','!=','-1'); //este en realidad es un All()
        if($codProyectoBuscar!=0)
            $reposiciones=$reposiciones->where('codProyecto','=',$codProyectoBuscar);
        

        if($codEmpleadoBuscar!=0){
           
            $reposiciones=$reposiciones->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }


        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $reposiciones=$reposiciones->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }
        $reposiciones=$reposiciones->orderBy('fechaHoraEmision','DESC')->get();

        //Aqui sucede el filtrado de estados
        $reposiciones= ReposicionGastos::ordenarParaAdministrador($reposiciones)->paginate($this::PAGINATION);
        
        $proyectos=Proyecto::getProyectosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('ReposicionGastos.Jefe.ListarReposiciones',compact('reposiciones','empleado','codProyectoBuscar','proyectos','empleados','codEmpleadoBuscar','fechaInicio','fechaFin'));
    }



    public function viewJefe($id){
         
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        return view('ReposicionGastos.Jefe.AbonarReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
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
            $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codProyecto',$arr2);
        }else{
            $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->where('codProyecto','=',$codProyectoBuscar);
        }
        if($codEmpleadoBuscar!=0){
            $reposiciones=$reposiciones->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        if(strtotime($fechaFin) > strtotime($fechaInicio) && $request->fechaInicio!=$request->fechaFin){
            //$fechaFin='es mayor';
            $reposiciones=$reposiciones->where('fechaHoraEmision','>',$fechaInicio)
                ->where('fechaHoraEmision','<',$fechaFin);
        }
        $reposiciones=$reposiciones->orderBy('fechaHoraEmision','DESC')->get();
        $reposiciones= ReposicionGastos::ordenarParaContador($reposiciones)->paginate($this::PAGINATION);
        
        

        $proyectos=Proyecto::whereIn('codProyecto',$arr2)->get();
        $empleados=Empleado::getEmpleadosActivos();
        $fechaInicio=$request->fechaInicio;
        $fechaFin=$request->fechaFin;

        return view('ReposicionGastos.Contador.ListarReposiciones',compact('reposiciones','empleado','codProyectoBuscar','codEmpleadoBuscar','proyectos','empleados','fechaInicio','fechaFin'));
    }
    public function viewConta($id){
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('ReposicionGastos.Contador.ContabilizarReposicionGastos',compact('reposicion','empleadoLogeado','detalles'));
    }



    public function aprobar(Request $request){//gerente
        //return $request;
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::find($request->codReposicionGastos);

            
            if(!$reposicion->listaParaAprobar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser aprobada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Aprobada');
            $reposicion->codEmpleadoEvaluador=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->resumen = $request->resumen;
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();

            
            $listaDetalles = DetalleReposicionGastos::where('codReposicionGastos','=',$reposicion->codReposicionGastos)->get();
            foreach($listaDetalles as $itemDetalle ){
                $itemDetalle->codigoPresupuestal = $request->get('CodigoPresupuestal'.$itemDetalle->codDetalleReposicion);
                $itemDetalle->save();
            }


            DB::commit();
            
            
            
            
            
            //return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se aprobo correctamente la Reposicion '.$reposicion->codigoCedepas);
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Se aprobo correctamente la Reposicion '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            //return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Ha ocurrido un error');
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Ha ocurrido un error');
        }
    }
    public function abonar($id){//jefe (codReposicion)
        try{
            DB::beginTransaction();
  
            $reposicion=ReposicionGastos::findOrFail($id);

            if(!$reposicion->listaParaAbonar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser abonada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Abonada');
            $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionAdmin=new DateTime();
            $reposicion->save();
            DB::commit();
            //return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se abono correctamente la Reposicion '.$reposicion->codigoCedepas);
            return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se abono correctamente la Reposicion '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            //return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Ha ocurrido un error');
            return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Ha ocurrido un error');

        }
    }

    public function observar($id){//gerente-administracion (codReposicion-observacion)
        try{
            DB::beginTransaction();
            $empleado = Empleado::getEmpleadoLogeado();

            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);

            if(!$reposicion->listaParaObservar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser observada ahora puesto que está en otro proceso.');


            
            if($empleado->esJefeAdmin()){
                $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
                $reposicion->fechaHoraRevisionAdmin=new DateTime();
            }/*
            if($empleado->esContador()){
                $reposicion->codEmpleadoConta=Empleado::getEmpleadoLogeado()->codEmpleado;
                $reposicion->fechaHoraRevisionConta=new DateTime();
            }*/
            if($empleado->esGerente()){
                $reposicion->codEmpleadoEvaluador=Empleado::getEmpleadoLogeado()->codEmpleado;
                $reposicion->fechaHoraRevisionGerente=new DateTime();
            }
            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Observada');
            $reposicion->observacion=$arr[1];
            
            $reposicion->save();
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
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            
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
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Ha ocurrido un error');
        }
    }
    public function rechazar($id){//gerente-jefe (codReposicion)
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::findOrFail($id);

            if(!$reposicion->listaParaRechazar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser rechazada ahora puesto que está en otro proceso.');


            $empleado=Empleado::getEmpleadoLogeado();
        

            if($empleado->esJefeAdmin()){
                $reposicion->codEmpleadoAdmin=$empleado->codEmpleado;
                $reposicion->fechaHoraRevisionAdmin=new DateTime();
            }
            if($empleado->esGerente()){
                $reposicion->codEmpleadoEvaluador=$empleado->codEmpleado;
                $reposicion->fechaHoraRevisionGerente=new DateTime();
            }


            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Rechazada');
            $reposicion->save();
            DB::commit();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Se rechazo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }else{
                return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Se rechazo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }
            */
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Se rechazo correctamente la Reposicion '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('ReposicionGastos.Administracion.Listar')->with('datos','Ha ocurrido un error');
            }else{
                return redirect()->route('ReposicionGastos.Gerente.Listar')->with('datos','Ha ocurrido un error');
            }
            */
            return redirect()->route('ReposicionGastos.Listar')->with('datos','Ha ocurrido un error');
        }

    }


    public function contabilizar($cadena){
        try {
            DB::beginTransaction();
     
            $vector = explode('*',$cadena);
            $codReposicion = $vector[0];
            $listaItems = explode(',',$vector[1]);

            $reposicion = ReposicionGastos::findOrFail($codReposicion);

            if(!$reposicion->listaParaContabilizar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser contabilizada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Contabilizada');
            $reposicion->codEmpleadoConta = Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionConta=new DateTime();
            $reposicion->save();


            if( $vector[1] != "" )
                foreach ($listaItems as $item) { //guardamos como contabilizados los items que nos llegaron
                    Debug::mensajeSimple($item);
                    $detGasto = DetalleReposicionGastos::findOrFail($item);
                    $detGasto->contabilizado = 1;
                    $detGasto->save();   
                }

            DB::commit();
            /*
            return redirect()
                ->route('ReposicionGastos.Contador.Listar')
                ->with('datos','Se contabilizó correctamente la Reposicion '.$reposicion->codigoCedepas);
            */
            return redirect()->route('ReposicionGastos.Contador.Listar')->with('datos','Se contabilizó correctamente la Reposicion '.$reposicion->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            /*
            return redirect()->route('ReposicionGastos.Contador.Listar')
                ->with('datos','Ha ocurrido un error');
            */
            return redirect()->route('ReposicionGastos.Contador.Listar')->with('datos','Ha ocurrido un error');
        }


    }
    public function cancelar($id){
        try {
            DB::beginTransaction();
    
            $reposicion = ReposicionGastos::findOrFail($id);

            if(!$reposicion->listaParaCancelar())
            return redirect()->route('ReposicionGastos.Listar')
                ->with('datos','Error: la reposicion no puede ser cancelada ahora puesto que está en otro proceso.');


            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Cancelada');
            $reposicion->save();
     
            DB::commit();
            return redirect()->route('ReposicionGastos.Empleado.Listar')->with('datos','Se cancelo correctamente la Reposicion '.$reposicion->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER CANCELADA', $th);
            DB::rollBack();
            
            return redirect()->route('ReposicionGastos.Empleado.Listar')->with('datos','Ha ocurrido un error');
        }


    }

    public function descargarPDF($id){
        $reposicion=ReposicionGastos::findOrFail($id);
        $pdf = $reposicion->getPDF();
        return $pdf->download('Reposicion de Gastos '.$reposicion->codigoCedepas.'.Pdf');
    }
    
    public function verPDF($id){
        $reposicion=ReposicionGastos::findOrFail($id);
        $pdf = $reposicion->getPDF();
        return $pdf->stream('Reposicion de Gastos '.$reposicion->codigoCedepas.'.Pdf');
    }




}

