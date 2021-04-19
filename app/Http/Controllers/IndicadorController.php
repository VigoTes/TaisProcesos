<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Indicador;
use Illuminate\Http\Request;

use App\Proceso;
use App\Subproceso;

class IndicadorController extends Controller
{
    public function crearIndicador($cadena){
        $vector = explode('*',$cadena);

        $proceso = "";
        $subproceso="";

        $idSubproceso = "";
        $idProceso ="";

        if($vector[1]=='1'){ //PROCESO
            $proceso = Proceso::findOrFail($vector[0]);
            $idProceso =$vector[0];
            $rutaVolverAListar = route('proceso.verIndicadores',$idProceso);
        

        }else{//SUBPROCESO
            $subproceso = Subproceso::findOrFail($vector[0]);
            $idSubproceso = $vector[0];
            $rutaVolverAListar = route('subproceso.verIndicadores',$idSubproceso);
        
        }

        
        return view('tablas.Indicadores.crearIndicador',compact('proceso','subproceso','idProceso','idSubproceso','rutaVolverAListar'));


    }



    public function editarIndicador($idIndicador){
        $indicador = Indicador::findOrFail($idIndicador);
        return view('tablas.Indicadores.editarIndicador',compact('indicador'));

    }

    public function update(Request $request){


        $indicador = Indicador::findOrFail($request->idIndicador);
        $indicador->nombre = $request->nombre;
        $indicador->P_Mecanismos = $request->P_Mecanismos;
        $indicador->P_QueSeHara = $request->P_QueSeHara;
        $indicador->P_QueMedira = $request->P_QueMedira;
        
        $indicador->P_QuienMedira = $request->P_QuienMedira;
        $indicador->P_Tolerancia = $request->P_Tolerancia;
        $indicador->formula = $request->formula;
        $indicador ->save();

        if($indicador->esDeProceso()){//ES DE PROCESO 
            return redirect()->route('proceso.verIndicadores',$indicador->idProceso)
                ->with('datos','Indicador '.$indicador->nombre.' actualizado exitosamente ');

        }else{
            return redirect()->route('subproceso.verIndicadores',$indicador->idSubproceso)
                ->with('datos','Indicador '.$indicador->nombre.' actualizado exitosamente ');
        }
        

    }


    public function store(Request $request){

        $indicador = new Indicador();
        $indicador->nombre = $request->nombre;
        $indicador->P_Mecanismos = $request->P_Mecanismos;
        $indicador->P_QueSeHara = $request->P_QueSeHara;
        $indicador->P_QueMedira = $request->P_QueMedira;
        
        $indicador->P_QuienMedira = $request->P_QuienMedira;
        $indicador->P_Tolerancia = $request->P_Tolerancia;
        $indicador->formula = $request->formula;

        if($request->idSubproceso==""){//ES DE PROCESO 
            $indicador->idProceso = $request->idProceso;
            $indicador ->save();
            return redirect()->route('proceso.verIndicadores',$indicador->idProceso)
                ->with('datos','Indicador '.$indicador->nombre.' añadido exitosamente ');

        }else{
            $indicador->idSubproceso = $request->idSubproceso;
            $indicador ->save();
            return redirect()->route('subproceso.verIndicadores',$indicador->idSubproceso)
                ->with('datos','Indicador '.$indicador->nombre.' añadido exitosamente ');

        }
        
        

    }



    public function eliminar($idIndicador){



        $indicador = Indicador::findOrFail($idIndicador);
        $indicador ->delete();

        if($indicador->esDeProceso()){//ES DE PROCESO 
            return redirect()->route('proceso.verIndicadores',$indicador->idProceso)
                ->with('datos','Indicador '.$indicador->nombre.' eliminado exitosamente ');

        }else{
            return redirect()->route('subproceso.verIndicadores',$indicador->idSubproceso)
                ->with('datos','Indicador '.$indicador->nombre.' eliminado exitosamente ');
        }



    }


}
