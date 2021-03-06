<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\User;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $primaryKey ="idEmpleado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['idUsuario','nombres','apellidos','activo','codigoCedepas','dni','codPuesto','fechaRegistro','fechaDeBaja','codSede'];


    public function getEmpresasDelEmpleado(){
        //aqui haremos la union de empresas
        $relaciones = EmpresaUsuario::where('idEmpleado','=',$this->idEmpleado)
        ->get();
        //aqui ya tenemos la lista de empresas de ese usuario, pero solo con sus ids
        $listaEmpresas = new Collection();
        foreach($relaciones as $itemEmpresa){
            $empresa = Empresa::findOrFail($itemEmpresa->idEmpresa);
            if($empresa->estadoAct=='1')
            $listaEmpresas->push($empresa);
        }
        

        return $listaEmpresas;
    }


    public function getSolicitudesPorRendir(){
        $vector = [SolicitudFondos::getCodEstado('Abonada'),SolicitudFondos::getCodEstado('Contabilizada')];

        return SolicitudFondos::whereIn('codEstadoSolicitud',$vector)
        ->where('idEmpleadoSolicitante','=',$this->idEmpleado)
        ->where('estaRendida','=',0)
        ->get();


    }

    
    public function getSolicitudesObservadas(){
        return SolicitudFondos::
            where('codEstadoSolicitud','=',SolicitudFondos::getCodEstado('Observada'))
            ->where('idEmpleadoSolicitante','=',$this->idEmpleado)
            ->get();


    }


    public function getReposicionesObservadas(){

        return ReposicionGastos::where('idEmpleadoSolicitante','=',$this->idEmpleado)
            ->where('codEstadoReposicion','=',ReposicionGastos::getCodEstado('Observada'))
            ->get();


    }
    public function getRequerimientosObservados(){

        return RequerimientoBS::where('idEmpleadoSolicitante','=',$this->idEmpleado)
            ->where('codEstadoRequerimiento','=',RequerimientoBS::getCodEstado('Observada'))
            ->get();


    }
    public function getRendicionesObservadas(){

        return RendicionGastos::where('idEmpleadoSolicitante','=',$this->idEmpleado)
            ->where('codEstadoRendicion','=',RendicionGastos::getCodEstado('Observada'))
            ->get();


    }


    public function getNombrePuesto(){
        $cad = $this->getPuestoActual()->nombre;
        if($cad == 'Empleado')
            $cad = "Colaborador";

        return $cad;

    }




    //le pasamos la id del usuario y te retorna el codigo cedepas del empleado
    public function getNombrePorUser( $idAuth){
        $lista = Empleado::where('idUsuario','=',$idAuth)->get();
        return $lista[0]->nombres;

    } 

    public function esGerente(){
        $puesto = Puesto::findOrFail($this->codPuesto);
        if($puesto->nombre=='Gerente')//si es gerente
            return true;

        return false;

    }

    public function esContador(){
        $puesto = Puesto::findOrFail($this->codPuesto);
        if($puesto->nombre=='Contador')//si es gerente
            return true;

        return false;

    }

    public function esAdminSistema(){
        $usuario = User::findOrFail($this->idUsuario);
        return $usuario->isAdmin=='1';

    }
    
    /* REFACTORIZAR ESTO PARA LA NUEVA CONFIGURACION DEL A BASE DE DATOOOOOOOOOOOOOOOOOOOOOOOOOS */
    //para modulo ProvisionFondos. 
    public function esJefeAdmin(){
        $puesto = Puesto::findOrFail($this->codPuesto);
        if($puesto->nombre=='Administrador')
            return true;
        
        return false;
        
    }
    public function getPuestoActual(){
        return Puesto::findOrFail($this->codPuesto);

    }



    public static function getListaGerentesActivos(){
        $lista = Empleado::
            where('codPuesto','=',Puesto::getCodigo('Gerente'))
            ->where('activo','=','1')->get();
        return $lista;

    }

    public static function getListaContadoresActivos(){
        $lista = Empleado::
            where('codPuesto','=',Puesto::getCodigo('Contador'))
            ->where('activo','=','1')->get();
        return $lista;

    }

    //solo se aplica a los gerentes, retorna lista de proyectos que este gerente lidera
    public function getListaProyectos(){
        $proy = Proyecto::where('idEmpleadoDirector','=',$this->idEmpleado)->get();
        //retornamos el Collection
        return $proy;
    }

    // solo para gerente
    public function getListaSolicitudesDeGerente(){
        
        $listaSolicitudesFondos = $this->getListaSolicitudesDeGerente2()->get();
        return $listaSolicitudesFondos;

    }

    public function getListaSolicitudesDeGerente2(){
        //Construimos primero la busqueda de todos los proyectos que tenga este gerente
        $listaProyectos = $this->getListaProyectos();
        $vecProy=[];
        foreach ($listaProyectos as $itemProyecto ) {
           array_push($vecProy,$itemProyecto->codProyecto );
        }
    
        $listaSolicitudesFondos = SolicitudFondos::whereIn('codProyecto',$vecProy)
        ->orderBy('codEstadoSolicitud');

        return $listaSolicitudesFondos;

    }

    //solo para gerente
    public function getListaRendicionesGerente(){

        $listaSolicitudes = $this->getListaSolicitudesDeGerente();
        //ahora agarramos de cada solicitud, su rendicion (si la tiene)
        $listaRendiciones= new Collection();
        for ($i=0; $i < count($listaSolicitudes); $i++) { //recorremos cada solicitud
            $itemSol = $listaSolicitudes[$i];
            if(!is_null($itemSol->codSolicitud)){ 
                $itemRend = RendicionGastos::where('codSolicitud','=',$itemSol->codSolicitud)->first();
                if(!is_null($itemRend))
                    $listaRendiciones->push($itemRend);
            }
            
        }
        return $listaRendiciones;


    }

    

    public static function getEmpleadoLogeado(){
        $idUsuario = Auth::id();         
        $empleados = Empleado::where('idUsuario','=',$idUsuario)->get();
        if(is_null(Auth::id())){
            return false;
        }
        if(count($empleados)<0) //si no encontr?? el empleado de este user 
        {

            Debug::mensajeError('Empleado','    getEmpleadoLogeado() ');
           
            return false;
        }
        return $empleados[0]; 
    }

    public function obtenerRol($idEmpresa){

        $empresaUsuario = EmpresaUsuario::
            where('idEmpleado','=',$this->idEmpleado)
            ->where('idEmpresa','=',$idEmpresa)
            ->get()[0];
        return Rol::findOrFail($empresaUsuario->idRol);

    }

    public static function verificarPermiso($permiso,$idEmpresa){
        
        $rol = Empleado::getEmpleadoLogeado()->obtenerRol($idEmpresa);
        return $rol->verificarPermiso($permiso);


    }

    public static function verificarAdminSistema(){
        return Empleado::getEmpleadoLogeado()->esAdminSistema();
    }
    
    public function getUsuario(){
        
        return User::findOrFail($this->idUsuario);
        
    }

    public function usuario(){

        try{
        $usuario = User::findOrFail($this->idUsuario);
        
        }catch(Throwable $th){
            Debug::mensajeError('MODELO EMPLEADO', $th);
            
            return "usuario no encontrado.";


        }
        
        return $usuario;
        
    }

    
    public function getNombreCompleto(){
        return $this->nombres.' '.$this->apellidos;

    }

    public static function getEmpleadosActivos(){ //FALTA METER EN PROYECTO EL int ACTIVO
        return Empleado::where('activo','=','1')->get();
    }

    
   
    


}
