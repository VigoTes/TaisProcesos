@extends('Layout.Plantilla')
@section('contenido')

    <form method="POST" action="{{route('puesto.update',$puesto->idPuesto)}}">
            @method('put')
            @csrf
            <div class="form-group">
                    <label for="idPuesto">Codigo Unico:</label>
                <input type="text" class="form-control" id="idPuesto" name="idPuesto" value='{{$puesto->idPuesto}}' disabled>
            </div>

            <div class="form-group">
              <label for="nroEnArea">Nro en el proceso:</label>
                <input type="text" class="form-control" id="nroEnArea" name="nroEnArea" value='{{$puesto->nroEnArea}}' disabled>
            </div>

            <div class="form-group">
              <label for="nombre">nombre:</label>
              <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"  value='{{$puesto->nombre}}' name="nombre">
              @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
              @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Grabar</button>
              <a href="{{route('area.edit',$area->idArea)}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
          </form>


@endsection