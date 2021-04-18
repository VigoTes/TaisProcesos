@extends('Layout.Plantilla')

@section('titulo')
    Editar Datos de Empleado
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
            if (document.getElementById("nombres").value == ""){
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
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">EDITAR EMPLEADO</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="{{route('GestionUsuarios.updateEmpleado')}}" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="idEmpleado" name="idEmpleado" placeholder="Codigo" value="{{ $empleado->idEmpleado}}" hidden>
           
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Codigo:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo..." value="{{$empleado->codigoCedepas}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Nombres:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres..." value="{{$empleado->nombres}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Apellidos:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos..." value="{{$empleado->apellidos}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">DNI:</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="DNI" name="DNI" placeholder="DNI..." value="{{$empleado->dni}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codPuesto" id="codPuesto">
                    @foreach($puestos as $itempuesto)
                    <option value="{{$itempuesto->codPuesto}}" {{$itempuesto->codPuesto==$empleado->codPuesto ? 'selected':''}}>{{$itempuesto->nombre}}</option>    
                    @endforeach
                    </select>
                </div>  
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Sede:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codSede" id="codSede">
                        @foreach($sedes as $itemsede)
                        <option value="{{$itemsede->codSede}}" {{$itemsede->codSede==$empleado->codSede ? 'selected':''}}>{{$itemsede->nombre}}</option>    
                        @endforeach
                    </select>
                </div>
            </div>
                

                  


            <br />
              
            <input type="button" class="btn btn-primary float-right" value="Registrar" onclick="validarregistro()" />
            <a href="{{route('GestionUsuarios.Listar')}}" class="btn btn-info float-left"><i class="fas fa-arrow-left"></i> Regresar al Menu</a>
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
