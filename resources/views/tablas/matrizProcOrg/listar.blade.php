@extends('Layout.Plantilla')
@section('contenido')

<h1> Gestión de Matrices </h1>
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
         

           <a href="{{route('matriz.crear',$empresaFocus->idEmpresa)}}" class = "btn btn-primary"> 
                <i class="fas fa-plus"> </i> 
                  Nueva Matriz
           </a>

            {{-- <nav class = "navbar float-right">
                <form class="form-inline my-2 my-lg-0" onsubmit="">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" id="buscarpor" name = "buscarpor" value ="" >
                    <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </nav> --}}


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
              <th>N° Matriz</th>
              <th>Tipo de Matriz</th>
              <th>Descripcion</th>
              <th>Opciones</th>
      
              
            </tr>
            </thead>
            <tbody>
            
            @foreach($listaMatrices as $itemMatriz)       
                <tr>
                    <td>{{$itemMatriz->nroEnEmpresa  }}</td>

                    <td>
                      <?php 
                        $texto="";
                        switch($itemMatriz->tipoDeMatriz)
                        {
                          case 1:
                              $texto = "Procesos vs Areas";
                              break;
                          case 2:
                              $texto = "Procesos vs Puestos";
                              break;
                          case 3:
                              $texto = "Subprocesos vs Areas";
                              break;
                          case 4:
                              $texto = "Subprocesos vs Puesto";
                              break;
                        }
                        echo($texto);
                        
                        ?> 
                     </td>
                    
                    
                    <td>{{$itemMatriz->descripcion}}</td>
              
                    <td>

                        <a href="{{route('matriz.verinforme',$itemMatriz->idMatriz)}}" class = "btn btn-primary"> 
                          <i class="fas fa-eye"></i> 
                          
                        </a>
                            {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                        <a href="{{route('matriz.edit',$itemMatriz->idMatriz)}}" class = "btn btn-warning">  
                            <i class="fas fa-edit"> </i> 
                            Editar
                        </a>

                        <a href="{{route('matriz.confirmar',$itemMatriz->idMatriz)}}" class = "btn btn-danger"> 
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