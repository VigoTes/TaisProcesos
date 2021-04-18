@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('proceso.update',$proceso->idProceso)}}"  >
    @method('put')
    @csrf   

  <div class="form-group">
    <div class="container">  {{-- Container  --}}
        <div class="row">
                
            
            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="nombreProceso">Nombre del proceso</label>
                <input type="text" class="form-control @error('nombreProceso') is-invalid @enderror"
                   
                    id="nombreProceso" name="nombreProceso" placeHolder="Ingrese el nombre del proceso" value="{{$proceso->nombreProceso}}">
                    
                        @error('nombreProceso')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  



                <br>
                <label for="mision">Descripcion del Proceso</label>
                <div class="input-group">
                    <textarea class="form-control @error('descripcionProceso') is-invalid @enderror"
                        style = "resize: none;"  id="descripcionProceso" name="descripcionProceso" >{{$proceso->descripcionProceso}}</textarea>
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











{{-- SEGUNDA SEPARACION AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA --}}






















<form method = "POST" action = "{{route('subproceso.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
        
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                <br>
                
                <label for="descripcion">SubProcesos</label>
                <br>
                    <div class="container">
                        <div class="row">
                            
                             {{-- INPUT INVISIBLE PARA GUARDAR EL VALOR DE LA ID PROCESO --}}   
                            <input type="hidden" class="form-control" 
                                        id="idProceso" name="idProceso" value = {{$proceso->idProceso}}>
                            
                            <div class="col">
                            {{-- ESTE ES EL INPUT DEL QUE QUIERO AGARRAR SU VALOR --}}
                                <input type="text" class="form-control @error('nombreProcesoNuev') is-invalid @enderror" 
                                        id="nombreProcesoNuev" name="nombreProcesoNuev" >
                                    @error('nombreProcesoNuev')
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
                            <th scope="col" style = "width: 65%">Nombre SubProceso</th>
                            <th scope="col" style = "width: 20%">Opciones</th>
                            
                            </tr>
                        </thead>
                        <tbody>

                        {{-- LISTADO DE LOS OBJETIVOS DE LA EMPRESA --}}
                        @foreach($listaSubProcesos as $itemSubProceso)

                            <tr>
                                <td>{{$itemSubProceso->nroEnProceso}}</td>
                                <td>{{$itemSubProceso->nombre}}</td>

                                <td> <a href="{{route('subproceso.edit',$itemSubProceso->idSubproceso)}}" class = "btn btn-warning">  
                                        <i class="fas fa-edit"> </i> 
                                        Editar
                                    </a>

                                    <a href="{{route('subproceso.confirmar',$itemSubProceso->idSubproceso)}}" class = "btn btn-danger"> 
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