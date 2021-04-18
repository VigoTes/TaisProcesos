
@extends('Layout.Plantilla')

@section('titulo')
    Cambiar mi contraseña
@endsection

@section('contenido')

    <br>
    <div class="well"><H3 style="text-align: center;">Cambiar mi contraseña</H3></div>
    <br>

        @if (session('datos'))
            <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
                {{session('datos')}}
            <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true"> &times;</span>
            </button>
            
            </div>
        @endif

    <form id="frmUsuario" name="frmUsuario" role="form" action="{{route('GestionUsuarios.updateContrasena')}}" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="idEmpleado" name="idEmpleado" placeholder="Codigo" value="{{ $empleado->idEmpleado}}" hidden>
            
            <div class="container">
                <div class="row">
                    <div class="col-2">

                    </div>
                    <div class="col">

                        <div class=" ">
                            <label class=" col-form-label" style="">Contraseña Actual:</label>
                            <div class="">
                                <input type="password" class="form-control" id="contraseñaActual1" name="contraseñaActual1" placeholder="Contraseña Actual...">
                            </div>
                        </div>
            
                        <div class=" ">
                            <label class=" col-form-label" style="">Repita Contraseña actual:</label>
                            <div class="">
                                <input type="password" class="form-control" id="contraseñaActual2" name="contraseñaActual2" placeholder="Contraseña actual...">
                            </div>
                        </div>

                        <br><br>

                        <div class=" ">
                            <label class=" col-form-label" style="">Nueva Contraseña:</label>
                            <div class="">
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Nueva Contraseña...">
                            </div>
                        </div>
            
                        <div class=" ">
                            <label class=" col-form-label" style="">Repetir Nueva Contraseña:</label>
                            <div class="">
                                <input type="password" class="form-control" id="contraseña2" name="contraseña2" placeholder="Nueva Contraseña...">
                            </div>
                        </div>

                        <br>
                        <button type="button" class="btn btn-primary float-right" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                            onclick="validarCambioContraseña()">
                            <i class='fas fa-save'></i> 
                            Actualizar Contraseña
                        </button> 


                    </div>
                    <div class="col-2">


                    </div>
                </div>
            </div>
            

            
    </form>

    <script>
        function validarCambioContraseña(){
            msjError="";

            if (document.getElementById("contraseñaActual1").value == ""){
                msjError = ("Ingrese su contraseña Actual.");
                $("#contraseñaActual1").focus();
            }

            if (document.getElementById("contraseñaActual2").value != document.getElementById("contraseñaActual2").value){
                msjError = ("Las contraseñas actuales no coinciden");
                $("#contraseñaActual2").focus();
            }
            
            

            if (document.getElementById("contraseña").value == ""){
                msjError = ("Ingrese su nueva contraseña.");
                $("#contraseña").focus();
            }
             
            if (document.getElementById("contraseña").value != document.getElementById("contraseña2").value){
                msjError = ("Las nuevas contraseñas no coinciden");
                $("#contraseña2").focus();
            }

            if(msjError!=""){
                alerta(msjError);
                return ;
            }

            
            confirmar('¿Seguro de guardar la contraseña?','warning','frmUsuario');
            
            


        }
    </script>

@endsection