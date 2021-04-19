<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    const enProduccion = true;
    const pesoMaximoArchivoMB = 5;

    //en caracteres

    const tamañoMaximoCodigoPresupuestal= 11;//detalles

    const tamañoMaximoConcepto= 60;//detalles
    const tamañoMaximoDescripcion= 100;//detalle requerimiento

    const tamañoMaximoNroEnRendicion= 100;
    const tamañoMaximoNroEnReposicion= 100;
    const valorMaximoNroItem= 100;//solicitud-rendicion (tiny Int)

    const tamañoMaximoNroComprobante= 20;
    
    const tamañoMaximoResumenDeActividad= 300;//rendicion
    const tamañoMaximoResumen= 300;//rendicion
    const tamañoMaximoJustificacion= 300;//solicitud
    
    const tamañoMaximoObservacion= 200;
    const valorMaximoCantArchivos= 100;//(tiny Int)


    //ultimas
    const tamañoMaximoGiraraAOrdenDe= 50;//solicitud
    const tamañoMaximoNroCuentaBanco= 50;//solicitud-reposicion

    public static function getInputTextOHidden(){
        if(Configuracion::enProduccion)
            return "hidden";
    
        return "text";


    } 
    
    public static function getRutaImagenCedepasPNG(){
     
            return "https://maracsoft.com/img/LogoCedepas.png";
       
    }
}
