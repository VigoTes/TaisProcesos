@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el siguiente proceso ?</h1> 
        
        
            idUnico : {{ $proceso->idProceso }}
            <br>
            Nro en la Empresa: {{ $proceso->nroEnEmpresa }}
            <br>
            Nombre del proceso: {{ $proceso->nombreProceso }}
            <br>
            Descripcion del proceso: {{ $proceso->descripcionProceso }}
            <br>
            Al borrar este proceso también borrará todas sus ocurrencias en las matrices en las que se haya usado.
            <br>
        
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('proceso.destroy',$proceso->idProceso)}}">
            @method('delete')
            @csrf

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('proceso.listar',$proceso->idEmpresa)}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection