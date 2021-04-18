<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ObjetivoEstrategico;
use App\PlanEstrategicoInstitucional;
use Illuminate\Http\Request;

class PlanEstrategicoInstitucionalController extends Controller
{
    
    public function listar(){

        $planesEstrategicos = PlanEstrategicoInstitucional::All();
        return view('PlanesEstrategicos.ListarPlanesEstrategicos',compact('planesEstrategicos'));



    }

    public function editar($codPEI){
        $PEI = PlanEstrategicoInstitucional::findOrFail($codPEI);
        $listaObjetivos = ObjetivoEstrategico::where('codPEI','=',$codPEI)->get();
        
        return view('PlanesEstrategicos.EditarPlanEstrategico',compact('PEI','listaObjetivos'));
    }

    public function crear(){


        return view('PlanesEstrategicos.CrearPlanEstrategico');
    }

    public function listarObjetivos($codPEI){

        $objetivos = ObjetivoEstrategico::where('codPEI','=',$codPEI)->get();
        return $objetivos;

    }

    public function guardar(Request $request){


        
        $PEI = new PlanEstrategicoInstitucional();
        $PEI->añoInicio = $request->añoInicio;
        $PEI->añoFin = $request->añoFin;
        $PEI->save();
        
        $codPEI = (PlanEstrategicoInstitucional::latest('codPEI')->first())->codPEI;
        
        $i = 0;
        $cantidadFilas = $request->cantElementos;
        while ($i< $cantidadFilas ) {
            $detalle=new ObjetivoEstrategico();
            $detalle->codPEI= $codPEI;
            $detalle->descripcion= $request->get('descripcion'.$i);
            $detalle->item= $request->get('item'.$i);
            $detalle->nombre= $request->get('nombre'.$i);
            
            $detalle->save();
                    
            $i++;
        }    
        
        return redirect()->route('PlanEstrategico.listar')->with('datos','PEI '.$PEI->getPeriodo().' creado exitosamente');

    }



    public function actualizar(Request $request){
        
        $codPEI = $request->codPEI;
        $PEI = PlanEstrategicoInstitucional::findOrFail($codPEI);
        $PEI->añoInicio = $request->añoInicio;
        $PEI->añoFin = $request->añoFin;
        
        $PEI->save();
        $PEI->eliminarObjetivos();

        $i = 0;
        $cantidadFilas = $request->cantElementos;
        while ($i< $cantidadFilas ) {

            $detalle=new ObjetivoEstrategico();
            $detalle->codPEI= $codPEI;
            $detalle->descripcion= $request->get('descripcion'.$i);
            $detalle->item= $request->get('item'.$i);
            $detalle->nombre= $request->get('nombre'.$i);
            
            $detalle->save();
                    
            $i++;
        }    
        
        return redirect()->route('PlanEstrategico.listar')->with('datos','PEI '.$PEI->getPeriodo().' Actualizado');

    }










}
