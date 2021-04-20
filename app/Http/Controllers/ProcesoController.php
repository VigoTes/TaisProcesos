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
use App\Indicador;
class ProcesoController extends Controller
{
    

    
    public function verIndicadores($idProceso){
        $listaIndicadores = Indicador::where('idProceso','=',$idProceso)->get();
        $proceso = Proceso::findOrFail($idProceso);
        $subproceso = "";
        $buscarpor ="";
        $cadenaParaCrear = $proceso->idProceso."*1";
        $empresa = $proceso->getEmpresa();
        $cadenaParaVolverAlEdit = route('empresa.edit',$proceso->idEmpresa);
      
        return view('tablas.Indicadores.listarIndicadores',compact('listaIndicadores','subproceso','proceso','buscarpor',
            'cadenaParaCrear','cadenaParaVolverAlEdit','empresa'));

    }


















    

    

}
