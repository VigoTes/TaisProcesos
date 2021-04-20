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
use App\Indicador;

class SubprocesoController extends Controller
{

    public function verIndicadores($idSubproceso){
        
        $listaIndicadores = Indicador::where('idSubproceso','=',$idSubproceso)->get();
        
        $subproceso = Subproceso::findOrFail($idSubproceso);
        $proceso = "";
        $buscarpor ="";
        $cadenaParaCrear = $subproceso->idSubproceso."*0";
        $cadenaParaVolverAlEdit = route('empresa.edit',$subproceso->getProceso()->idEmpresa);
        $empresa = $subproceso->getEmpresa();
        return view('tablas.Indicadores.listarIndicadores',compact('listaIndicadores','proceso','subproceso','buscarpor'
        ,'cadenaParaCrear','cadenaParaVolverAlEdit','empresa'));

    }

    
}
