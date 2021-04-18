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
use App\CambioEdicion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SubprocesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        $proceso = Proceso::findOrFail($request->idProceso);
        $subproceso = new Subproceso();
        
        $subproceso->nombre = $request->nombreProcesoNuev;
        $subproceso->idProceso = $proceso->idProceso;
        //ahora calculamos el nro en proceso
        
        //obtenemos la cantidad de Subprocesos que tiene este PROCESO
        $query = Subproceso::where('idProceso','=',$proceso->idProceso)->get();
        //seleccionamos el idmayor
        $mayor=0;
        foreach ($query as $valor)
            {
                error_log(' X 
                ');
               if($valor->nroEnProceso > $mayor)
                     $mayor=$valor->nroEnProceso;
             }
        $subproceso->nroEnProceso = $mayor+1; 
        //ya tenemos el nroEnEmpresa, podemos guardar el valor
        

        $subproceso->save();

        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($proceso->idEmpresa , "Se creó un subproceso " ,Auth::id(),"",
             "nroEnProceso = ".$subproceso->nroEnProceso." nombre = ".$subproceso->nombre);
              

        //retornamos a la vista de edit proceso
        return redirect()->route('proceso.edit', $proceso->idProceso);     

    }

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
    public function edit($id) //le pasamos el id del subproceso a editar
    {
        $subproceso = Subproceso::findOrFail($id);
        $proceso = Proceso::findOrFail($subproceso->idProceso);
            return view('tablas.subprocesos.edit',compact('subproceso','proceso'));


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
        $actualizado = Subproceso::findOrFail($id); 
        
        $proceso = Proceso::findOrFail($actualizado->idProceso);

        $anterior = $actualizado->nombre;
        $actualizado->nombre =  $request->nombre;
        $actualizado->save();


        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($proceso->idEmpresa , "Se editó un subproceso " ,
        Auth::id(),"anteriorNombre = ".$anterior,
             " nombre = ".$actualizado->nombre);
          

        return redirect()->route('proceso.edit',$actualizado->idProceso);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//le pasamos la id del subproceso a borrar
    {
        $subproceso = Subproceso::findOrFail($id);
        $proceso = Proceso::findOrFail($subproceso->idProceso);
        $idProceso = $subproceso->idProceso;
        $subproceso->delete();


        //para este subproceso, debemos borrar las celdas de las matrices que le involucran
        //Como estamos borrando subprocesos, buscamos las matrices de esta empresa de tipo 3 y 4
        DB::select("
            delete celdamatriz FROM celdamatriz
            inner join matrizprocorg on matrizprocorg.idMatriz = celdamatriz.idMatriz        
                WHERE 
                    idFila=$id
                    and idEmpresa =  $proceso->idEmpresa
                    and (tipoDeMatriz='3' or tipoDeMatriz='4')
        ");







        //REGISTRO EN EL HISTORIAL
        $historial = new CambioEdicion();
        $historial->registrarCambio($proceso->idEmpresa , "Se eliminó un subproceso " ,
        Auth::id(), "anteriorNombre = ".$subproceso->nombre,
             "");

             
        return redirect()->route('proceso.edit',$idProceso);

    }

    public function confirmar($id){ //pasamos el id del subproceso a borrar
        $subproceso = Subproceso::findOrFail($id);
        $proceso = Proceso::findOrFail($subproceso->idProceso);
        $empresaFocus = Empresa::findOrFail($proceso->idEmpresa);
            return view ('tablas.subprocesos.confirmar',compact('subproceso','empresaFocus'));

    }
}
