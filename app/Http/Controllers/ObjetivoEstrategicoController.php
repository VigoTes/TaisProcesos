<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\ObjetivoEstrategico;


class ObjetivoEstrategicoController extends Controller
{
    
    public function listar(){
        $objetivosEstrategicos = ObjetivoEstrategico::where('codObjetivoEstrategico','>',0)->orderBy('año','DESC')->get();

        return view('ObjetivosEstrategicos.ListarObjetivosEstrategicos',compact('objetivosEstrategicos'));
    }


    public function crear(){

        return view('ObjetivosEstrategicos.CrearObjetivoEstrategico');

    }


    public function guardar(Request $request){
        $obj = new ObjetivoEstrategico(); 
        $obj->descripcion = $request->descripcion;
        $obj->año = $request->año;
        $obj->esActual = '1';
        
        $obj->save();

        return redirect()->route('ObjetivoEstrategico.listar')->with('datos','¡Objetivo Estratégico añadido exitosamente!');

    }



    public function editar($codObjetivoEstrategico){

        $ObjetivoEstrategico = ObjetivoEstrategico::findOrFail($codObjetivoEstrategico);
        return view('ObjetivosEstrategicos.EditarObjetivoEstrategico',compact('ObjetivoEstrategico'));

    }

    public function actualizar(Request $request){

        $obj =  ObjetivoEstrategico::findOrFail($request->codObjetivoEstrategico); 
        $obj->descripcion = $request->descripcion;
        $obj->año = $request->año;
        $obj->save();

        return redirect()->route('ObjetivoEstrategico.listar')
            ->with('datos','¡Objetivo estratégico añadido exitosamente!');

    }

    public function eliminar($codObjetivoEstrategico){
        $registro =  ObjetivoEstrategico::findOrFail($codObjetivoEstrategico); 
        
        $registro->delete();

        return redirect()->route('ObjetivoEstrategico.listar')
            ->with('datos','Objetivo Estrategico   '.$codObjetivoEstrategico.' ELIMINADO exitosamente!');


    }



    public function desactivar($codObjetivoEstrategico){
        $obj =  ObjetivoEstrategico::findOrFail($codObjetivoEstrategico); 
        
        $obj->esActual = '0';
        $obj->save();
        return redirect()->route('ObjetivoEstrategico.listar')
        ->with('datos','Objetivo Estrategico   '.$codObjetivoEstrategico.' desactivado exitosamente!');


    }


}
