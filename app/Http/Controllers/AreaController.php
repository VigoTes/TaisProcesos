<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Objetivo;
use App\Elemento;
use App\Estrategia;
use App\Usuario;
use App\Proceso;
use App\Subproceso;
use App\Area;
use App\Puesto;
use App\CambioEdicion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Matriz;

class AreaController extends Controller
{
    const PAGINATION = 20; // PARA QUE PAGINEE DE 10 EN 10
    public function index(Request $Request)
    {
    }

    public function listar(Request $Request,$idEmpresa)
    {
       
        if($idEmpresa==0) //si no ha seleccionado una empresa, lo redirije al index para que escoja una
            return redirect()->route('empresa.index')->with('msjLlegada','Error: Debe escoger una empresa para editar.');
        
        $usuario = Usuario::findOrFail(Auth::id());
        $empresa = Empresa::findOrFail($idEmpresa);

        $buscarpor = $Request->buscarpor;
              
        $area = Area::where('idEmpresa','=',$idEmpresa)
            ->where('nombreArea','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION); 

        $empresaFocus = $empresa;
        
        //cuando vaya al index me retorne a la vista
        return view('tablas.areas.index',compact('area','empresaFocus','buscarpor')); 

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //la empresa focuseada en la que crearemos el proceso
    {

   
    }

    public function crear($idEmpresa) //la empresa focuseada en la que crearemos el proceso
    {

        $empresaFocus = Empresa::findOrFail($idEmpresa);
        
        return view('tablas.areas.create',compact('empresaFocus'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $empresaFocus = Empresa::findOrFail($request->idEmpresaFocus);

        $nuevo = new Area;
        $nuevo->descripcionArea = $request->descripcionArea;
        $nuevo->nombreArea = $request->nombreArea;
        $nuevo->idEmpresa = $empresaFocus->idEmpresa;
        //el idArea es Auto Increm, no tengo que ponerlo
        // ahora debo calcular el nro en empresa de este proceso

        error_log('EL IDEMPRESA FOCUSEADO ES '.$empresaFocus->idEmpresa);
        //obtenemos la cantidad de procesos que tiene la empresa
        $query = Area::where('idEmpresa','=',$empresaFocus->idEmpresa)->get();
        //seleccionamos el idmayor
        $mayor=0;
        
        foreach ($query as $valor)
            {
                error_log(' X 
                ');
               if($valor->nroEnEmpresa > $mayor)
                     $mayor=$valor->nroEnEmpresa;
             }
        $nuevo->nroEnEmpresa = $mayor+1; 
        //ya tenemos el nroEnEmpresa, podemos guardar el valor
        error_log('*******REPORTE***********
        EL NUMERO MAYOR ES : '.$mayor.'
        ');
        $nuevo->save();

        $idEmpresa = $empresaFocus->idEmpresa;
        $Request = $request;

        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($idEmpresa, "Se creó un area.",Auth::id(),
                    "",$nuevo->nombreArea);
        


        return redirect()->route('area.listar',$idEmpresa);
            
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //se le manda la id del Area a editar
    {
        $area=Area::findOrFail($id);
        $listaPuestos = Puesto::where('idArea','=',$id)->get();
        $empresaFocus = Empresa::findOrFail($area->idEmpresa);

        return view('tablas.areas.edit',compact('area','listaPuestos','empresaFocus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $area = Area::findOrFail($id);
        $antValor = $area->nombreArea."  /\  ".$area->descripcionArea ;

        $area->nombreArea = $request->nombreArea;
        $area->descripcionArea = $request->descripcionArea;

        $nueValor = $area->nombreArea."  /\  ".$area->descripcionArea ;
        $area->save();


        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($area->idEmpresa, "Se editó un area.",Auth::id(),
                                    $antValor,$nueValor);

        return redirect()->route('area.listar',$area->idEmpresa);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $listaPuestos = Puesto::where('idArea','=',$id)->get();
        $idEmpresa = $area->idEmpresa;
        $area->delete();

        //si se borra un area deben borrarse sus puestos 
        DB::select("
            delete FROM Puesto
                    WHERE idArea=$id
        ");


        //Si se borra un area se deben borrar sus apariciones en las matrices
        //Como estamos borrando areas, buscamos las matrices de esta empresa de tipo 1 y 3
        //para cada una de estas matrices, borramos las celdas que incluyan la id de esta Area (columnas)
                DB::select("
                    delete celdamatriz FROM celdamatriz
                    inner join matrizprocorg on matrizprocorg.idMatriz = celdamatriz.idMatriz        
                        WHERE 
                            idColumna=$id
                            and idEmpresa =  $idEmpresa
                            and (tipoDeMatriz='1' or tipoDeMatriz='3')


                ");
        foreach ($listaPuestos as $itemPuesto) {
        //para cada puesto de esta Area, debemos borrar las celdas de las matrices que le involucran
        //Como estamos borrando puestos, buscamos las matrices de esta empresa de tipo 2 y 4
                DB::select("
                    delete celdamatriz FROM celdamatriz
                    inner join matrizprocorg on matrizprocorg.idMatriz = celdamatriz.idMatriz        
                        WHERE 
                            idColumna=$itemPuesto->idPuesto
                            and idEmpresa =  $idEmpresa
                            and (tipoDeMatriz='2' or tipoDeMatriz='4')


                ");
        }

        
        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($area->idEmpresa, "Se eliminó un area y sus puestos.",Auth::id(),
                                    "idAreaEliminada=".$area->idArea." nombre=".$area->nombreArea,"");
        

        return redirect()->route('area.listar',$idEmpresa);

    }

    public function confirmar($id){
        $area = Area::findOrFail($id);
        $empresaFocus = Empresa::findOrFail($area->idEmpresa);
            return view ('tablas.areas.confirmar',compact('area','empresaFocus'));

    }
}
