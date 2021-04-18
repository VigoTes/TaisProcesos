<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Empresa;
use App\Objetivo;
use App\Elemento;
use App\Estrategia;
use App\Usuario;
use App\Proceso;
use App\Subproceso;
use App\CambioEdicion;
use Illuminate\Support\Facades\DB;

class ProcesoController extends Controller
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
              
        $proceso = Proceso::where('idEmpresa','=',$idEmpresa)
            ->where('nombreProceso','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION); 

        $empresaFocus = $empresa;
        
        //cuando vaya al index me retorne a la vista
        return view('tablas.procesos.index',compact('proceso','empresaFocus','buscarpor')); 

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
        
        return view('tablas.procesos.create',compact('empresaFocus'));


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

        $nuevo = new Proceso;
        $nuevo->descripcionProceso = $request->descripcionProceso;
        $nuevo->nombreProceso = $request->nombreProceso;
        $nuevo->idEmpresa = $empresaFocus->idEmpresa;
        //el idProceso es Auto Increm, no tengo que ponerlo
        // ahora debo calcular el nro en empresa de este proceso

        error_log('EL IDEMPRESA FOCUSEADO ES '.$empresaFocus->idEmpresa);
        //obtenemos la cantidad de procesos que tiene la empresa
        $query = Proceso::where('idEmpresa','=',$empresaFocus->idEmpresa)->get();
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
        
        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($idEmpresa, "Se creó un proceso.",Auth::id(),
                    "",$nuevo->nombreProceso);
        
        
        
        
        return redirect()->route('proceso.listar',$idEmpresa);
            
        //return view('tablas.procesos.index',compact('proceso','empresaFocus','buscarpor')); 


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
    public function edit($id) //se le manda la id del proceso a editar
    {
        $proceso=Proceso::findOrFail($id);
        $listaSubProcesos = Subproceso::where('idProceso','=',$id)->get();
        $empresaFocus = Empresa::findOrFail($proceso->idEmpresa);
        return view('tablas.procesos.edit',compact('proceso','listaSubProcesos','empresaFocus'));
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
        $proceso = Proceso::findOrFail($id);
        $antValor = $proceso->nombreProceso." /\ ".$proceso->descripcionProceso;

        $proceso->nombreProceso = $request->nombreProceso;
        $proceso->descripcionProceso = $request->descripcionProceso;

        $proceso->save();

        $nueValor = $proceso->nombreProceso." /\ ".$proceso->descripcionProceso;

        $historial = new CambioEdicion();
        $historial->registrarCambio($proceso->idEmpresa, 
                "Se editó un proceso.",Auth::id(),
                    $antValor,
                    $nueValor);

        return redirect()->route('proceso.listar',$proceso->idEmpresa);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proceso = Proceso::findOrFail($id);
        $listaSubprocesos = Subproceso::where('idProceso','=',$id)->get();
        $idEmpresa = $proceso->idEmpresa;
        $proceso->delete();

        //si se borra un area deben borrarse sus puestos 
        DB::select("
            delete FROM subproceso
                    WHERE idProceso=$id
        ");

        
        //Si se borra un proceso se deben borrar sus apariciones en las matrices
        //Como estamos borrando processos, buscamos las matrices de esta empresa de tipo 1 y 2
        //para cada una de estas matrices, borramos las celdas que incluyan la id de esta Area (columnas)
        DB::select("
                delete celdamatriz FROM celdamatriz
                inner join matrizprocorg on matrizprocorg.idMatriz = celdamatriz.idMatriz        
                    WHERE 
                        idFila=$id
                        and idEmpresa =  $idEmpresa
                        and (tipoDeMatriz='1' or tipoDeMatriz='2')


            ");

            // ERROR PARA ARREGLAR CUANDO BORRO UN PROCESO, NO SE BORRAN SUS CELDAS DE SUBPROCESO USADAS
        foreach ($listaSubprocesos as $itemSub) {
        //para cada subpr de este proc, debemos borrar las celdas de las matrices que le involucran
        //Como estamos borrando subprocesos, buscamos las matrices de esta empresa de tipo 3 y 4
            DB::select("
                delete celdamatriz FROM celdamatriz
                inner join matrizprocorg on matrizprocorg.idMatriz = celdamatriz.idMatriz        
                    WHERE 
                        idFila=$itemSub->idSubproceso
                        and idEmpresa =  $idEmpresa
                        and (tipoDeMatriz='3' or tipoDeMatriz='4')


            ");
        }



        $historial = new CambioEdicion();
        $historial->registrarCambio($proceso->idEmpresa, 
                "Se eliminó un proceso y sus subprocesos.",Auth::id(),
                    "idProcesoEliminado=".$id." nombre=".$proceso->nombreProceso,
                    "");

        return redirect()->route('proceso.listar',$idEmpresa);



    }

    public function confirmar($id){
        $proceso = Proceso::findOrFail($id);
        $empresaFocus = Empresa::findOrFail($proceso->idEmpresa);
            return view ('tablas.procesos.confirmar',compact('proceso','empresaFocus'));





    }
    

}
