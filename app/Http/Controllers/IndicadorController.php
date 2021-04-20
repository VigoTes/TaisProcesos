<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Indicador;
use Illuminate\Http\Request;

use App\Proceso;
use App\RegistroIndicador;
use App\Subproceso;
use App\Cambio;
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
        $listaRegistros = RegistroIndicador::where('idIndicador','=',$idIndicador)->get();
        $empresa = $indicador->getEmpresa();
        return view('tablas.Indicadores.editarIndicador',compact('indicador','listaRegistros','empresa'));

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



        $indicador->frecuenciaDeMedicion = $request->frecuenciaDeMedicion;
        $indicador->unidadDeFrecuencia = $request->unidadDeFrecuencia;
        $indicador->lineaBase = $request->lineaBase;
        $indicador->unidadDeMedida = $request->unidadDeMedida;
        $indicador->limite1 = $request->limite1;
        $indicador->limite2 = $request->limite2;
        $indicador->sentidoDeSemaforo = $request->sentidoDelSemaforo;
        


        $indicador ->save();

        Cambio::registrarCambio($indicador->getEmpresa()->idEmpresa,'Se actualizaron los datos del indicador '.$indicador->nombre);
         

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



        $indicador->frecuenciaDeMedicion = $request->frecuenciaDeMedicion;
        $indicador->unidadDeFrecuencia = $request->unidadDeFrecuencia;
        $indicador->lineaBase = $request->lineaBase;
        $indicador->unidadDeMedida = $request->unidadDeMedida;
        $indicador->limite1 = $request->limite1;
        $indicador->limite2 = $request->limite2;
        $indicador->sentidoDeSemaforo = $request->sentidoDelSemaforo;
        






        if($request->idSubproceso==""){//ES DE PROCESO 
            $indicador->idProceso = $request->idProceso;
            $indicador ->save();

            $proceso = Proceso::findOrFail($indicador->idProceso);
            Cambio::registrarCambio($proceso->getEmpresa()->idEmpresa,'Se ha creado el indicador '.$request->nombre.' del proceso '.$proceso->nombre);
            

            return redirect()->route('proceso.verIndicadores',$indicador->idProceso)
                ->with('datos','Indicador '.$indicador->nombre.' añadido exitosamente ');

        }else{
            $indicador->idSubproceso = $request->idSubproceso;
            $indicador ->save();
            $subproceso = Proceso::findOrFail($indicador->idSubproceso);
            
            Cambio::registrarCambio($subproceso->getEmpresa()->idEmpresa,'Se ha creado el indicador '.$request->nombre.' del proceso '.$subproceso->nombre);
            
            return redirect()->route('subproceso.verIndicadores',$indicador->idSubproceso)
                ->with('datos','Indicador '.$indicador->nombre.' añadido exitosamente ');

        }
        
        

    }



    public function eliminar($idIndicador){
        $indicador = Indicador::findOrFail($idIndicador);

        $indicador ->delete();

        Cambio::registrarCambio($indicador->getEmpresa()->idEmpresa,'Se ha eliminado el indicador '.$indicador->nombre.' del '.$indicador->getCompletarNombre());


        if($indicador->esDeProceso()){//ES DE PROCESO 
            return redirect()->route('proceso.verIndicadores',$indicador->idProceso)
                ->with('datos','Indicador '.$indicador->nombre.' eliminado exitosamente ');

        }else{
            return redirect()->route('subproceso.verIndicadores',$indicador->idSubproceso)
                ->with('datos','Indicador '.$indicador->nombre.' eliminado exitosamente ');
        }



    }



    public function agregarEditarRegistro(Request $request){
        
        if($request->idRegistro=="-1") //NUEVO REGISTRO
        {
            
            $registro = new RegistroIndicador();
            $registro->idIndicador = $request->idIndicador;
            $variacionMensaje=" añadido ";

        }else{//YA EXISTE Y SE ESTÁ ACTUALIZANDO
            $registro = RegistroIndicador::findOrFail($request->idRegistro);            
            $variacionMensaje=" actualizado ";
        }
        
        $registro->valor =$request->valorNuevoRegistro;
        $registro->nombrePeriodo = $request->nombrePeriodo;
        $registro->save();

        $indicador = Indicador::findOrFail($request->idIndicador);

        Cambio::registrarCambio($registro->getIndicador()->getEmpresa()->idEmpresa,'Se ha '.$variacionMensaje.' un registro '.$registro->nombrePeriodo.' del indicador '.$indicador->nombre.' del '.$indicador->getCompletarNombre());

    
        return redirect()->route('Indicadores.editarIndicador',$request->idIndicador)->with('datos','Registro '.$variacionMensaje.'.');
    
    }




    public function eliminarRegistro($idRegistro){
        $registro = RegistroIndicador::findOrFail($idRegistro);
        $registro->delete();


        Cambio::registrarCambio($registro->getIndicador()->getEmpresa()->idEmpresa,'Se ha eliminado el registro '.$registro->nombrePeriodo.' del indicador '.$registro->getIndicador()->nombre.' del '.$registro->getIndicador()->getCompletarNombre());


        return redirect()->route('Indicadores.editarIndicador',$registro->idIndicador)->with('datos','Registro eliminado.');
    
    


    }

}
