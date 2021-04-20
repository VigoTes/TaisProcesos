@extends('Layout.Plantilla')

@section('titulo')

  Historial

@endsection

@section('contenido')

<h1> Lista de Cambios de empresas </h1>
      @if (session('msjLlegada'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('msjLlegada')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif
 
<div class="card">
        <form action="{{route('cambios.listar')}}">
          <div class="row">
            <div class="col"></div>
            <div class="col">


              <label for="">Empresas</label>
              <select class="form-control"  id="idEmpresa" name="idEmpresa" onchange="" >
                  <option value="" selected> -- Empresa -- </option>
                  @foreach($listaEmpresas as $itemEmpresa)
                      <option value="{{$itemEmpresa->idEmpresa}}">
                          {{$itemEmpresa->nombreEmpresa}}
                      </option>
                      
                  @endforeach
              </select>

            </div>
            <div class="col">
              <button type="submit" style="margin-top: 30px" class="btn btn-success">
                <i></i>
                Buscar
              </button>


            </div>
            <div class="col"></div>

          </div>
        </form>

        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle" style="font-size: 10pt">
            <thead>
            <tr>
              <th>N°</th>
              <th>Empresa</th>
              <th>Fecha Hora</th>
              <th>Descripción</th>
              <th>Responsable</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach($listaEdiciones as $itemEdicion)       
                <tr>
                  <td>{{$itemEdicion->idCambio  }}</td>
                  <td>{{$itemEdicion->getEmpresa()->nombreEmpresa  }}</td>
                  <td>{{$itemEdicion->fechaHora  }}</td>
                  <td>{{$itemEdicion->descripcion  }}</td>
                  <td>{{$itemEdicion->getEmpleado()->getNombreCompleto()  }}</td>
                  
                </tr>
            @endforeach
            
          


            </tbody>
          </table>
        </div>
      </div>


@endsection