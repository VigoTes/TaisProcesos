@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('area.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
                
            <input type="hidden" name="idEmpresaFocus" id="idEmpresaFocus" value = {{$empresaFocus->idEmpresa}}>

            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
            <label for="nombreArea">Nombre del Area</label>
                <input type="text" class="form-control @error('nombreArea') is-invalid @enderror"
                   
                    id="nombreArea" name="nombreArea" placeHolder="Ingrese el nombre del Area">

                        @error('nombreArea')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  



                <br>
                <label for="mision">Descripcion del area</label>
                <div class="input-group">
                    <textarea class="form-control @error('descripcionArea') is-invalid @enderror"
                        style = "resize: none;"  id="descripcionArea" name="descripcionArea"  ></textarea>
                    @error('descripcionArea')
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
                    <a href = "{{route('area.listar',$empresaFocus->idEmpresa)}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection