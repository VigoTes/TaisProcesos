<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Objetivo;
use App\Elemento;
use App\Estrategia;
use App\Usuario;
use App\CeldaMatriz;
use Illuminate\Support\Facades\DB;
use App\Area;
use App\EmpresaUsuario;
use App\Proceso;
use App\Puesto;
use App\Subproceso;


use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use App\User;
use App\Empleado;
use App\MapaEstrategico;

class EmpresaController extends Controller
{
    const PAGINATION = 10; // PARA QUE PAGINEE DE 10 EN 10
    
    public function listarTodas(Request $Request){
        $empleado = Empleado::getEmpleadoLogeado();
        
        $buscarpor = $Request->buscarpor;
        $listaEmpresas = Empresa::getActivas();
        

        //cuando vaya al index me retorne a la vista
        return view('tablas.empresas.ListarEmpresas',compact('listaEmpresas','buscarpor')); 
       


    }

    public function listarMisEmpresas(Request $Request)
    {
        $empleado = Empleado::getEmpleadoLogeado();
        
        $buscarpor = $Request->buscarpor;
        $listaEmpresas = $empleado->getEmpresasDelEmpleado();
        
        $empresaFocus = new Empresa();
        $empresaFocus->nombreEmpresa = 'Ninguna';
        $empresaFocus->idEmpresa = 0;

        //cuando vaya al index me retorne a la vista
        return view('tablas.empresas.MisEmpresas',compact('listaEmpresas','buscarpor','empresaFocus')); 
       
    }



    //PARA SELECCIONAR UNA EMPRESA Y QUE ESTÉ EN FOCUS PUES 
    public function listar(Request $Request, $id) //MTODO PROBANDO BORRAR SI QUIERES
    {
        $buscarpor = $Request->buscarpor;

        $usuario = Usuario::findOrFail(Auth::id());
        $empresa = $usuario->empresasDelUsuario($buscarpor);
        /* 
        $empresa = Empresa::where('estadoAct','=','1')
            ->where('nombreEmpresa','like','%'.$buscarpor.'%')
            ->where('idUsuario','=',Auth::id())
            ->paginate($this::PAGINATION);
         */
        $empresaFocus = Empresa::findOrFail($id);

        //cuando vaya al index me retorne a la vista
        return view('tablas.empresas.index',compact('empresa','buscarpor','empresaFocus')); 
        //el compact es para pasar los datos , para meter mas variables meterle mas comas dentro del compact


        // otra forma sería hacer ['categoria'] => $categoria
    }
    

    public function create()
    {

        $empresaFocus = new Empresa();
        $empresa=$empresaFocus;
        $empresaFocus->nombreEmpresa = 'Ninguna';
        $empresaFocus->idEmpresa = 0;


        return view('tablas.empresas.create',compact('empresa','empresaFocus'));
    }

    public function store(Request $request)
    {
        
        $empresa = request()->validate(
            [
                'nombreEmpresa'=>'required|max:100',
                'mision'=>'required|max:1000',
                'vision'=>'required|max:1000',
                'factorDif'=>'required|max:1000',
                'propuestaV'=>'required|max:100',
                'direccion'=>'required|max:200',
                'RUC'=>'required|size:13'
                
            ],[
                'nombreEmpresa.required'=>'Ingrese nombre de la Empresa',
                'nombreEmpresa.max' => 'Maximo 100 caracteres la descripcion',
                 
                'mision.required'=>'Ingrese la mision de la Empresa',
                'mision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'vision.required'=>'Ingrese la mision de la Empresa',
                'vision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'factorDif.required'=>'Ingrese el factor diferenciador',
                'factorDif.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'propuestaV.required'=>'Ingrese la propuesta de valor',
                'propuestaV.max' => 'Maximo 100 caracteres la descripcion',
                 
                'direccion.required'=>'Ingrese la direccion de la empresa',
                'direccion.max' => 'Maximo 200 caracteres la descripcion',

                'RUC.required'=>'Ingrese el ruc de la empresa',
                'RUC.size' => 'Debe tener 13 caracteres'

            ]

            );

            

            $empresa = new Empresa();
            $empresa->nombreEmpresa=$request->nombreEmpresa;
            $empresa->mision=$request->mision;
            $empresa->vision=$request->vision;
            $empresa->factorDif=$request->factorDif;
            $empresa->propuestaV=$request->propuestaV;
            $empresa->direccion=$request->direccion;
            $empresa->RUC=$request->RUC;
            $empresa->estadoAct='1';
          //  $empresa->idUsuario = Auth::user()->id;
                          
            $empresa->save(); /* Guardamos el nuevo registro en la BD */
            
            $listaEmpresas = Empresa::all();
            $empresa = $listaEmpresas->last();

            $empresaUsuario = new EmpresaUsuario();
            $empresaUsuario->idEmpleado = Empleado::getEmpleadoLogeado()->idEmpleado;
            $empresaUsuario->idEmpresa = $empresa->idEmpresa;
            $empresaUsuario->save();

            /* Regresamos al index con el mensaje de nuevo registro */
            return redirect()->route('empresa.index')->with('msjLlegada','Registro nuevo guardado');
                
        }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if($id==0) //si no ha seleccionado una empresa, lo redirije al index para que escoja una
            return redirect()->route('empresa.index')->with('msjLlegada','Error: Debe escoger una empresa para editar.');
                
        $empresa=Empresa::findOrFail($id);
        $listaProcesos = Proceso::where('idEmpresa','=',$empresa->idEmpresa)->get();
        $empresaFocus = $empresa; 

        return view('tablas.empresas.edit',compact('empresa','empresaFocus','listaProcesos'));


    }

    public function update(Request $request, $id)
    {
        $empresa = request()->validate(
            [
                'nombreEmpresa'=>'required|max:100',
                'mision'=>'required|max:1000',
                'vision'=>'required|max:1000',
                'factorDif'=>'required|max:1000',
                'propuestaV'=>'required|max:1000',
                'direccion'=>'required|max:200',
                'RUC'=>'required|size:13'
                
            ],[
                'nombreEmpresa.required'=>'Ingrese nombre de la Empresa',
                'nombreEmpresa.max' => 'Maximo 100 caracteres la descripcion',
                 
                'mision.required'=>'Ingrese la mision de la Empresa',
                'mision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'vision.required'=>'Ingrese la mision de la Empresa',
                'vision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'factorDif.required'=>'Ingrese el factor diferenciador',
                'factorDif.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'propuestaV.required'=>'Ingrese la propuesta de valor',
                'propuestaV.max' => 'Maximo 100 caracteres la propuesta de valor',
                 
                'direccion.required'=>'Ingrese la direccion de la empresa',
                'direccion.max' => 'Maximo 200 caracteres la descripcion',

                'RUC.required'=>'Ingrese el ruc de la empresa',
                'RUC.size' => 'El Ruc Debe tener 13 caracteres'
            ]

            );

            $empresa=Empresa::findOrFail($id);
            $empresa->nombreEmpresa=$request->nombreEmpresa;
            $empresa->mision=$request->mision;
            $empresa->vision=$request->vision;
            $empresa->factorDif=$request->factorDif;
            $empresa->propuestaV=$request->propuestaV;
            $empresa->direccion=$request->direccion;
            $empresa->RUC=$request->RUC;
                          
            $empresa->save(); /* Guardamos el nuevo registro en la BD */
                
            /* Regresamos al index con el mensaje de nuevo registro */
            return redirect()->route('empresa.edit',$id)->with('msjLlegada','Registro editado Exitosamente');
             
    }

    public function destroy($id)
    {

        $empresa = Empresa::findOrFail($id);
        $empresa->estadoAct = '0';
        $empresa->save ();
        return redirect() -> route('empresa.index')->with('msjLlegada','Registro eliminado!!');

    }

    public function eliminarEmpresaComoAdmin($idEmpresa){
        $empresa = Empresa::findOrFail($idEmpresa);
        $empresa->estadoAct = '0';
        $empresa->save ();
        return redirect()->route('empresa.listarTodas')->with('msjLlegada','Registro eliminado!!');


    }

    public function eliminarEmpresaComoEmpleado($idEmpresa){
        $empresa = Empresa::findOrFail($idEmpresa);
        $empresa->estadoAct = '0';
        $empresa->save ();
        return redirect()->route('empresa.index')->with('msjLlegada','Registro eliminado!!');


    }



    public function confirmar($id){
        $empresa = Empresa::findOrFail($id); 
        $empresaFocus = $empresa;
        return view('tablas.empresas.confirmar',compact('empresa','empresaFocus'));
    }

    /* FUNCION PARA REDIRIGIRNOS A LA MATRIZ FODA DE ESTA EMPRESA
        MANDANDOLE COMO PARAMETRO LA EMPRESA
    */
    
    


    
    function agregarEditarProceso(Request $request){

        if($request->idProceso=="-1") //NUEVO PROCESO
        {
            $proceso = new Proceso();
            $proceso->idEmpresa = $request->idEmpresa;
            $variacionMensaje=" añadido ";

            
           
        }else{//YA EXISTE Y SE ESTÁ ACTUALIZANDO
            $proceso = Proceso::findOrFail($request->idProceso);
            $variacionMensaje=" actualizado ";
            

        }
        $proceso->nombre = $request ->nombreNuevoProceso;
        $proceso->descripcion = $request ->descripcionNuevoProceso;
        $proceso->save();

        $mapa = new MapaEstrategico();
        $mapa->idProceso = $proceso->idProceso;
        $mapa->save();


        return redirect()->route('empresa.edit',$proceso->idEmpresa)->with('datos','Proceso '.$proceso->nombre." ".$variacionMensaje." exitosamente.");
    

    }


    function eliminarProceso($idProceso){
        $proceso = Proceso::findOrFail($idProceso);
        $nombre=  $proceso->nombre;
        $proceso->delete();
        return redirect()->route('empresa.edit',$proceso->idEmpresa)->with('datos','Proceso '.$nombre." eliminado exitosamente.");
    
    }
 
    function agregarEditarSubproceso(Request $request){



        if($request->idSubproceso=="-1") //NUEVO SUBPROCESO
        {
            $subproceso = new Subproceso();
            $variacionMensaje = " Agregado ";
        }else{
            $subproceso = Subproceso::findOrFail($request->idSubproceso);
            $variacionMensaje = " Actualizado ";
        }
        
        $subproceso->nombre = $request ->nombreNuevoSubproceso;
        $subproceso->idProceso = $request->ComboBoxProceso;
        $subproceso->save();

        $mapa = new MapaEstrategico();
        $mapa->idSubproceso = $subproceso->idSubproceso;
        $mapa->save();


        return redirect()->route('empresa.edit',$subproceso->getProceso()->idEmpresa)->with('datos','Subproceso '.$subproceso->nombre." ".$variacionMensaje." exitosamente.");
    

    }
 
    function eliminarSubproceso($idSubproceso){
        $subproceso = Subproceso::findOrFail($idSubproceso);
        $nombre=  $subproceso->nombre;
        $subproceso->delete();

        return redirect()->route('empresa.edit',$subproceso->getProceso()->idEmpresa)->with('datos','Subproceso '.$nombre." eliminado exitosamente.");
    
    }
    
    public function matrizProcOrg($id){ //le pasamos id de la empresa
        
    }



}
