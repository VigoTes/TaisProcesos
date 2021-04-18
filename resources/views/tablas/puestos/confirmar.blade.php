@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el siguiente puesto?</h1> 
        
        <h3>
            idUnico : {{ $puesto->idPuesto }}
            <br>
            Nro en el Area : {{ $puesto->nroEnArea }}
            <br>
                    

            Nombre:  {{ $puesto->nombre }}  </h3>
            Al borrar este puesto también borrará todas sus ocurrencias en las matrices en las que se haya usado.
            <br>       
            
            {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('puesto.destroy',$puesto->idPuesto)}}">
            @method('delete')
            @csrf

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('area.edit',$puesto->idArea)}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection