@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el registro de la empresa?</h1> 
        
        <h3>
        idEmpresa : {{ $empresa->idEmpresa }} <br> Nombre de la Empresa:  {{ $empresa->nombreEmpresa }}  </h3>
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('elemento.destroy',$empresa->idEmpresa)}}">
            @method('delete')
            @csrf
            

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('empresa.index','0')}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection