@extends('Layout.Plantilla')

@section('titulo')
    Crear Empleado
@endsection

@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    
<script type="text/javascript"> 
          
    function validarregistro() 
        {
            var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
            /*
            if(expreg2.test(document.getElementById("usuario").value))
                alerta("La matrícula es correcta");
            else
                alerta("La matrícula NO es correcta");
            */
            if (document.getElementById("usuario").value == ""){
                alerta("Ingrese el usuario");
                $("#nombre").focus();
            }
            else if (document.getElementById("contraseña").value == ""){
                alerta("Ingrese contraseña del usuario");
                $("#contraseña").focus();
            }
            else if (document.getElementById("contraseña").value != document.getElementById("contraseña2").value){
                alerta("Las contraseñas no coinciden");
                $("#contraseña").focus();
            }
            else if (document.getElementById("nombres").value == ""){
                alerta("Ingrese nombres del usuario");
                $("#nombres").focus();
            }
            else if (!expreg.test(document.getElementById("nombres").value)){
                alerta("Ingrese nombres correctos");
                $("#nombres").focus();
            }
            else if (document.getElementById("apellidos").value == ""){
                alerta("Ingrese apellidos del usuario");
                $("#apellidos").focus();      
            }
            else if (!expreg.test(document.getElementById("apellidos").value)){
                alerta("Ingrese apellidos correctos");
                $("#apellidos").focus();
            }
            else if (document.getElementById("DNI").value == ""){
                alerta("Ingrese DNI de la usuario");
                $("#DNI").focus();
            }
            else if (document.getElementById("DNI").value.length != 8){
                alerta("Ingrese DNI de 8 caracteres");
                $("#DNI").focus();
            }
            else{
                document.frmEmpleado.submit(); // enviamos el formulario	
            }
        }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">CREAR EMPLEADO</H3></div>
    <br>
    <form id="frmEmpleado" name="frmEmpleado" role="form" action="{{route('GestionUsuarios.store')}}" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Usuario:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario..." >
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Contraseña:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña...">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Repetir Contraseña:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="contraseña2" name="contraseña2" placeholder="Contraseña...">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Codigo:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo..." >
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Nombres:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres..." >
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Apellidos:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos..." >
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">DNI:</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="DNI" name="DNI" placeholder="DNI..." >
                </div>
            </div>

                
            
            <input type="button" class="btn btn-primary float-right" value="Registrar" onclick="validarregistro()" />
            <a href="{{route('GestionUsuarios.Listar')}}" class="btn btn-info float-left"><i class="fas fa-arrow-left"></i> Regresar al Menu</a>
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
