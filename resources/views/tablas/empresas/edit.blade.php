@extends('Layout.Plantilla')

@section('titulo')
  Editar empresa
@endsection

@section('estilos')
    
    <style>
        .cuadroCircularPlomo1{
            background-color: rgb(175, 175, 175);
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
            /* margin: 0.5%; */
        }

        .cuadroCircularPlomo2{
            background-color: rgba(230, 230, 230, 0.548);
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
            /* margin: 0.5%; */
        }
        .col{
            /* background-color: orange; */
            margin-top: 15px;
            padding-bottom: 3px;
            margin: 0.5%;
        }
        
        

    </style>

@endsection
@section('contenido')
@if (session('datos'))
    <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
        {{session('datos')}}
        <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times;</span>
        </button>
        
    </div>
@endif

<form id="formEditarEmpresa" name="formEditarEmpresa" method = "POST" action = "{{route('empresa.update',$empresa->idEmpresa)}}"  >
    @method('put')
    @csrf   


    <div class="form-group">


        <div class="row">
                


            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="nombreEmpresa">Nombre de la Empresa</label>
                <input type="text" class="form-control @error('nombreEmpresa') is-invalid @enderror"
                            value='{{$empresa->nombreEmpresa}}' 
                    id="nombreEmpresa" name="nombreEmpresa" placeHolder="Ingrese el nombre de la empresa">

                        @error('nombreEmpresa')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  
                


                <br>
                <label for="mision">Misión</label>
                <div class="input-group">
                    <textarea class="form-control @error('mision') is-invalid @enderror"
                        style = "resize: none;"  id="mision" name="mision" value=''>{{$empresa->mision}}</textarea>
                    @error('mision')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                    @enderror  
                
                </div>


                <br>
                <label for="vision">Vision</label>
                <div class="input-group">
                    <textarea class="form-control @error('vision') is-invalid @enderror" 
                    style = "resize: none;"  id="vision" name="vision" >{{$empresa->vision}}</textarea>
                    @error('vision')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                    @enderror  
                </div>
            
                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="col">
                {{-- CONTENIDO COLUMNA --}}
        
                <label for="RUC">RUC de la Empresa</label>
                <input type="text" class="form-control @error('RUC') is-invalid @enderror" id="RUC" name="RUC" 
                    placeHolder="Ingrese RUC" value='{{$empresa->ruc}}' >
                    @error('RUC')
                        <span class = "invalid-feedback" role ="alert">
                            <strong>{{ $message }} </strong>
                        </span>
                    @enderror  
            
                
                <br>
                <label for="factorDif">Factor Diferenciador</label>
                <div class="input-group">
                    
                    <textarea class="form-control @error('factorDif') is-invalid @enderror" aria-label="With textarea"
                        style = "resize: none;" id="factorDif" name="factorDif"  >{{$empresa->factorDif}}</textarea>
                        @error('factorDif')
                        <span class = "invalid-feedback" role ="alert">
                            <strong>{{ $message }} </strong>
                        </span>
                        @enderror 
                </div>


                <br>
                <label for="propuestaV">Propuesta de valor</label>
                <div class="input-group">
                    <textarea class="form-control @error('propuestaV') is-invalid @enderror"
                            style = "resize: none;" id="propuestaV" name="propuestaV" >{{$empresa->propuestaV}}</textarea>
                    @error('propuestaV')
                        <span class = "invalid-feedback" role ="alert">
                            <strong>{{ $message }} </strong>
                        </span>
                        @enderror 
                </div>



                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="w-100"></div>


            <div class="col">
                {{-- CONTENIDO COLUMNA DOBLE TAMAÑO--}}
                    
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                        id="direccion" name="direccion" placeHolder="Ingrese Dirección de la empresa" 
                        value='{{$empresa->direccion}}' >
                    @error('direccion')
                        <span class = "invalid-feedback" role ="alert">
                            <strong>{{ $message }} </strong>
                        </span>
                    @enderror  

                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="w-100"></div>

            <div class="col"> 
                    {{-- CONTENIDO COLUMNA a--}}
                
                <div style=         "float: right;">    

                <br>

                @if(App\Empleado::verificarPermiso('empresa.editar',$empresa->idEmpresa) )
                          
                    <button type="button" onclick="clickGuardarDatos()" class="btn btn-primary">
                        <i class="fas fa-save"></i> 
                        Grabar 
                    </button>
                @endif
                
                    <a href = "{{route('empresa.listarMisEmpresas')}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                    {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    
    </div>
</form> {{-- FORM GRUP --}}

<div class="row">
    <div class="col">
        @include('tablas.empresas.Plantillas.DesplegableProcesos')

    </div>


</div>

@if(App\Empleado::verificarPermiso('empleadoDeEmpresa.CEE',$empresa->idEmpresa) )
                            
    <div class="row">
        <div class="col">

            @include('tablas.empresas.Plantillas.DesplegableEmpleados')
        </div>

    </div>

@endif
<script>
    

    function clickGuardarDatos(){
        msjError =validarFormularioGuardar();
        if(msjError!=""){
            alerta(msjError);
            return;
        }

        confirmarConMensaje("Confirmación","¿Desea actualizar la información de la empresa?",'warning',submitearFormEdicion);

    }

    function submitearFormEdicion(){
        document.formEditarEmpresa.submit();


    }
    function validarFormularioGuardar(){
        nombreEmpresa = document.getElementById('nombreEmpresa').value;  
        mision = document.getElementById('mision').value;  
        vision = document.getElementById('vision').value;  
        RUC = document.getElementById('RUC').value;  
        factorDif = document.getElementById('factorDif').value;  
        propuestaV = document.getElementById('propuestaV').value;  
        direccion = document.getElementById('direccion').value;  
                
        msjError="";
        if(nombreEmpresa=="")
            msjError="Debe ingresar un nombre válido para al empresa";
        if(mision=="")
            msjError="Debe ingresar una misión válida";
        if(vision=="")
            msjError="Debe ingresar una visión válida";
        if(RUC=="")
            msjError="Debe ingresar un RUC válido";
        if(factorDif=="")
            msjError="Debe ingresar un factor diferenciador válido";
        if(propuestaV=="")
            msjError="Debe ingresar una propuesta de valor";
        if(direccion=="")
            msjError="Debe ingresar una dirección";
        
        return msjError;
        
    }
</script>



@endsection