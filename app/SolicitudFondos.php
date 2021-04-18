<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SolicitudFondos extends Model
{
    protected $table = "solicitud_fondos";
    protected $primaryKey ="codSolicitud";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    const RaizCodigoCedepas = "SOF";
    // le indicamos los campos de la tabla 
    protected $fillable = ['codProyecto','codigoCedepas','codEmpleadoSolicitante','fechaHoraEmision',
    'totalSolicitado','girarAOrdenDe','numeroCuentaBanco','codBanco','justificacion',
    'codEmpleadoEvaluador','fechaHoraRevisado','codEstadoSolicitud','observacion','codMoneda'];



    /** FORMATO PARA FECHAS*/
    public function formatoFechaHoraEmision(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraEmision));
        return $fecha;
    }
    public function formatoFechaHoraRevisado(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraRevisado));
        return $fecha;
    }

    //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas SOF21-000001
    public static function calcularCodigoCedepas($objNumeracion){
        return  SolicitudFondos::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                SolicitudFondos::rellernarCerosIzq($objNumeracion->numeroLibreActual,6);
    }
    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
        
    }


    public function getPDF(){
        $listaItems = DetalleSolicitudFondos::where('codSolicitud','=',$this->codSolicitud)->get();
        $pdf = \PDF::loadview('SolicitudFondos.Plantillas.PdfSolicitudFondos',
            array('solicitud'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');
        
        return $pdf;
    }
    

    public function getDetalles(){
        return DetalleSolicitudFondos::where('codSolicitud','=',$this->codSolicitud)->get();

    }
    public function getNombreProyecto(){
        $proyecto = Proyecto::findOrFail($this->codProyecto);
        return $proyecto->nombre;
    } 
    public function getProyecto(){
        $proyecto = Proyecto::findOrFail($this->codProyecto);
        return $proyecto;
    } 

    public function getNombreEstado(){
        $estado = EstadoSolicitudFondos::findOrFail($this->codEstadoSolicitud);
        if($estado->nombre=="Creada")
            return "Por Aprobar";
        return $estado->nombre;

    }

    public function getNombreBanco(){
        $banco = Banco::findOrFail($this->codBanco);
        return $banco->nombreBanco;

    }


    /* Retorna el codigo del estado indicado por el str parametro */
    public static function getCodEstado($nombreEstado){
        $lista = EstadoSolicitudFondos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoSolicitud;

    }


    public function estaRendida(){
        return $this->estaRendida==1;

    }

    public function estaRendidaSIoNo(){
        if($this->estaRendida())
            return "SÍ";

        return "NO";
    }
    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){

        

        $lista = EstadoSolicitudFondos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        $estado = $lista[0];
        if($estado->codEstadoSolicitud == $this->codEstadoSolicitud)
            return true;
        
        return false;
        

    }


    public function listaParaAprobar(){
        return $this->verificarEstado('Creada') || $this->verificarEstado('Subsanada');
    }
    public function listaParaAbonar(){
        return $this->verificarEstado('Aprobada'); 
    }
    public function listaParaContabilizar(){
        return $this->verificarEstado('Abonada'); 
    }
    public function listaParaUpdate(){
        return $this->verificarEstado('Creada') ||
         $this->verificarEstado('Subsanada') ||
          $this->verificarEstado('Observada'); 
    }


    
    public function listaParaCancelar(){//solo en los que no fue abonada
        return 
        $this->verificarEstado('Creada') ||
        $this->verificarEstado('Aprobada') ||
        $this->verificarEstado('Observada') ||
        $this->verificarEstado('Subsanada'); 


    }
    
    
    public function getFechaRevision(){
        if($this->fechaHoraRevisado == null )
        {
            return "---";
        }
        else{
            $stringFecha =$this->fechaHoraRevisado; 
            $stringFecha =   str_replace('-','/',$stringFecha);
            return $stringFecha;
        }

    }

    //ENTRA formato MySQL 2020-12-03 
    //  
    public function getFechaHoraEmision(){
         
        $stringFecha =$this->fechaHoraEmision; 
        
        $nuevaFechaHora=substr($stringFecha,8,2).'/'.substr($stringFecha,5,2).'/'.substr($stringFecha,0,4).' '.substr($stringFecha,11,8);
        
            return $nuevaFechaHora;

    }

    public function getNombreSolicitante(){
        $emp = Empleado::findOrFail($this->codEmpleadoSolicitante);
        return $emp->nombres.' '.$emp->apellidos;
    }

    public function getEmpleadoSolicitante(){
        return Empleado::findOrFail($this->codEmpleadoSolicitante);

    }

    public function getRendicion(){

        
        $rend = (RendicionGastos::where('codSolicitud','=',$this->codSolicitud)->get()) [0];
        return $rend;
    
    
    }

    public function getNombreMoneda(){
        $moneda = Moneda::findOrFail($this->codMoneda);
        return $moneda->nombre;
    }

    public function getMoneda(){
        $moneda = Moneda::findOrFail($this->codMoneda);
        return $moneda;
    }

    //retorna el objeto empleado del que lo revisó (su director / gerente)
    public function getEvaluador(){
        
        if($this->codEmpleadoEvaluador==null)
            return "";
        $e = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $e;
    }



    //si está en esos estados retorna la obs, sino retorna ""
    public function getObservacionONull(){
        if($this->verificarEstado('Observada') || $this->verificarEstado('Subsanada') )
            return ": ".$this->observacion;
        
        return "";
    }


    public function getMensajeEstado(){
        $mensaje = '';
        switch($this->codEstadoSolicitud){
            case $this::getCodEstado('Creada'): 
                $mensaje = 'La solicitud está a espera de ser aprobada por el responsable del proyecto.';
                break;
            case $this::getCodEstado('Aprobada'):
                $mensaje = 'La solicitud está a espera de ser abonada.';
                break;
            case $this::getCodEstado('Abonada'):
                $mensaje = 'La solicitud está a espera de ser contabilizada.';
                break;
                                
            case $this::getCodEstado('Contabilizada'):
                $mensaje = 'El flujo de la solicitud ha finalizado.';
                break;
            case $this::getCodEstado('Observada'):
                $mensaje ='La solicitud tiene algún error y fue observada.';
                break;
            case $this::getCodEstado('Subsanada'):
                $mensaje ='La observación de la solicitud ya fue corregida por el empleado.';
                break;
            case $this::getCodEstado('Rechazada'):
                $mensaje ='La solicitud fue rechazada por algún responsable, el flujo ha terminado.';
                break;
            case $this::getCodEstado('Cancelada'):
                $mensaje ='La solicitud fue cancelada por el mismo empleado que la realizó.';
                break;
        }
        return $mensaje;


    }
    
    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoSolicitud){
            case $this::getCodEstado('Creada'): //CREADO
                $color = 'rgb(255,193,7)';
                break;
            case $this::getCodEstado('Aprobada'): //aprobado
                $color = 'rgb(0,154,191)';
                break;
            case $this::getCodEstado('Abonada'): //abonado
                $color = 'rgb(243,141,57)';
                break;
            case $this::getCodEstado('Contabilizada'): //rendida
                $color ='rgb(40,167,69)';
                break;
            case $this::getCodEstado('Observada'): //observada
                $color = 'rgb(217,217,217)';
                break;
            case $this::getCodEstado('Cancelada'): //rechazada
                    $color = 'rgb(149,51,203)';
                    break;
            
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoSolicitud){
            case $this::getCodEstado('Creada'): //creada
                $color = 'black';
                break;
            case $this::getCodEstado('Aprobada')://aprobada
                $color = 'white';
                break;
            case $this::getCodEstado('Abonada'): //abonada
                $color = 'white';
                break;
            case $this::getCodEstado('Contabilizada'): //rendida
                $color = 'white';
                break;
            case $this::getCodEstado('Observada')://observada
                $color = 'black';
                break;
            case $this::getCodEstado('Cancelada')://rechazada
                    $color = 'white';
                    break;
            
        }
        return $color;
    }
    public function getNombreEvaluador(){
        if($this->codEmpleadoEvaluador == null)
            return "";
        
        $ev = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $ev->getNombreCompleto();
    }


    
    public static function filtrarPorEmpleadoSolicitante($coleccion, $codEmpleado ){
        $listaNueva = new Collection();
        foreach ($coleccion as $item) {
            if($item->codEmpleadoSolicitante == $codEmpleado)
                $listaNueva->push($item);
        }
        return $listaNueva;
    }

    //ingresa una coleccion y  el codEstadoSolicitud y retorna otra coleccion  con los elementos de esa coleccion que están en ese estado
    public static function separarDeColeccion($coleccion, $codEstadoSolicitud){
        $listaNueva = new Collection();
        foreach ($coleccion as $item) {
            if($item->codEstadoSolicitud == $codEstadoSolicitud)
                $listaNueva->push($item);
        }
        return $listaNueva;
    }


    // Observadas->subsanadas-> Creadas -> Aprobadas ->abonadas-> Contabilizadas -> canceladas->rechazadas
    public static function ordenarParaEmpleado($coleccion){
        
        $observadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Observada'));
        $subsanada = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Subsanada')); 
        $creadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Creada')); 
        $aprobadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Aprobada')); 

        $abonadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Abonada')); 
        $contabilizadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Contabilizada')); 
        $canceladas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Cancelada')); 
        $rechazadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Rechazada')); 

        $listaOrdenada = new Collection();
        $listaOrdenada= $listaOrdenada->concat($observadas);
        $listaOrdenada= $listaOrdenada->concat($subsanada);
        $listaOrdenada= $listaOrdenada->concat($creadas);
        $listaOrdenada= $listaOrdenada->concat($aprobadas);

        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        $listaOrdenada= $listaOrdenada->concat($canceladas);
        $listaOrdenada= $listaOrdenada->concat($rechazadas);
        

        return $listaOrdenada;

    }


    //Creada->Subsanada->Aprobadas->Abonadas->Contabilizada
    public static function ordenarParaGerente($coleccion){
        
        
        $creadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Creada')); 
        $subsanada = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Subsanada')); 
        $observadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Observada')); 
        
        $aprobadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Aprobada')); 

        $abonadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Abonada')); 
        $contabilizadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Contabilizada')); 
        
        $listaOrdenada = new Collection();

        $listaOrdenada= $listaOrdenada->concat($creadas);
        $listaOrdenada= $listaOrdenada->concat($subsanada);
        $listaOrdenada= $listaOrdenada->concat($observadas);
        
        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);

        return $listaOrdenada;

    }

    //Aprobadas->Abonadas->Contabilizadas
    public static function ordenarParaAdministrador($coleccion){
        
        
      
        $aprobadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Aprobada')); 
        $abonadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Abonada')); 
        $contabilizadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Contabilizada')); 
        
        $listaOrdenada = new Collection();

        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);

        return $listaOrdenada;

    }

    //Aprobadas->Abonadas->Contabilizadas
    public static function ordenarParaContador($coleccion){
        $abonadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Abonada')); 
        $contabilizadas = SolicitudFondos::separarDeColeccion($coleccion,SolicitudFondos::getCodEstado('Contabilizada')); 
        
        $listaOrdenada = new Collection();

        $listaOrdenada= $listaOrdenada->concat($abonadas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);

        return $listaOrdenada;

    }




    /**ESCRIBIR NUMEROSSSSS */
    function escribirTotalSolicitado(){
        $n = $this->totalSolicitado;
        $arr=explode('.', $n);

        if(sizeof($arr)==1){
            $stringDecimal='00';
        }else if(strlen($arr[1])==1){
            $stringDecimal=$arr[1].'0';
        }else{
            $stringDecimal=$arr[1];
        }

        return $this->convertir($n).' Con '.$stringDecimal.'/100';
        //return $this->convertir($this->totalSolicitado);
    }

    function basico($numero) {
        $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
        'nueve','diez', 'once','doce','trece','catorce','quince','diez y seis','diez y siete','diez y ocho','diez y nueve',
        'veinte','veintiuno','veintidos','veintitres', 'veinticuatro','veinticinco',
        'veintiséis','veintisiete','veintiocho','veintinueve');
        return $valor[$numero - 1];
    }
        
    function decenas($n) {
        $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
        70=>'setenta',80=>'ochenta',90=>'noventa');
        if( $n <= 29) return $this->basico($n);
        $x = $n % 10;
        if ( $x == 0 ) {
            return $decenas[$n];
        } else 
            return $decenas[$n - $x].' y '. $this->basico($x);
    }
        
    function centenas($n) {
        $cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
        400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
        700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
        if( $n >= 100) {
            if ( $n % 100 == 0 ) {
                return $cientos[$n];
            } else {
                $u = (int) substr($n,0,1);
                $d = (int) substr($n,1,2);
                return (($u == 1)?'ciento':$cientos[$u*100]).' '.$this->decenas($d);
            }
        } else 
            return $this->decenas($n);
    }
        
    function miles($n) {
        if($n > 999) {
            if( $n == 1000) {return 'mil';}
            else {
                $l = strlen($n);
                $c = (int)substr($n,0,$l-3);
                $x = (int)substr($n,-3);
                if($c == 1) {$cadena = 'mil '.$this->centenas($x);}
                else if($x != 0) {$cadena = $this->centenas($c).' mil '.$this->centenas($x);}
                else $cadena = $this->centenas($c). ' mil';
                return $cadena;
            }
        } else 
            return $this->centenas($n);
    }
        
    function millones($n) {
        if($n == 1000000) {return 'un millón';}
        else {
            $l = strlen($n);
            $c = (int)substr($n,0,$l-6);
            $x = (int)substr($n,-6);
            if($c == 1) {
                $cadena = ' millón ';
            } else {
                $cadena = ' millones ';
            }
            return $this->miles($c).$cadena.(($x > 0)?$this->miles($x):'');
        }
    }
    function convertir($n) {
        $sinMayusculas='';
        switch (true) {
            case ( $n >= 1 && $n <= 29) : 
                $sinMayusculas=$this->basico($n); break;
            case ( $n >= 30 && $n < 100) : 
                $sinMayusculas=$this->decenas($n); break;
            case ( $n >= 100 && $n < 1000) : 
                $sinMayusculas=$this->centenas($n); break;
            case ($n >= 1000 && $n <= 999999): 
                $sinMayusculas=$this->miles($n); break;
            case ($n >= 1000000): 
                $sinMayusculas=$this->millones($n); break;
        }
        return ucfirst($sinMayusculas);
    }

}
