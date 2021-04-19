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


/* ESTE MIDDLEWARE VALIDA SI ES QUE ESTÁS LOGEADO, SI NO, TE MANDA AL LOGIN */
Route::group(['middleware'=>"ValidarSesion"],function()
{

    


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

    });
    
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

    Route::resource('empresa', 'EmpresaController');  // es resource pq trabajamos con varias rutas
    Route::get('/Empresa/MisEmpresas','EmpresaController@listarMisEmpresas')->name('empresa.listarMisEmpresas');
    
    Route::get('Empresa/listarTodas/','EmpresaController@listarTodas')->name('empresa.listarTodas');
    Route::get('/Empresas/eliminarComoEmpleado/{id}','EmpresaController@eliminarEmpresaComoEmpleado'); //se consume desde JS, retorna al listar de empleado
    Route::get('/Empresas/eliminarComoAdmin/{id}','EmpresaController@eliminarEmpresaComoAdmin'); //se consume desde JS, retorna al listar todas de admin

    Route::post('/Empresas/agregarEditarProceso','EmpresaController@agregarEditarProceso')->name('Empresa.agregarEditarProceso');
    Route::post('/Empresas/agregarEditarSubproceso','EmpresaController@agregarEditarSubproceso')->name('Empresa.agregarEditarSubproceso');

    Route::get('/Empresa/eliminarProceso/{idProceso}','EmpresaController@eliminarProceso')->name('Empresa.eliminarProceso');
    Route::get('/Empresa/eliminarSubproceso/{idProceso}','EmpresaController@eliminarSubproceso')->name('Empresa.eliminarSubproceso');
    
    Route::get('/Proceso/{idProceso}/verIndicadores/','ProcesoController@verIndicadores')->name('proceso.verIndicadores');
    Route::get('/Subproceso/{idSubproceso}/verIndicadores/','SubprocesoController@verIndicadores')->name('subproceso.verIndicadores');
    
    //LA CADENA CONTIENE el id del proceso/subproceso del que se creará el indicador, y un 1 o 0 si es proceso o subproceso respectivamente, formato: "15*1"
    Route::get('/Indicadores/crearIndicador/{cadena}','IndicadorController@crearIndicador')->name('Indicadores.crearIndicador');
    Route::get('/Indicadores/editarIndicador/{idIndicador}','IndicadorController@editarIndicador')->name('Indicadores.editarIndicador');
    
    Route::get('/Indicadores/eliminar/{idIndicador}','IndicadorController@eliminar')->name('Indicadores.eliminar');
    

    Route::post('/Indicadores/store','IndicadorController@store')->name('Indicadores.store');
    Route::post('/Indicadores/update','IndicadorController@update')->name('Indicadores.update');
    

    Route::resource('objetivo', 'ObjetivoController');  // es resource pq trabajamos con varias rutas
    Route::resource('proceso', 'ProcesoController');  // es resource pq trabajamos con varias rutas
    Route::resource('subproceso', 'SubprocesoController');  // es resource pq trabajamos con varias rutas
    Route::resource('area', 'AreaController');  // es resource pq trabajamos con varias rutas
    Route::resource('puesto', 'PuestoController');  // es resource pq trabajamos con varias rutas
  
    /* GERENTE */


    Route::group(['middleware'=>"ValidarSesionGerente"],function()
    {

    

    });

    Route::group(['middleware'=>"ValidarSesionAdministracion"],function(){


    });

    Route::group(['middleware'=>"ValidarSesionContador"],function()
    {


    });
    
    


      
    
    });






