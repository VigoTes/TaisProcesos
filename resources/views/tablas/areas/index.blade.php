@extends('Layout.Plantilla')
@section('contenido')

<h1> Gestión de Areas </h1>
      @if (session('msjLlegada'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('msjLlegada')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif
 
<div class="card">
        <div class="card-header border-0">         
         

           <a href="{{route('area.crear',$empresaFocus->idEmpresa)}}" class = "btn btn-primary"> 
                <i class="fas fa-plus"> </i> 
                  Nueva Area
           </a>

            <nav class = "navbar float-right"> {{-- PARA MANDARLO A LA DERECHA --}}
                <form class="form-inline my-2 my-lg-0" onsubmit="{{route('area.listar',$empresaFocus->idEmpresa)}}">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" id="buscarpor" name = "buscarpor" value ="{{($buscarpor)}}" >
                    <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </nav>


          <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
          
            </a>
            <a href="#" class="btn btn-tool btn-sm">
       
            </a>
          </div>
        </div>
        
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>Nro Area</th>
              <th>Nombre del Area</th>
              <th>Descripcion</th>
         
              <th>Opciones</th>
      
              
            </tr>
            </thead>
            <tbody>
            
            @foreach($area as $itemArea)       
                <tr>
                    <td>{{$itemArea->nroEnEmpresa  }}</td>
                    <td>{{$itemArea->nombreArea  }}</td>
                    <td>{{$itemArea->descripcionArea}}</td>
              
                    <td>


                            {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                        <a href="{{route('area.edit',$itemArea->idArea)}}" class = "btn btn-warning">  
                            <i class="fas fa-edit"> </i> 
                            Editar
                        </a>

                        <a href="{{route('area.confirmar',$itemArea->idArea)}}" class = "btn btn-danger"> 
                            <i class="fas fa-trash-alt"> </i> 
                            Eliminar
                        </a>


                    </td>
                 
                    
                </tr>
            @endforeach
            
          


            </tbody>
          </table>
        </div>
      </div>


@endsection