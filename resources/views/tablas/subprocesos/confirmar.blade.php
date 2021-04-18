@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el siguiente subproceso ?</h1> 
        
        <h3>
            idUnico : {{ $subproceso->idSubproceso }}
            <br>
            Nro en el Proceso : {{ $subproceso->nroEnProceso }}
            <br>
                    

            Nombre:  {{ $subproceso->nombre }}  </h3>

            Al borrar este subproceso también borrará todas sus ocurrencias en las matrices en las que se haya usado.
            <br> 
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('subproceso.destroy',$subproceso->idSubproceso)}}">
            @method('delete')
            @csrf

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('proceso.edit',$subproceso->idProceso)}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection