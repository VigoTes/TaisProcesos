@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('matriz.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
                
            <input type="hidden" name="idEmpresaFocus" id="idEmpresaFocus" value = {{$empresaFocus->idEmpresa}}>

            <div class="col">
                 <br>
                {{-- CONTENIDO DE LA COLUMNA --}}
            <label for="nombreArea">Tipo de la matriz</label> <i> (Una vez seleccionado el tipo de matriz, no se podrá alterar) </i>
                    <select class="custom-select" id="tipoMatriz" name="tipoMatriz">
                     
                        <option value="1" selected>Procesos vs Areas</option>
                        <option value="2">Procesos vs Puestos</option>
                        <option value="3">Subprocesos vs Areas</option>
                        <option value="4">Subprocesos vs Puestos</option>
                        
                    </select> 
                       



                <br>
                <label for="descripcion">Descripcion de la matriz</label>
                <div class="input-group">
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                        style = "resize: none;"  id="descripcion" name="descripcion"  ></textarea>
                    @error('descripcion')
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
                    <a href = "{{route('matriz.listar',$empresaFocus->idEmpresa)}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection