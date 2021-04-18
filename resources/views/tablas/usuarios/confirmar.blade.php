@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el siguiente usuario?</h1> 
        
        <h3>
        idUsuario : {{ $usuario->id }} - Nombre de usuario:  {{ $usuario->name }}  </h3>
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('usuarios.destroy',$usuario->id)}}">
            @method('delete')
            @csrf
        

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{ route('user.index')}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection