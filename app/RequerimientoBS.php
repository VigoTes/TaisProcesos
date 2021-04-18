<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
class RequerimientoBS extends Model
{
    protected $table = "requerimiento_bs";
    protected $primaryKey ="codRequerimiento";

    public $timestamps = false;  //para que no trabaje con los campos fecha 
    //const raizArchivoEmp = "ReqBS-Emp-";
    const RaizCodigoCedepas = "REQ";
    const raizArchivo = "REQ-";


    // le indicamos los campos de la tabla 
    protected $fillable = ['codigoCedepas','fechaHoraEmision','fechaHoraRevision','fechaHoraAtendido','fechaHoraConta',
    'idEmpleadoSolicitante','idEmpleadoEvaluador','idEmpleadoAdministrador','idEmpleadoContador',
    'justificacion','codEstadoRequerimiento','cantArchivosEmp','terminacionesArchivosEmp','cantArchivosAdmin','terminacionesArchivosAdmin','codProyecto','observacion'];

    //el cuarto archivo del empleado del requerimiento 124
    // REQ-000124-Emp-04.jpg  
    public static function getFormatoNombreArchivoEmp($codRequerimientoBS,$i){
        return  RequerimientoBS::raizArchivo.
                RequerimientoBS::rellernarCerosIzq($codRequerimientoBS,6).
                '-Emp-'.
                RequerimientoBS::rellernarCerosIzq($i,2).
                '.marac';

    }

    //la primera es la 1 OJO
    public function getNombreArchivoEmpNro($index){
        $vector = explode('/',$this->nombresArchivosEmp);
        return $vector[$index-1];

    }
    //la primera es la 1 OJO
    public function getNombreArchivoAdmNro($index){
        $vector = explode('/',$this->nombresArchivosAdmin);
        return $vector[$index-1];

    }
    
    
    //el quinto archivo del admin del requerimiento 122
    // REQ-000122-Adm-05.png  
    public static function getFormatoNombreArchivoAdm($codRequerimientoBS,$i){
        return  RequerimientoBS::raizArchivo.
                RequerimientoBS::rellernarCerosIzq($codRequerimientoBS,6).
                '-Adm-'.
                RequerimientoBS::rellernarCerosIzq($i,2).
                '.marac';

    }


    public function borrarArchivosEmp(){ //borra todos los archivos que sean de esa rendicion
        
        $vectorTerminaciones = explode('/',$this->terminacionesArchivosEmp);
        
        for ($i=1; $i <=  $this->cantArchivos; $i++) { 
            $nombre = RequerimientoBS::getFormatoNombreArchivoEmp($this->codRequerimiento,$i,$vectorTerminaciones[$i]);
            Storage::disk('requerimientos')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);

        }

    }


    public function getPDF(){
        $listaItems = DetalleRequerimientoBS::where('codRequerimiento','=',$this->codRequerimiento)->get();
        $pdf = \PDF::loadview('RequerimientoBS.PdfRBS',
            array('requerimiento'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');
        
        return $pdf;
    }
    

    //si está en esos estados retorna la obs, sino retorna ""
    public function getObservacionONull(){
        if($this->verificarEstado('Observada') || $this->verificarEstado('Subsanada') )
            return ": ".$this->observacion;
        
        return "";
    }

    public function getJustificacionAbreviada(){
        // Si la longitud es mayor que el límite...
        $limiteCaracteres = 20;
        $cadena = $this->justificacion;
        if(strlen($cadena) > $limiteCaracteres){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limiteCaracteres) . '...';
        }

        // Si no, entonces devuelve la cadena normal
        return $cadena;



    }

    public function getObservacionMinimizada(){
        // Si la longitud es mayor que el límite...
        $limiteCaracteres = 20;
        $cadena = $this->observacion;
        if(strlen($cadena) > $limiteCaracteres){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limiteCaracteres) . '...';
        }
        
        // Si no, entonces devuelve la cadena normal
        return $cadena;

    }

    public function borrarArchivosAdm(){ //borra todos los archivos que sean de esa rendicion
        
        $vectorTerminaciones = explode('/',$this->terminacionesArchivosAdmin);
        
        for ($i=1; $i <=  $this->cantArchivos; $i++) { 
            $nombre = RequerimientoBS::getFormatoNombreArchivoAdm($this->codRequerimiento,$i,$vectorTerminaciones[$i]);
            Storage::disk('requerimientos')->delete($nombre);
            Debug::mensajeSimple('Se acaba de borrar el archivo:'.$nombre);

        }

    }


    //ingresa una coleccion y  el codEstadoSolicitud y retorna otra coleccion  con los elementos de esa coleccion que están en ese estado
    public static function separarDeColeccion($coleccion, $codEstadoRequerimiento){
        $listaNueva = new Collection();
        foreach ($coleccion as $item) {
            if($item->codEstadoRequerimiento == $codEstadoRequerimiento)
                $listaNueva->push($item);
        }
        return $listaNueva;
    }


    
    public static function ordenarParaEmpleado($coleccion){
        $observadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Observada'));
        $subsanada = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Subsanada')); 
        $creadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Creada')); 
        $aprobadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Aprobada')); 

        $atendidas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Atendida')); 
        $contabilizadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Contabilizada')); 
        $canceladas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Cancelada')); 
        $rechazadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Rechazada')); 

        $listaOrdenada = new Collection();
        $listaOrdenada= $listaOrdenada->concat($observadas);
        $listaOrdenada= $listaOrdenada->concat($subsanada);
        $listaOrdenada= $listaOrdenada->concat($creadas);
        $listaOrdenada= $listaOrdenada->concat($aprobadas);

        $listaOrdenada= $listaOrdenada->concat($atendidas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        $listaOrdenada= $listaOrdenada->concat($canceladas);
        $listaOrdenada= $listaOrdenada->concat($rechazadas);
        
        return $listaOrdenada;

    }

    public static function ordenarParaAdministrador($coleccion){
        
        
      
        $aprobadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Aprobada')); 
        $atendidas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Atendida')); 
        $contabilizadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Contabilizada')); 
        
        $listaOrdenada = new Collection();

        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        $listaOrdenada= $listaOrdenada->concat($atendidas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);

        return $listaOrdenada;

    }
    //Creadas -> Subsanadas -> Aprobadas->abonadas -> Contabilizadas
    public static function ordenarParaContador($coleccion){
                
        //$observadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Observada'));
        //$subsanada = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Subsanada')); 
        //$creadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Creada')); 
        //$aprobadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Aprobada')); 
        $atendidas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Atendida')); 

        $contabilizadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Contabilizada')); 
        //$canceladas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Cancelada')); 
        //$rechazadas = ReposicionGastos::separarDeColeccion($coleccion,ReposicionGastos::getCodEstado('Rechazada')); 


        $listaOrdenada = new Collection();
        
        $listaOrdenada= $listaOrdenada->concat($atendidas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        
        return $listaOrdenada;

    }
    //Creadas -> Subsanadas -> Aprobadas->abonadas -> Contabilizadas
    public static function ordenarParaGerente($coleccion){
            
        $observadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Observada'));
        $subsanada = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Subsanada')); 
        $creadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Creada')); 
        $aprobadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Aprobada')); 
        $atendidas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Atendida')); 

        $contabilizadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Contabilizada')); 
        $canceladas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Cancelada')); 
        $rechazadas = RequerimientoBS::separarDeColeccion($coleccion,RequerimientoBS::getCodEstado('Rechazada')); 


        $listaOrdenada = new Collection();
        $listaOrdenada= $listaOrdenada->concat($subsanada);
        $listaOrdenada= $listaOrdenada->concat($creadas);
        $listaOrdenada= $listaOrdenada->concat($observadas);
        $listaOrdenada= $listaOrdenada->concat($aprobadas);
        
        $listaOrdenada= $listaOrdenada->concat($atendidas);
        $listaOrdenada= $listaOrdenada->concat($contabilizadas);
        
        return $listaOrdenada;

    }




    /** FORMATO PARA FECHAS*/
    public function formatoFechaHoraEmision(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraEmision));
        return $fecha;
    }
    public function formatoFechaHoraRevisionGerente(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraRevisionGerente));
        return $fecha;
    }
    public function formatoFechaHoraRevisionAdmin(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraRevisionAdmin));
        return $fecha;
    }
    public function formatoFechaHoraRevisionConta(){
        $fecha=date('d/m/Y H:i:s', strtotime($this->fechaHoraRevisionConta));
        return $fecha;
    }



    public static function calcularCodigoCedepas($objNumeracion){
        return  RequerimientoBS::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                RequerimientoBS::rellernarCerosIzq($objNumeracion->numeroLibreActual,6);
    }
    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
    }


    public static function getCodEstado($nombreEstado){
        $lista = EstadoRequerimientoBS::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoRequerimiento;

    }
    public function getNombreEstado(){ 
        $estado = EstadoRequerimientoBS::findOrFail($this->codEstadoRequerimiento);
        if($estado->nombre=="Creada")
            return "Por Aprobar";
        return $estado->nombre;
    }
    public function getMensajeEstado(){
        $mensaje = '';
        switch($this->codEstadoRequerimiento){
            case $this::getCodEstado('Creada'): 
                $mensaje = 'La reposición está a espera de ser aprobada por el responsable del proyecto.';
                break;
            case $this::getCodEstado('Aprobada'):
                $mensaje = 'La reposición está a espera de ser atendida.';
                break;
            case $this::getCodEstado('Atendida'):
                $mensaje = 'La reposición está a espera de ser contabilizada.';
                break;
                                
            case $this::getCodEstado('Contabilizada'):
                $mensaje = 'El flujo de la reposición ha finalizado.';
                break;
            case $this::getCodEstado('Observada'):
                $mensaje ='La reposición tiene algún error y fue observada.';
                break;
            case $this::getCodEstado('Subsanada'):
                $mensaje ='La observación de la reposición ya fue corregida por el empleado.';
                break;
            case $this::getCodEstado('Rechazada'):
                $mensaje ='La reposición fue rechazada por algún responsable, el flujo ha terminado.';
                break;
            case $this::getCodEstado('Cancelada'):
                $mensaje ='La reposición fue cancelada por el mismo empleado que la realizó.';
                break;
        }
        return $mensaje;


    }
    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoRequerimiento){
            case 1: //creada
                $color = 'rgb(255,193,7)';
                break;
            case 2: //aprobada
                $color = 'rgb(0,154,191)';
                break;
            case 3: //atendida
                $color = 'rgb(243,141,57)';
                break;
            case 4: //contabilizada
                $color ='rgb(40,167,69)';
                break;
            case 5:
                $color ='rgb(255,201,7)';
                break;
            case 6:
                $color ='rgb(27,183,152)';
                break;
            case 7: //rechazada
                $color ='rgb(192,0,0)';
                break;
            case 8: //cancelada
                $color ='rgb(149,51,203)';
                break;
        }
        return $color;
    }
    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoRequerimiento){
            case 1: 
                $color = 'black';
                break;
            case 2:
                $color = 'white';
                break;
            case 3:
                $color = 'white';
                break;
            case 4:
                $color = 'white';
                break;
            case 5:
                $color ='black';
                break;
            case 6:
                $color ='white';
                break;
            case 7:
                $color ='white';
                break;
            case 8:
                $color ='white';
                break;
        }
        return $color;
    }



    public function detalles(){
        return DetalleRequerimientoBS::where('codRequerimiento','=',$this->codRequerimiento)->get();
    }
    public function getEmpleadoSolicitante(){
        $empleado=Empleado::find($this->idEmpleadoSolicitante);
        return $empleado;
    }
    public function getEmpleadoEvaluador(){
        $empleado=Empleado::find($this->idEmpleadoEvaluador);
        return $empleado;
    }


    public function evaluador(){
        $empleado=Empleado::find($this->idEmpleadoEvaluador);
        return $empleado;
    }
    public function getProyecto(){
        $proyecto=Proyecto::find($this->codProyecto);
        return $proyecto;
    }



    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){
        $lista = EstadoRequerimientoBS::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        
        $estado = $lista[0];
        
        if($estado->codEstadoRequerimiento == $this->codEstadoRequerimiento)
            return true;
        
        return false;
        
    }


    public function listaParaEditar(){

        return $this->verificarEstado('Creada') ||
        $this->verificarEstado('Subsanada') || 
        $this->verificarEstado('Observada');

    }

    public function listaParaAprobar(){
        return $this->verificarEstado('Creada') ||
        $this->verificarEstado('Subsanada'); 

    }
    public function listaParaActualizar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Observada') || 
        $this->verificarEstado('Subsanada'); 

    }
    public function listaParaObservar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Aprobada'); 

    }
    public function listaParaRechazar(){

        return $this->listaParaObservar();
    }
    public function listaParaAtender(){
        return $this->verificarEstado('Aprobada');

    }
    public function listaParaContabilizar(){
        return $this->verificarEstado('Atendida');

    }
    public function listaParaCancelar(){
        return $this->verificarEstado('Creada') || 
        $this->verificarEstado('Aprobada');

    }




    
}
