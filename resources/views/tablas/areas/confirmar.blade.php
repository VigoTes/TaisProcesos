@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar la siguiente area ?</h1> 
        
        
            idUnico : {{ $area->idArea }}
            <br>
            Nro en la Empresa: {{ $area->nroEnEmpresa }}
            <br>
            Nombre del Area: {{ $area->nombreArea }}
            <br>
            Descripcion del Area: {{ $area->descripcionArea }}
            <br>
            Al borrar esta area también borrará todas sus ocurrencias en las matrices en las que se haya usado.
            <br>
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('area.destroy',$area->idArea)}}">
            @method('delete')
            @csrf

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('area.listar',$area->idEmpresa)}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection