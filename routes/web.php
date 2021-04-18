<?php

use App\DetalleSolicitudFondos;
use App\SolicitudFondos;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;



Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');
Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');


Route::get('/', 'UserController@home')->name('user.home');


Route::get('/encriptarContraseñas', function(){

    return redirect()->route('error')->with('datos','Parece que te has perdido...');

    //$contraseñas = "40556946;46636006;47541289;26682689;41943357;43485279;42090409;44847934;26682687;17914644;70355561;70585629;44685699;19327774;40360154;45740336;15738099;19330869;74240802;70386230;42927000;42305800;15766143;45540460;45372425;03120627;45576187;17877014;02897932;44155217;18175358;40068481;18126610;43162714;40392458;40242073;40994213;42122048;44896824;46352412;43953715;99999999;99999999";
    $contraseñas = "maracsoft2021";
    $vectorContraseñas = explode(';',$contraseñas);
    
    $vectorContraseñasEncriptadas = [];
    foreach ($vectorContraseñas as $item){
        array_push($vectorContraseñasEncriptadas,Hash::make($item));   
    }

    $listaEncriptadasSeparadasComas= implode(';',$vectorContraseñasEncriptadas);


    return $listaEncriptadasSeparadasComas;

});


Route::get('/Error',function(){
    
    $msj = session('datos');
    $datos='';
    if($msj!='')
        $datos = $msj;

    session(['datos' => '']);
    return view('ERROR',compact('datos'));

})->name('error');



/* RUTAS SERVICIOS */
Route::get('/listarDetallesDeSolicitud/{id}','SolicitudFondosController@listarDetalles');
Route::get('/listarDetallesDeRendicion/{id}','RendicionGastosController@listarDetalles');
Route::get('/listarDetallesDeReposicion/{id}','ReposicionGastosController@listarDetalles');
Route::get('/listarDetallesDeRequerimiento/{id}','RequerimientoBSController@listarDetalles');

Route::get('/solicitudFondos/getNumeracionActual/','SolicitudFondosController@getNumeracionLibre');
Route::get('/rendicionGastos/getNumeracionActual/','RendicionGastosController@getNumeracionLibre');
Route::get('/reposicionGastos/getNumeracionActual/','ReposicionGastosController@getNumeracionLibre');
Route::get('/obtenerCodigoPresupuestalDeProyecto/{id}','ProyectoController@getCodigoPresupuestal');

Route::get('/listarProvinciasDeDepartamento/{id}','ProyectoController@listarProvinciasDeDepartamento');
Route::get('/listarDistritosDeProvincia/{id}','ProyectoController@listarDistritosDeProvincia');

Route::get('/listarObjetivosDePEI/{id}','PlanEstrategicoInstitucionalController@listarObjetivos');


/* ESTE MIDDLEWARE VALIDA SI ES QUE ESTÁS LOGEADO, SI NO, TE MANDA AL LOGIN */
Route::group(['middleware'=>"ValidarSesion"],function()
{

    
    
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ----------------------------------------------        MODULO SOLICITUD DE FONDOS ---------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */



    /* AFUERA DEL MIDDLEWARE(no requieren validacion o hacerlas sería demasiado complejo xd) */
    Route::get('/SolicitudFondos/MASTERINDEX','SolicitudFondosController@listarSolicitudes')
        ->name('solicitudFondos.ListarSolicitudes');


    Route::get('/SolicitudFondos/Observar/{value}','SolicitudFondosController@observar')
        ->name('solicitudFondos.observar');
    Route::get('/SolicitudFondos/Rechazar/{id}','SolicitudFondosController@rechazar')
        ->name('solicitudFondos.rechazar');
    
    Route::get('/SolicitudFondos/descargar/{id}','SolicitudFondosController@descargarPDF')
        ->name('solicitudFondos.descargarPDF');
    Route::get('/SolicitudFondos/verPDF/{id}','SolicitudFondosController@verPDF')
        ->name('solicitudFondos.verPDF');

    /* EMPLEADO Cualquier user logeado puede hacer, no es necesario validar*/
    Route::get('/SolicitudFondos/Empleado/Crear','SolicitudFondosController@create')
        ->name('SolicitudFondos.Empleado.Create');

    Route::get('/SolicitudFondos/Empleado/editar/{id}','SolicitudFondosController@edit')
        ->name('SolicitudFondos.Empleado.Edit');


    Route::get('/SolicitudFondos/Empleado/delete/{id}','SolicitudFondosController@cancelar')
        ->name('SolicitudFondos.Empleado.cancelar');

    Route::get('/SolicitudFondos/Empleado/listar/','SolicitudFondosController@listarSolicitudesDeEmpleado')
        ->name('SolicitudFondos.Empleado.Listar');

    Route::get('/SolicitudFondos/{id}/Empleado/ver/','SolicitudFondosController@ver')
        ->name('SolicitudFondos.Empleado.Ver');
        
    Route::post('/SolicitudFondos/Empleado/guardar', 'SolicitudFondosController@store')
        ->name('SolicitudFondos.Empleado.Guardar');
    
    
    Route::get('/SolicitudFondos/Empleado/Rendir/{id}','SolicitudFondosController@rendir')
        ->name('SolicitudFondos.Empleado.Rendir');
    
    Route::post('/SolicitudFondos/{id}/Empleado/update/','SolicitudFondosController@update')
        ->name('SolicitudFondos.Empleado.update');



    /* GERENTE */


    Route::group(['middleware'=>"ValidarSesionGerente"],function()
    {

        Route::get('/SolicitudFondos/{id}/Gerente/Revisar/','SolicitudFondosController@revisar')
            ->name('SolicitudFondos.Gerente.Revisar');

        Route::get('/SolicitudFondos/Gerente/listar','SolicitudFondosController@listarSolicitudesParaGerente')
            ->name('SolicitudFondos.Gerente.Listar');

        Route::Post('/SolicitudFondos/Gerente/Aprobar/','SolicitudFondosController@aprobar')
            ->name('SolicitudFondos.Gerente.Aprobar');
    

    });

    Route::group(['middleware'=>"ValidarSesionAdministracion"],function(){

        /* ADMINSITRACION */
        Route::get('/SolicitudFondos/Administración/listar','SolicitudFondosController@listarSolicitudesParaJefe')
            ->name('SolicitudFondos.Administracion.Listar');

        Route::get('/SolicitudFondos/{id}/Administracion/vistaAbonar/','SolicitudFondosController@vistaAbonar')
            ->name('SolicitudFondos.Administracion.verAbonar');

        Route::post('/SolicitudFondos/Administracion/Abonar/','SolicitudFondosController@abonar')
            ->name('SolicitudFondos.Administracion.Abonar');

    });

    Route::group(['middleware'=>"ValidarSesionContador"],function()
    {

        /* CONTADOR */

        Route::get('/SolicitudFondos/Contador/listar','SolicitudFondosController@listarSolicitudesParaContador')
            ->name('SolicitudFondos.Contador.Listar');

        Route::get('/SolicitudFondos/{id}/Contador/verContabilizar/','SolicitudFondosController@verContabilizar')
            ->name('SolicitudFondos.Contador.verContabilizar');


        Route::get('/SolicitudFondos/Contador/Contabilizar/{id}','SolicitudFondosController@contabilizar')
            ->name('SolicitudFondos.Contador.Contabilizar');

    });
    
    


      
    




    
    
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* -----------------------------------------------------MODULO RENDICIONES--------- ---------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */
    /* ------------------------------------------------------------------------------------------------------------- */


    Route::post('/reportes/ver', 'RendicionGastosController@reportes')
    ->name('rendicionGastos.reportes');


    Route::get('/reportes/descargar/{str}', 'RendicionGastosController@descargarReportes')
        ->name('rendicionGastos.descargarReportes');


    Route::get('/rendicion/descargarCDP/{cadena}','RendicionGastosController@descargarCDP')
    ->name('rendiciones.descargarCDP');




    Route::get('/RendicionGastos//descargarPDF/{id}','RendicionGastosController@descargarPDF')
    ->name('rendicionGastos.descargarPDF');

    Route::get('/RendicionGastos/verPDF/{id}','RendicionGastosController@verPDF')
    ->name('rendicionGastos.verPDF');


    Route::get('/RendicionGastos/{id}/rechazar','RendicionGastosController@rechazar')
    ->name('RendicionGastos.Gerente.Rechazar');

    Route::get('/rendiciones/observar/{string}','RendicionGastosController@observar')
    ->name('RendicionGastos.Observar');
    /* EMPLEADO */


    
    Route::post('/RendicionGastos/Empleado/guardar', 'RendicionGastosController@store')
    ->name('RendicionGastos.Empleado.Store');

    Route::get('/RendicionGastos/{id}/Empleado/ver/', 'RendicionGastosController@ver')
    ->name('RendicionGastos.Empleado.Ver');


    Route::get('RendicionGastos/{id}/Empleado/editar','RendicionGastosController@editar')
    ->name('RendicionGastos.Empleado.Editar');

    Route::Post('/RendicionGastos/Empleado/update/','RendicionGastosController@update')
    ->name('RendicionGastos.Empleado.Update');
    Route::get('/RendicionGastos/Empleado/Listar/','RendicionGastosController@listarEmpleado')
    ->name('RendicionGastos.Empleado.Listar');
    
    Route::group(['middleware'=>"ValidarSesionGerente"],function()
    {
    
    /* GERENTE */

        Route::get('/RendicionGastos/{id}/Gerente/ver', 'RendicionGastosController@verGerente')
            ->name('RendicionGastos.Gerente.Ver');

        Route::get('/RendicionGastos/{id}/Gerente/revisar','RendicionGastosController@revisar')
            ->name('RendicionGastos.Gerente.Revisar');

        Route::Post('/RendicionGastos/Gerente/aprobar','RendicionGastosController@aprobar')
            ->name('RendicionGastos.Gerente.Aprobar');

        Route::get('/RendicionGastos/Gerente/listar/','RendicionGastosController@listarDelGerente')
            ->name('RendicionGastos.Gerente.Listar');
        
    });
    Route::group(['middleware'=>"ValidarSesionAdministracion"],function()
    {
        /* ADMINISTRACION */

        Route::get('/RendicionGastos/Administracion/listar/','RendicionGastosController@listarJefeAdmin')
            ->name('RendicionGastos.Administracion.Listar');

        Route::get('/RendicionGastos/{id}/Administracion/ver', 'RendicionGastosController@verAdmin')
            ->name('RendicionGastos.Administracion.Ver');

    });

    Route::group(['middleware'=>"ValidarSesionContador"],function()
    {
        /* CONTADOR */

        Route::get('/RendicionGastos/{id}/Contador/verContabilizar/','RendicionGastosController@verContabilizar')
                ->name('RendicionGastos.Contador.verContabilizar');   

        Route::get('/rendicion/contabilizar/{cad}','RendicionGastosController@contabilizar')
            ->name('RendicionGastos.Contador.Contabilizar');   

        Route::get('/RendicionGastos/Contador/listar/','RendicionGastosController@listarContador')
            ->name('RendicionGastos.Contador.Listar');

    });

    //RUTA MAESTAR QUE REDIRIJE A LOS LISTADOS DE RENDICIONES DE LOS ACTORES EMP GER Y J.A
    Route::get('/RendicionGastos/MAESTRA/listar','RendicionGastosController@listarRendiciones')
    ->name('RendicionGastos.ListarRendiciones');


    

  


    /**PUEDE HACER EL EMPLEADO */

    Route::get('/GestiónUsuarios/misDatos','EmpleadoController@verMisDatos')->name('GestionUsuarios.verMisDatos');
    Route::get('/GestiónUsuarios/cambiarContraseña','EmpleadoController@cambiarContraseña')->name('GestionUsuarios.cambiarContraseña');
    
    
    
    Route::post('/GestiónUsuarios/updateContrasena','EmpleadoController@guardarContrasena')->name('GestionUsuarios.updateContrasena');
    Route::post('/GestiónUsuarios/updateDPersonales','EmpleadoController@guardarDPersonales')->name('GestionUsuarios.updateDPersonales');

    /* FUNCIONES PROPIAS DEL ADMINISTRADOR DEL SISTEMA */
    Route::group(['middleware'=>"ValidarSesionAdminSistema"],function()
    {

        

        /* ----------------------------------------------        MODULO GESTIÓN DE USUARIOS ---------------------------- */
        Route::get('/GestiónUsuarios/listar','EmpleadoController@listarEmpleados')->name('GestionUsuarios.Listar');

        Route::get('/GestiónUsuarios/crear','EmpleadoController@crearEmpleado')->name('GestionUsuarios.create');
        Route::post('/GestiónUsuarios/save','EmpleadoController@guardarCrearEmpleado')->name('GestionUsuarios.store');
    
        Route::get('/GestiónUsuarios/{id}/editarUsuario','EmpleadoController@editarUsuario')->name('GestionUsuarios.editUsuario');
        Route::get('/GestiónUsuarios/{id}/editarEmpleado','EmpleadoController@editarEmpleado')->name('GestionUsuarios.editEmpleado');
        Route::post('/GestiónUsuarios/updateUsuario','EmpleadoController@guardarEditarUsuario')->name('GestionUsuarios.updateUsuario');
        Route::post('/GestiónUsuarios/updateEmpleado','EmpleadoController@guardarEditarEmpleado')->name('GestionUsuarios.updateEmpleado');
    
        Route::get('/GestiónUsuarios/{id}/cesar','EmpleadoController@cesarEmpleado')->name('GestionUsuarios.cesar');
    
        
        /* ----------------------------------------------        MODULO PUESTOS           ------------------------------------------ */
        Route::get('/GestiónPuestos/listar','PuestoController@listarPuestos')->name('GestiónPuestos.Listar');
    
        Route::get('/GestiónPuestos/crear','PuestoController@crearPuesto')->name('GestiónPuestos.create');
        Route::post('/GestiónPuestos/save','PuestoController@guardarCrearPuesto')->name('GestiónPuestos.store');
    
        Route::get('/GestiónPuestos/{id}/editar','PuestoController@editarPuesto')->name('GestiónPuestos.edit');
        Route::post('/GestiónPuestos/update','PuestoController@guardarEditarPuesto')->name('GestiónPuestos.update');
    
        Route::get('/GestiónPuestos/{id}/eliminar','PuestoController@eliminarPuesto')->name('GestiónPuestos.delete');



            
        /* ---------------------------------------------- MODULO PROYECTOS -------------------------------------------- */
        Route::get('/GestiónProyectos/listar','ProyectoController@index')->name('GestiónProyectos.Listar');

        Route::get('/GestiónProyectos/crear','ProyectoController@crear')->name('GestiónProyectos.crear');
        Route::post('/GestiónProyectos/store','ProyectoController@store')->name('GestiónProyectos.store');

        Route::get('/GestiónProyectos/{id}/editar','ProyectoController@editar')->name('GestiónProyectos.editar');
        Route::post('/GestiónProyectos/update','ProyectoController@update')->name('GestiónProyectos.update');

        Route::get('/GestiónProyectos/{id}/darDeBaja','ProyectoController@darDeBaja')->name('GestiónProyectos.darDeBaja');


        Route::post('/GestionProyectos/agregarLugarEjecucion/','ProyectoController@agregarLugarEjecucion' )->name('GestionProyectos.agregarLugarEjecucion');
        Route::get('/GestionProyectos/eliminarLugarEjecucion/{id}','ProyectoController@eliminarLugarEjecucion' )->name('GestionProyectos.eliminarLugarEjecucion');
        
        Route::post('/GestionProyectos/agregarPoblacionBeneficiaria/','ProyectoController@agregarPoblacionBeneficiaria' )->name('GestionProyectos.agregarPoblacionBeneficiaria');
        Route::get('/GestionProyectos/eliminarPoblacionBeneficiaria/{id}','ProyectoController@eliminarPoblacionBeneficiaria' )->name('GestionProyectos.eliminarPoblacionBeneficiaria');
        
        Route::post('/GestionProyectos/actualizarPEI/','ProyectoController@actualizarPEI' )->name('GestionProyectos.actualizarPEI');
        Route::post('/GestionProyectos/actualizarPorcentajesObjetivos/','ProyectoController@actualizarPorcentajesObjetivos' )->name('GestionProyectos.actualizarPorcentajesObjetivos');
        
        Route::post('/GestionProyectos/agregarObjetivoEspecifico/','ProyectoController@agregarObjetivoEspecifico' )->name('GestionProyectos.agregarObjetivoEspecifico');
        Route::get('/GestionProyectos/eliminarObjetivoEspecifico/{id}','ProyectoController@eliminarObjetivoEspecifico' )->name('GestionProyectos.eliminarObjetivoEspecifico');
        
        Route::post('/GestionProyectos/agregarIndicador','ProyectoController@agregarIndicador')->name('GestionProyectos.agregarIndicador');
        Route::get('/GestionProyectos/eliminarIndicador/{id}','ProyectoController@eliminarIndicador')->name('GestionProyectos.eliminarIndicador');


        Route::post('/GestionProyectos/agregarResultadoEsperado/','ProyectoController@agregarResultadoEsperado' )->name('GestionProyectos.agregarResultadoEsperado');
        Route::get('/GestionProyectos/eliminarResultadoEsperado/{id}','ProyectoController@eliminarResultadoEsperado' )->name('GestionProyectos.eliminarResultadoEsperado');
        Route::post('/GestionProyectos/agregarIndicadorResultadoEsperado','ProyectoController@agregarIndicadorResultado')->name('GestionProyectos.agregarIndicadorResultado');
        Route::get('/GestionProyectos/eliminarIndicadorResultadoEsperado/{id}','ProyectoController@eliminarIndicadorResultado')->name('GestionProyectos.eliminarIndicadorResultado');

        

        /**GERENTES-CONTADORES */
        Route::get('/GestiónProyectos/{id}/asignarGerente','ProyectoController@actualizarProyectosYGerentesContadores');

        Route::get('/GestiónProyectos/{id}/asignarContador','ProyectoController@listarContadores')->name('GestiónProyectos.ListarContadores');
        Route::post('/GestiónProyectos/asignarContadores/save','ProyectoController@agregarContador')->name('GestiónProyectos.agregarContador');//usa la ruta no el name

        Route::get('/GestiónProyectos/{id}/eliminarContador','ProyectoController@eliminarContador')->name('GestiónProyectos.eliminarContador');



        Route::get('/RellenarProyectoContador','ProyectoController@RellenarProyectoContador')
        ->name('GestionProyectos.setearTodosLosContadoresATodosLosProyectos');
        


        /* ---------------------------------------------- MODULO UNIDAD DE MEDIDA -------------------------------------------- */
        Route::get('/GestiónUnidadMedida/listar','UnidadMedidaController@listarUnidades')->name('GestiónUnidadMedida.listar');

        Route::get('/GestiónUnidadMedida/crear','UnidadMedidaController@crearUnidad')->name('GestiónUnidadMedida.crear');
        Route::post('/GestiónUnidadMedida/store','UnidadMedidaController@store')->name('GestiónUnidadMedida.store');

        Route::get('/GestiónUnidadMedida/{id}/editar','UnidadMedidaController@editarUnidad')->name('GestiónUnidadMedida.editar');
        Route::post('/GestiónUnidadMedida/update','UnidadMedidaController@update')->name('GestiónUnidadMedida.update');

        Route::get('/GestiónUnidadMedida/{id}/eliminar','UnidadMedidaController@delete')->name('GestiónUnidadMedida.eliminar');


        /* CRUD FINANCIERAS */
        Route::get('/Financieras/listar','EntidadFinancieraController@listar')->name('EntidadFinanciera.listar');
        Route::get('/Financieras/crear','EntidadFinancieraController@crear')->name('EntidadFinanciera.crear');
        Route::get('/Financieras/editar/{id}','EntidadFinancieraController@editar')->name('EntidadFinanciera.editar');
        Route::post('/Financieras/actualizar','EntidadFinancieraController@actualizar')->name('EntidadFinanciera.actualizar');
        

        Route::post('/Financieras/guardar','EntidadFinancieraController@guardar')->name('EntidadFinanciera.guardar');
        Route::get('/Financieras/eliminar/{id}','EntidadFinancieraController@eliminar')->name('EntidadFinanciera.eliminar');
        
        /* CRUD TIPO FINANCIAMIENTO */
        Route::get('/TipoFinanciamiento/listar','TipoFinanciamientoController@listar')->name('TipoFinanciamiento.listar');
        Route::get('/TipoFinanciamiento/crear','TipoFinanciamientoController@crear')->name('TipoFinanciamiento.crear');
        Route::get ('/TipoFinanciamiento/editar/{id}','TipoFinanciamientoController@editar')->name('TipoFinanciamiento.editar');
        Route::post('/TipoFinanciamiento/actualizar','TipoFinanciamientoController@actualizar')->name('TipoFinanciamiento.actualizar');
        

        Route::post('/TipoFinanciamiento/guardar','TipoFinanciamientoController@guardar')->name('TipoFinanciamiento.guardar');
        Route::get('/TipoFinanciamiento/eliminar/{id}','TipoFinanciamientoController@eliminar')->name('TipoFinanciamiento.eliminar');
        
        /* CRUD OBJETIVOS ESTRATEGICOS */
        Route::get('/ObjetivoEstrategico/listar','ObjetivoEstrategicoController@listar')->name('ObjetivoEstrategico.listar');
        Route::get('/ObjetivoEstrategico/crear','ObjetivoEstrategicoController@crear')->name('ObjetivoEstrategico.crear');
        Route::get ('/ObjetivoEstrategico/editar/{id}','ObjetivoEstrategicoController@editar')->name('ObjetivoEstrategico.editar');
        Route::post('/ObjetivoEstrategico/actualizar','ObjetivoEstrategicoController@actualizar')->name('ObjetivoEstrategico.actualizar');
        

        Route::post('/ObjetivoEstrategico/guardar','ObjetivoEstrategicoController@guardar')->name('ObjetivoEstrategico.guardar');
        Route::get('/ObjetivoEstrategico/eliminar/{id}','ObjetivoEstrategicoController@eliminar')->name('ObjetivoEstrategico.eliminar');
        
        Route::get('/ObjetivoEstrategico/desactivar/{id}','ObjetivoEstrategicoController@desactivar')->name('ObjetivoEstrategico.desactivar');
        
        /* CRUD PLANES ESTRATEGICOS */
        Route::get('/PlanEstrategico/listar','PlanEstrategicoInstitucionalController@listar')->name('PlanEstrategico.listar');
        
        Route::get('/PlanEstrategico/crear','PlanEstrategicoInstitucionalController@crear')->name('PlanEstrategico.crear');
        Route::get ('/PlanEstrategico/editar/{id}','PlanEstrategicoInstitucionalController@editar')->name('PlanEstrategico.editar');
        Route::get('/PlanEstrategico/desactivar/{id}','PlanEstrategicoInstitucionalController@desactivar')->name('PlanEstrategico.desactivar');
        
        Route::post('/PlanEstrategico/actualizar','PlanEstrategicoInstitucionalController@actualizar')->name('PlanEstrategico.actualizar');
        Route::post('/PlanEstrategico/guardar','PlanEstrategicoInstitucionalController@guardar')->name('PlanEstrategico.guardar');
        

    });










    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* ----------------------------------- MODULO REPOSICIONES ------------------------------ */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    


    
    /**RUTA MAESTRA PARA REPOSICION */
    Route::get('/indexReposicion','ReposicionGastosController@listarReposiciones')
        ->name('ReposicionGastos.Listar');
    /**RUTA MAESTRA PARA DESCARGAR CDP */
    Route::get('/reposicion/descargarCDP/{cadena}','ReposicionGastosController@descargarCDP')
        ->name('ReposicionGastos.descargarCDP');


    
    /**EMPLEADO*/
    Route::get('/ReposicionGastos/Empleado/listar','ReposicionGastosController@listarOfEmpleado')
        ->name('ReposicionGastos.Empleado.Listar');
    Route::get('/ReposicionGastos/Empleado/crear','ReposicionGastosController@create')
        ->name('ReposicionGastos.Empleado.create');
    Route::post('/ReposicionGastos/Empleado/store','ReposicionGastosController@store')
        ->name('ReposicionGastos.Empleado.store');

    Route::post('/ReposicionGastos/Empleado/update','ReposicionGastosController@update')
        ->name('ReposicionGastos.Empleado.update');
    Route::get('/ReposicionGastos/{id}/Empleado/editar','ReposicionGastosController@editar')
        ->name('ReposicionGastos.Empleado.editar');

    Route::get('/ReposicionGastos/{id}/Empleado/view','ReposicionGastosController@view')
        ->name('ReposicionGastos.Empleado.ver');

    Route::group(['middleware'=>"ValidarSesionGerente"],function()
    {
        /**GERENTE*/
        Route::get('/ReposicionGastos/Gerente/listar','ReposicionGastosController@listarOfGerente')
            ->name('ReposicionGastos.Gerente.Listar');
        Route::get('/ReposicionGastos/{id}/Gerente/view','ReposicionGastosController@viewGeren')
            ->name('ReposicionGastos.Gerente.ver');
        Route::Post('/ReposicionGastos/Gerente/Aprobar','ReposicionGastosController@aprobar')
            ->name('ReposicionGastos.Gerente.aprobar');
    });
    Route::group(['middleware'=>"ValidarSesionAdministracion"],function()
    {

        /**ADMINISTRACION*/
        Route::get('/ReposicionGastos/Administracion/listar','ReposicionGastosController@listarOfJefe')
            ->name('ReposicionGastos.Administracion.Listar');
        Route::get('/ReposicionGastos/{id}/Administracion/view','ReposicionGastosController@viewJefe')
            ->name('ReposicionGastos.Administracion.ver');
        Route::get('/ReposicionGastos/{id}/Abonar','ReposicionGastosController@abonar')
            ->name('ReposicionGastos.abonar');

    });
    Route::group(['middleware'=>"ValidarSesionContador"],function()
    {


        Route::get('/ReposicionGastos/{id}/Contabilizar','ReposicionGastosController@contabilizar')
        ->name('ReposicionGastos.contabilizar');//usa la ruta no el name

        /**CONTADOR*/
        Route::get('/ReposicionGastos/Contador/listar','ReposicionGastosController@listarOfConta')
            ->name('ReposicionGastos.Contador.Listar');
        Route::get('/ReposicionGastos/{id}/Contador/view','ReposicionGastosController@viewConta')
            ->name('ReposicionGastos.Contador.ver');


    
    });
    
    Route::get('/ReposicionGastos/{id}/Cancelar','ReposicionGastosController@cancelar')
    ->name('ReposicionGastos.cancelar');
   
    Route::get('/ReposicionGastos/{id}/Rechazar','ReposicionGastosController@rechazar')
        ->name('ReposicionGastos.rechazar');
    Route::get('/ReposicionGastos/{id}/Observar','ReposicionGastosController@observar')
        ->name('ReposicionGastos.observar');//usa la ruta no el name
    
    /**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
    Route::get('/ReposicionGastos/{id}/PDF','ReposicionGastosController@descargarPDF')
        ->name('ReposicionGastos.exportarPDF');
    Route::get('/ReposicionGastos/{id}/verPDF','ReposicionGastosController@verPDF')
        ->name('ReposicionGastos.verPDF');





    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* --------------------------------MODULO REQUERIMIENTOS BS ----------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------------------- */
    
    /**RUTA MAESTRA PARA REPOSICION */
    Route::get('/indexRequerimiento','RequerimientoBSController@listarRequerimientos')
    ->name('RequerimientoBS.Listar');

    /* EMPLEADO */
    Route::get('/RequerimientoBS/Empleado/listar','RequerimientoBSController@listarOfEmpleado')
        ->name('RequerimientoBS.Empleado.Listar');

    Route::get('/RequerimientoBS/Empleado/crear','RequerimientoBSController@crear')
        ->name('RequerimientoBS.Empleado.CrearRequerimientoBS');
    Route::post('/RequerimientoBS/Empleado/store','RequerimientoBSController@store')
        ->name('RequerimientoBS.Empleado.store');

    Route::get('/RequerimientoBS/Empleado/{id}/ver','RequerimientoBSController@ver')
        ->name('RequerimientoBS.Empleado.ver');
    
    Route::get('/RequerimientoBS/Empleado/{id}/editar','RequerimientoBSController@editar')
        ->name('RequerimientoBS.Empleado.EditarRequerimientoBS');
    Route::post('/RequerimientoBS/Empleado/update','RequerimientoBSController@update')
        ->name('RequerimientoBS.Empleado.update');
    

    Route::get('/RequerimientoBS/Empleado/{id}/editar','RequerimientoBSController@editar')
        ->name('RequerimientoBS.Empleado.EditarRequerimientoBS');
    

    Route::get('/RequerimientoBS/Administrador/listar','RequerimientoBSController@listarOfAdministrador')
        ->name('RequerimientoBS.Administrador.Listar');

    Route::get('/RequerimientoBS/{id}/Administrador/VerAtender','RequerimientoBSController@VerAtender')
        ->name('RequerimientoBS.Administrador.VerAtender');
    

    Route::post('/RequerimientoBS/Administrador/atender','RequerimientoBSController@atender')
        ->name('RequerimientoBS.Administrador.Atender');
    

    Route::get('/RequerimientoBS/descargarArchivoEmp/{id}','RequerimientoBSController@descargarArchivoEmp')
        ->name('RequerimientoBS.descargarArchivoEmp');

    Route::get('/RequerimientoBS/descargarArchivoAdm/{id}','RequerimientoBSController@descargarArchivoAdm')
        ->name('RequerimientoBS.descargarArchivoAdm');

    Route::get('/RequerimientoBS/verPDF/{id}','RequerimientoBSController@verPDF')->name('RequerimientoBS.verPDF');
    Route::get('/RequerimientoBS/descargarPDF/{id}','RequerimientoBSController@descargarPDF')->name('RequerimientoBS.descargarPDF');
       
        
    Route::group(['middleware'=>"ValidarSesionGerente"],function()
    {
        Route::get('/RequerimientoBS/Gerente/listar','RequerimientoBSController@listarOfGerente')
            ->name('RequerimientoBS.Gerente.Listar');
        Route::get('/RequerimientoBS/{id}/Gerente/view','RequerimientoBSController@viewGeren')
            ->name('RequerimientoBS.Gerente.ver');
        Route::Post('/RequerimientoBS/Gerente/Aprobar','RequerimientoBSController@aprobar')
            ->name('RequerimientoBS.Gerente.aprobar');
    });


    Route::group(['middleware'=>"ValidarSesionAdministracion"],function()
    {

        

    });


    Route::group(['middleware'=>"ValidarSesionContador"],function()
    {


        

    
    });
    Route::get('/RequerimientoBS/Contador/listar','RequerimientoBSController@listarOfConta')
            ->name('RequerimientoBS.Contador.Listar');
    Route::get('/RequerimientoBS/{id}/Contador/view','RequerimientoBSController@viewConta')
            ->name('RequerimientoBS.Contador.ver');
    Route::get('/RequerimientoBS/{id}/Contador/Contabilizar','RequerimientoBSController@contabilizar')
            ->name('RequerimientoBS.Contador.Contabilizar');

    Route::get('/RequerimientoBS/{id}/Cancelar','RequerimientoBSController@cancelar')
        ->name('RequerimientoBS.cancelar');
    Route::get('/RequerimientoBS/{id}/Rechazar','RequerimientoBSController@rechazar')
        ->name('RequerimientoBS.rechazar');
    Route::get('/RequerimientoBS/{id}/Observar','RequerimientoBSController@observar')
        ->name('RequerimientoBS.observar');

    /**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
    Route::get('/RequerimientoBS/{id}/PDF','RequerimientoBSController@descargarPDF')
        ->name('RequerimientoBS.exportarPDF');
    Route::get('/RequerimientoBS/{id}/verPDF','RequerimientoBSController@verPDF')
        ->name('RequerimientoBS.verPDF');

} );




/* ------------------------------ ---------------- MODULO JORGE -------------- ------------------------------ */
Route::group(['prefix' => 'categoria'], function () {
    Route::get('/', ['as' => 'categoria.index', 'uses' => 'CategoriaController@index']);
    Route::get('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@create']);
    Route::post('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@store']);
    Route::get('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@edit']);
    Route::post('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@update']);
    Route::post('/delete', ['as' => 'categoria.delete', 'uses' => 'CategoriaController@destroy']);
});

