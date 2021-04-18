@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('usuarios.update',$usuario->id)}}"  >
    @method('put')
    @csrf   
    
  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
                


            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="name">Nombre de Usuario</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" placeHolder="Ingrese el nombre de usuario" value="{{$usuario->name}}" >
                        @error('name')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="email">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" placeHolder="Ingrese el email"  value="{{$usuario->email}}" >
                        @error('email')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="DNI">DNI</label>
                <input type="text" class="form-control @error('DNI') is-invalid @enderror"
                    id="DNI" name="DNI" placeHolder="Ingrese el DNI"  value="{{$usuario->DNI}}" >
                        @error('DNI')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror 


                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="col">
                {{-- CONTENIDO COLUMNA --}}
                <label for="nombres">Nombres</label>
                <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                    id="nombres" name="nombres" placeHolder="Ingrese los nombres"  value="{{$usuario->nombres}}" >
                        @error('nombres')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                    id="apellidos" name="apellidos" placeHolder="Ingrese los apellidos"  value="{{$usuario->apellidos}}" >
                        @error('apellidos')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                 
                    
            




                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="w-100"></div>


           
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                <br>
                
                   
                <div style=         "float: right;">    

                 <button type="submit" class="btn btn-primary">   <i class="fas fa-save"> </i> Grabar </button>
                    <a href = "{{route('user.index')}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}












{{-- SEGUNDA SEPARACION AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA --}}
















{{--                             {{route('usuario.storeEmpresas',$idUsuario)}}                            --}}

<form method = "POST" action = "{{route('usuarios.updateEmpresas',$usuario->id)}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
        
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                <br>
                
                <label for="descripcion">Lista de empresas asignadas</label>
                <br>
                    <div class="container">
                        <div class="row">
                            
                             {{-- INPUT INVISIBLE PARA GUARDAR EL VALOR DE LA ID EMPRESA --}}   
                            <input type="hidden" class="form-control" 
                                        id="idUsuario" name="idUsuario" value = {{$usuario->id}}>

                        </div>
                    </div>

                <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col" style = "width: 2%">id</th>
                            <th scope="col" style = "width: 65%">Nombre Empresa</th>
                            <th scope="col" style = "width: 20%">Gestiona</th>
                   
                            
                            </tr>
                        </thead>
                        <tbody>

                        {{-- LISTADO DE LOS OBJETIVOS DE LA EMPRESA --}}
                        @foreach($listaEmpresas as $itemEmpresa)

                            <tr>
                                <td>{{$itemEmpresa->idEmpresa}}</td>
                                <td>{{$itemEmpresa->nombreEmpresa}}</td>

                                <td>
                                    <div class="form-check">
                                        <input name="CB_<?php echo($itemEmpresa->idEmpresa) ?>"
                                             id="CB_<?php echo($itemEmpresa->idEmpresa) ?>"  class="form-check-input" 
                                             type="checkbox" <?php echo($itemEmpresa->pertenece)?>  value="">
                                    </div>
                                    
                                </td>

                                
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
            
        </div>

        <div class="row">
            <div class="col">
            <div style=         "float: right;">    

                <button type="submit" class="btn btn-primary">   <i class="fas fa-save"> </i> Grabar </button>
                   <a href = "{{route('user.index')}}" class = "btn btn-danger">
                       <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
               </div>
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection
