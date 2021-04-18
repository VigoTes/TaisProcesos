<?php

namespace App\Http\Middleware;

use Closure;
use App\Debug;
use App\Empleado;
use App\Configuracion;
class ValidarSesionContador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(!Empleado::getEmpleadoLogeado()->esAdminSistema())
            if(!Empleado::getEmpleadoLogeado()->esContador())
                return redirect()->route('user.home');
            

        return $next($request);
    }
}
