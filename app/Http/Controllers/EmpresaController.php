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
use App\Rol;
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
            $empresaUsuario->idRol = 0;
            
            $empresaUsuario->save();

            /* Regresamos al index con el mensaje de nuevo registro */
            return redirect()->route('empresa.listarMisEmpresas')->with('msjLlegada','Registro nuevo guardado');
                
        }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {      
        $empresa=Empresa::findOrFail($id);
        $listaProcesos = Proceso::where('idEmpresa','=',$empresa->idEmpresa)->get();
        $listaEmpleadosTodos = Empleado::getEmpleadosActivos();
        $listaEmpleadosEmpresa = $empresa->getListaEmpleados();
        $listaRoles = Rol::All();
        $empresaFocus = $empresa; 

        return view('tablas.empresas.edit',compact('empresa','empresaFocus','listaProcesos',
        'listaEmpleadosEmpresa','listaEmpleadosTodos','listaRoles'));


    }

    public function update(Request $request, $id)
    {
            
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
        return redirect() -> route('empresa.listarMisEmpresas')->with('msjLlegada','Registro eliminado!!');

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
        return redirect()->route('empresa.listarMisEmpresas')->with('msjLlegada','Registro eliminado!!');


    }



    public function confirmar($id){
        $empresa = Empresa::findOrFail($id); 
        $empresaFocus = $empresa;
        return view('tablas.empresas.confirmar',compact('empresa','empresaFocus'));
    }

    /* FUNCION PARA REDIRIGIRNOS A LA MATRIZ FODA DE ESTA EMPRESA
        MANDANDOLE COMO PARAMETRO LA EMPRESA
    */
    
    public function eliminarEmpleado($idAI){
        
        
        $empresaUsuario = EmpresaUsuario::findOrFail($idAI);
        $empresaUsuario->delete();
        $empleado = $empresaUsuario->getEmpleado();

        return redirect()->route('empresa.edit',$empresaUsuario->idEmpresa)
            ->with('datos','Se eliminó al empleado .'.$empleado->getNombreCompleto().'.');

    }
    
    //crea un registro en EmpresaUsuario para que el empleado pueda acceder a la empresa
    public function agregarEditarEmpleado(Request $request){
        
        $empresa = Empresa::findOrFail($request->idEmpresa);
        

        if($request->idAI=="-1") //NUEVO PROCESO
        {

            if($empresa->tieneEmpleado($request->idEmpleado)){
                return redirect()->route('empresa.edit',$empresa->idEmpresa)
                    ->with('datos','El empleado seleccionado ya tiene un rol.');
            }

            $empresaUsuario = new EmpresaUsuario();
            $empresaUsuario->idEmpresa = $request->idEmpresa;
            $variacionMensaje=" añadió ";

        }else{//YA EXISTE Y SE ESTÁ ACTUALIZANDO
            $empresaUsuario = EmpresaUsuario::findOrFail($request->idAI);
            $variacionMensaje=" actualizó ";

        }


        
        $empresaUsuario->idEmpleado = $request->idEmpleado;
        $empleado = Empleado::findOrFail($empresaUsuario->idEmpleado);
        $empresaUsuario->idRol = $request->idRol;
        $empresaUsuario->save();

        return redirect()->route('empresa.edit',$empresaUsuario->idEmpresa)
            ->with('datos','Se '.$variacionMensaje.' al empleado .'.$empleado->getNombreCompleto().'.');


    }


    
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
