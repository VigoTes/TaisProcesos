<?php

namespace App\Http\Controllers;

use App\Area;
use App\Empleado;
use App\PeriodoEmpleado;
use App\Puesto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Proyecto;
use App\Sede;
use App\Debug;
class EmpleadoController extends Controller
{
    const PAGINATION = '20';

    public function listarEmpleados(Request $request){
        $dniBuscar=$request->dniBuscar;
        $empleados = Empleado::where('activo','=',1)
            ->where('dni','like',$dniBuscar.'%')
            ->orderBy('fechaRegistro','desc')
            ->paginate($this::PAGINATION);
        return view('Empleados.Index',compact('empleados','dniBuscar'));
    }
    public function crearEmpleado(){
        //$areas=Area::all();
        //$proyectos = Proyecto::All();
       
        return view('Empleados.Create');
    }
    /*
    public function listarPuestos(Request $request,$id){
        $puestos=Puesto::where('codArea','=',$id)->get();
        return response()->json(['puestos'=>$puestos]);
    }
    */


    public function guardarCrearEmpleado(Request $request){
        //Usuario
        $usuario=new User();
        $usuario->usuario=$request->usuario;
        $usuario->password=hash::make($request->contraseña);
        $usuario->isAdmin=0;
        $usuario->save();
        //Empleado
        $empleado=new Empleado();
        $empleado->idUsuario=$usuario->idUsuario;
        $empleado->nombres=$request->nombres;
        $empleado->apellidos=$request->apellidos;
        //$empleado->direccion=$request->direccion;

        //$arr = explode('/', $request->fechaNacimiento);
        //$nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        //$empleado->fechaNacimiento=$nFecha;   

        //$empleado->sexo=$request->codSexo;
        //$empleado->tieneHijos=$request->tieneHijos;
        $empleado->activo=1;
        $empleado->codigoCedepas=$request->codigo;
        $empleado->dni=$request->DNI;
        $empleado->codPuesto=$request->codPuesto;
        
        //$arr = explode('/', $request->fechaInicio);
        //$nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaRegistro=date('y-m-d');   
        //$arr = explode('/', $request->fechaFin);
        //$nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        //$empleado->fechaFin=$nFecha;  
        
        $empleado->codSede=$request->codSede;

        //$empleado->codProyecto = $request->codProyectoDestino;
        //$empleado->fechaNacimiento=$request->fechaNacimiento->format('y-m-d');
        //$empleado->fechaNacimiento=date_format($request->fechaNacimiento,'y-m-d');


        //$empleado->codPuesto=$request->codPuesto;
        
        $empleado->save();

        return redirect()->route('GestionUsuarios.Listar');
    }

    public function editarUsuario($id){
        $empleado=Empleado::find($id);
        $usuario=$empleado->usuario();
        return view('Empleados.EditUsuario',compact('usuario','empleado'));
    }

    public function editarEmpleado($id){
       
       
        $empleado=Empleado::find($id);
        //$areas=Area::all();
        //$puestos=Puesto::all();
        return view('Empleados.EditEmpleado',compact('empleado'));
    }

    public function guardarEditarUsuario(Request $request){
        //Usuario
        //$usuario=new User();
        $empleado=Empleado::find($request->idEmpleado);
        $usuario=$empleado->usuario();
        $usuario->usuario=$request->usuario;
        $usuario->password=hash::make($request->contraseña);
        //$usuario->isAdmin=0;
        $usuario->save();

        return redirect()->route('GestionUsuarios.Listar');
    }
    public function guardarEditarEmpleado(Request $request){
        $empleado=Empleado::find($request->idEmpleado);

        $empleado->nombres=$request->nombres;
        $empleado->apellidos=$request->apellidos;
        $empleado->codigoCedepas=$request->codigo;
        $empleado->dni=$request->DNI;
        $empleado->codPuesto=$request->codPuesto; 
        $empleado->codSede=$request->codSede;

        $empleado->save();

        return redirect()->route('GestionUsuarios.Listar');
    }

    public function cesarEmpleado($id){
        $empleado=Empleado::find($id);
        $empleado->fechaDeBaja=date('y-m-d');
        $empleado->activo=0;
        $empleado->save();

        $usuario=$empleado->usuario();
        $usuario->delete();
        return redirect()->route('GestionUsuarios.ListarEmpleados');
    }


    

    public function verMisDatos(){
        $empleado=Empleado::getEmpleadoLogeado();

        return view('Empleados.MisDatos',compact('empleado'));

    }

    public function cambiarContraseña(){
        $empleado=Empleado::getEmpleadoLogeado();

        return view('Empleados.CambiarContraseña',compact('empleado'));
    }


    public function guardarContrasena(Request $request){



        try {
            $empleado=Empleado::find($request->idEmpleado);
            $hashp = $empleado->usuario()->password;

            if(!password_verify($request->contraseñaActual1,$hashp))
                return redirect()->route('GestionUsuarios.cambiarContraseña')->with('datos','La contraseña actual que ingresó no es correcta.');

            Db::beginTransaction();
            $usuario=$empleado->usuario();
            $usuario->password=hash::make($request->contraseña);
            $usuario->save();

            DB::commit();
            return redirect()->route('GestionUsuarios.cambiarContraseña')->with('datos','Se ha actualizado su contraseña con exito.');
        } catch (\Throwable $th) {
            Debug::mensajeError('EMPLEAADO CONTROLLER guardarContraseña',$th);

            DB::rollBack();
            return redirect()->route('GestionUsuarios.cambiarContraseña')->with('datos','Se ha actualizado su contraseña con exito.');
        }


        

    }
    public function guardarDPersonales(Request $request){

        $empleado=Empleado::find($request->idEmpleado);
        $empleado->nombres=$request->nombres;
        $empleado->apellidos=$request->apellidos;
        $empleado->dni=$request->DNI;

        $empleado->save();

        return redirect()->route('GestionUsuarios.verMisDatos');
    }

}
