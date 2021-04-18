@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('area.update',$area->idArea)}}"  >
    @method('put')
    @csrf   

  <div class="form-group">
    <div class="container">  {{-- Container  --}}
        <div class="row">
                
            
            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="nombreArea">Nombre del Area</label>
                <input type="text" class="form-control @error('nombreArea') is-invalid @enderror"
                   
                    id="nombreArea" name="nombreArea" placeHolder="Ingrese el nombre del Area" value="{{$area->nombreArea}}">
                    
                        @error('nombreArea')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  



                <br>
                <label for="mision">Descripcion del Area</label>
                <div class="input-group">
                    <textarea class="form-control @error('descripcionArea') is-invalid @enderror"
                        style = "resize: none;"  id="descripcionArea" name="descripcionArea" >{{$area->descripcionArea}}</textarea>
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











{{-- SEGUNDA SEPARACION AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA --}}






















<form method = "POST" action = "{{route('puesto.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
        
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                <br>
                
                <label for="descripcion">Puestos</label>
                <br>
                    <div class="container">
                        <div class="row">
                            
                             {{-- INPUT INVISIBLE PARA GUARDAR EL VALOR DE LA ID Area --}}   
                            <input type="hidden" class="form-control" 
                                        id="idArea" name="idArea" value = {{$area->idArea}}>
                            
                            <div class="col">
                            {{-- ESTE ES EL INPUT DEL QUE QUIERO AGARRAR SU VALOR --}}
                                <input type="text" class="form-control @error('nombrePuestoNuevo') is-invalid @enderror" 
                                        id="nombrePuestoNuevo" name="nombrePuestoNuevo" >
                                    @error('nombrePuestoNuevo')
                                        <span class = "invalid-feedback" role ="alert">
                                            <strong>{{ $message }} </strong>
                                        </span>
                                    @enderror  


                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-primary">  
                                           <i class="fas fa-plus"> </i>  Nuevo Registro 
                                    </button>
                                
                            </div>
                            
                        </div>
                    </div>

                <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col" style = "width: 2%">Nro</th>
                            <th scope="col" style = "width: 65%">Nombre puesto nuevo</th>
                            <th scope="col" style = "width: 20%">Opciones</th>
                            
                            </tr>
                        </thead>
                        <tbody>

                        {{-- LISTADO DE LOS OBJETIVOS DE LA EMPRESA --}}
                        @foreach($listaPuestos as $itemPuesto)

                            <tr>
                                <td>{{$itemPuesto->nroEnArea}}</td>
                                <td>{{$itemPuesto->nombre}}</td>

                                <td> <a href="{{route('puesto.edit',$itemPuesto->idPuesto)}}" class = "btn btn-warning">  
                                        <i class="fas fa-edit"> </i> 
                                        Editar
                                    </a>

                                    <a href="{{route('puesto.confirmar',$itemPuesto->idPuesto)}}" class = "btn btn-danger"> 
                                        <i class="fas fa-trash-alt"> </i> 
                                        Eliminar
                                    </a>   
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection