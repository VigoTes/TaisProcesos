<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cambio;
use App\Empresa;
class CambioController extends Controller
{
    public function verHistorialCambios(Request $request){

        if($request->idEmpresa=="")
            $listaEdiciones = Cambio::All();
        else
            $listaEdiciones = Cambio::where('idEmpresa','=',$request->idEmpresa)->get();

        $listaEmpresas = Empresa::All();

        return view('tablas.historial.listar',compact('listaEdiciones','listaEmpresas'));
    }


}
