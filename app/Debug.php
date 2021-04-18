<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debug extends Model
{
    //ESTE NO ES UN MODELO, ES UNA CLASE PARA PRINTEAR MSJS BACANES EN LA CONSOLA
    
    
    public static function mensajeError($claseDondeOcurrio, $mensajeDeError){
        error_log('********************************************
        
            HA OCURRIDO UN ERROR EN : '.$claseDondeOcurrio.'
        
            MENSAJE DE ERROR:

            '.$mensajeDeError.'


        ***************************************************************
        ');

    } 
    
    public static function mensajeSimple($msj){
        error_log('********************************************
            MENSAJE SIMPLE:

            '.$msj.'


        ***************************************************************
        ');

    } 
    


}
