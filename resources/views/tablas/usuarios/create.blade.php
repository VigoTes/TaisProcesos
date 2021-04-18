@extends('Layout.Plantilla')
@section('contenido')


<form method = "POST" action = "{{route('usuarios.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
                


            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="name">Nombre de Usuario</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" placeHolder="Ingrese el nombre de usuario">
                        @error('name')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="email">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" placeHolder="Ingrese el email">
                        @error('email')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="password">Contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" name="password" placeHolder="Ingrese la contraseña">
                        @error('password')
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
                    id="nombres" name="nombres" placeHolder="Ingrese los nombres">
                        @error('nombres')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                    id="apellidos" name="apellidos" placeHolder="Ingrese los apellidos">
                        @error('apellidos')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  

                <label for="DNI">DNI</label>
                <input type="text" class="form-control @error('DNI') is-invalid @enderror"
                    id="DNI" name="DNI" placeHolder="Ingrese el DNI">
                        @error('DNI')
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



@endsection