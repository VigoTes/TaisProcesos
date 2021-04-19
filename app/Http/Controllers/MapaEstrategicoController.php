<?php

namespace App\Http\Controllers;

use App\ElementoMapa;
use App\FlechaElementoMapa;
use App\Http\Controllers\Controller;
use App\MapaEstrategico;
use App\NivelMapa;
use Illuminate\Http\Request;
use App\Proceso;
use App\Subproceso;

class MapaEstrategicoController extends Controller
{
    public function ver($cadena){

        $vector = explode('*',$cadena);
        $idSubproceso = "";
        $idProceso ="";

        if($vector[1]=='1'){ //PROCESO
            $proceso = Proceso::findOrFail($vector[0]);
            $idProceso =$vector[0];
            $rutaVolverAEditar = route('empresa.edit',$proceso->getEmpresa()->idEmpresa);
            $mapaEstrategico = MapaEstrategico::where('idProceso','=',$idProceso)->get()[0];


        }else{//SUBPROCESO
            $subproceso = Subproceso::findOrFail($vector[0]);
            $idSubproceso = $vector[0];
            $rutaVolverAEditar = route('empresa.edit',$subproceso->getProceso()->getEmpresa()->idEmpresa);
            $mapaEstrategico = MapaEstrategico::where('idSubproceso','=',$idSubproceso)->get()[0];

        }

        $listaNiveles = NivelMapa::All();
        
        $listaFinanciera = ElementoMapa::where('idMapaEstrategico','=',$mapaEstrategico->idMapaEstrategico)->where('idNivel','=',1)->get();
        $listaClientes= ElementoMapa::where('idMapaEstrategico','=',$mapaEstrategico->idMapaEstrategico)->where('idNivel','=',2)->get();
        $listaProcesoInternos= ElementoMapa::where('idMapaEstrategico','=',$mapaEstrategico->idMapaEstrategico)->where('idNivel','=',3)->get();
        $listaAprendizaje= ElementoMapa::where('idMapaEstrategico','=',$mapaEstrategico->idMapaEstrategico)->where('idNivel','=',4)->get();



        return view('tablas.MapaEstrategico.verMapa',compact('mapaEstrategico','rutaVolverAEditar','listaNiveles',
        'listaFinanciera','listaClientes','listaProcesoInternos','listaAprendizaje','mapaEstrategico'
    
    ));

    }

    public function crearRelacion($cadena){
        $vector = explode(',',$cadena);

        $elemento1 = ElementoMapa::findOrFail($vector[0]);
        $elemento2 = ElementoMapa::findOrFail($vector[1]);
        
        if($elemento1->idNivel > $elemento2->idNivel){  
            $elementoDestino = $elemento2;
            $elementoOrigen = $elemento1;
        }else{
            $elementoDestino = $elemento1;
            $elementoOrigen = $elemento2;
        }

        $error = false;
        if($elementoOrigen->idNivel != $elementoDestino->idNivel + 1){
             $mensaje = ('Solo se puede crear relaciones entre elementos de niveles contiguos.');
             $error = true;
        }

        if(FlechaElementoMapa::comprobarExistencia($elementoOrigen->idElemento,$elementoDestino->idElemento)){
            $error=true;
            $mensaje = ('Ya existe una relación entre estos elementos.');
        }

        if(!$error){
            $flecha = new FlechaElementoMapa();
            $flecha->idElementoOrigen = $elementoOrigen->idElemento;
            $flecha->idElementoDestino = $elementoDestino->idElemento;
            $flecha->save();
            $mensaje = 'Se agregó la relación elemento "'.$elementoOrigen->nombre.'" hacia "'.$elementoDestino->nombre.'" exitosamente.';
        }




        $mapa = MapaEstrategico::findOrFail($elementoDestino->idMapaEstrategico);
        if($mapa->esDeProceso()){
            $cad = $mapa->idProceso."*1";

        }else{
            $cad = $mapa->idSubproceso."*0";
        }
        return redirect()->route('MapaEstrategico.ver',$cad)
            ->with('datos',$mensaje);


    }


    public function eliminarRelacion($idFlecha){

        $flecha = FlechaElementoMapa::findOrFail($idFlecha);
        $elemento = ElementoMapa::findOrFail($flecha->idElementoOrigen);

        $flecha->delete();


        $mapa = MapaEstrategico::findOrFail($elemento->idMapaEstrategico);
        if($mapa->esDeProceso()){
            $cad = $mapa->idProceso."*1";

        }else{
            $cad = $mapa->idSubproceso."*0";
        }

        
        $mensaje ="Se eliminó la relación.";
        return redirect()->route('MapaEstrategico.ver',$cad)
            ->with('datos',$mensaje);

    }


    public function agregarElemento(Request $request){

        $elemento = new ElementoMapa();
        $elemento->nombre = $request->nombreNuevoElemento;
        $elemento->idNivel = $request->ComboBoxNivel;
        $elemento->idMapaEstrategico = $request->idMapaEstrategico;
        $elemento->save();

        $mapa = MapaEstrategico::findOrFail($elemento->idMapaEstrategico);
        if($mapa->esDeProceso()){
            $cad = $mapa->idProceso."*1";

        }else{
            $cad = $mapa->idSubproceso."*0";
        }


        return redirect()->route('MapaEstrategico.ver',$cad)
            ->with('datos','Se agregó el elemento '.$elemento->nombre.' exitosamente.');
    }


    public function eliminarElemento($idElemento){
        
        
        $elemento = ElementoMapa::findOrFail($idElemento);

        //tenemos que borrar todas las relaciones en las que aparece ese elemento
        FlechaElementoMapa::
            where('idElementoOrigen','=',$elemento->idElemento)
            ->orwhere('idElementoDestino','=',$elemento->idElemento)->delete();

        
        $mapa = MapaEstrategico::findOrFail($elemento->idMapaEstrategico);
        $cad = $mapa->getCadenaParaVerMapa();
        $elemento->delete();


        return redirect()->route('MapaEstrategico.ver',$cad)
            ->with('datos','Se eliminó el elemento "'.$elemento->nombre.'" exitosamente.');


    }

}
