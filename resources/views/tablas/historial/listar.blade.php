@extends('Layout.Plantilla')
@section('contenido')

<h1> Lista de Cambios de la empresa </h1>
      @if (session('msjLlegada'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('msjLlegada')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif
 
<div class="card">
        {{-- <div class="card-header border-0">         
             <nav class = "navbar float-right">
                <form class="form-inline my-2 my-lg-0" onsubmit="">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" id="buscarpor" name = "buscarpor" value ="" >
                    <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </nav>
        </div> --}}
        
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle" style="font-size: 10pt">
            <thead>
            <tr>
              <th>N°</th>
              <th>Fecha</th>
              <th>Descripción</th>
              <th>Usuario Responsable</th>
              <th>Anterior Valor </th>
              <th>Nuevo Valor</th>
              
              
            </tr>
            </thead>
            <tbody>
            
            @foreach($listaEdiciones as $itemEdicion)       
                <tr>
                  <td>{{$itemEdicion->nroCambioEnEmpresa  }}</td>
                  <td>{{$itemEdicion->fechaHoraCambio  }}</td>
                  <td>{{$itemEdicion->descripcionDelCambio  }}</td>
                  <td>{{$itemEdicion->usuario()->name  }}</td>
                  <td>{{$itemEdicion->anteriorValor  }}</td>
                  <td>{{$itemEdicion->nuevoValor  }}</td>

                </tr>
            @endforeach
            
          


            </tbody>
          </table>
        </div>
      </div>


@endsection