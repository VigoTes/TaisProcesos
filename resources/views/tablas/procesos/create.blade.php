@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('proceso.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
                
            <input type="hidden" name="idEmpresaFocus" id="idEmpresaFocus" value = {{$empresaFocus->idEmpresa}}>

            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
            <label for="nombreProceso">Nombre del proceso</label>
                <input type="text" class="form-control @error('nombreProceso') is-invalid @enderror"
                   
                    id="nombreProceso" name="nombreProceso" placeHolder="Ingrese el nombre del proceso">

                        @error('nombreProceso')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  



                <br>
                <label for="mision">Descripcion del Proceso</label>
                <div class="input-group">
                    <textarea class="form-control @error('descripcionProceso') is-invalid @enderror"
                        style = "resize: none;"  id="descripcionProceso" name="descripcionProceso"  ></textarea>
                    @error('descripcionProceso')
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
                    
             

                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="w-100"></div>
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                
                  

                <br>
                    
                <div style=         "float: right;">    

                 <button type="submit" class="btn btn-primary">   <i class="fas fa-save"> </i> Grabar </button>
                    <a href = "{{route('proceso.listar',$empresaFocus->idEmpresa)}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection