@extends('Layout.Plantilla')
@section('contenido')

    <form method="POST" action="{{route('subproceso.update',$subproceso->idSubproceso)}}">
            @method('put')
            @csrf
            <div class="form-group">
                    <label for="idSubproceso">Codigo Unico:</label>
                <input type="text" class="form-control" id="idSubproceso" name="idSubproceso" value='{{$subproceso->idSubproceso}}' disabled>
            </div>

            <div class="form-group">
              <label for="nroEnProceso">Nro en el proceso:</label>
                <input type="text" class="form-control" id="nroEnProceso" name="nroEnProceso" value='{{$subproceso->nroEnProceso}}' disabled>
            </div>

            <div class="form-group">
              <label for="nombre">nombre:</label>
              <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"  value='{{$subproceso->nombre}}' name="nombre">
              @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
              @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Grabar</button>
              <a href="{{route('proceso.edit',$proceso->idProceso)}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
          </form>


@endsection