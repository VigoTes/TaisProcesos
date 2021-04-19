
@extends('Layout.Plantilla')
@section('contenido')

<h1> Indicadores del 
  
  @if($proceso=="")
    subproceso  "{{$subproceso->nombre}}"
  @else 
    proceso  "{{$proceso->nombre}}"
  @endif
  
 </h1>
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif
 
<div class="card">
        <div class="card-header border-0">         
         

           <a href="{{route('Indicadores.crearIndicador',$cadenaParaCrear)}}" class = "btn btn-primary"> 
                <i class="fas fa-plus"> </i> 
                  Nuevo Indicador
           </a>

            <nav class = "navbar float-right"> {{-- PARA MANDARLO A LA DERECHA --}}
                <form class="form-inline my-2 my-lg-0" onsubmit="">
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
                <th>Nombre</th>
                <th>formula</th>
                <th>Qué Medirá</th>
                <th>Quién Medirá</th>
                <th>Opciones</th>
        
              
            </tr>
            </thead>
            <tbody>
            
            @foreach($listaIndicadores as $itemIndicador)       
                <tr>
                    <td>{{$itemIndicador->nombre  }}</td>
                    <td>{{$itemIndicador->formula  }}</td>
                    <td>{{$itemIndicador->P_QueMedira}}</td>
                    <td>{{$itemIndicador->P_QuienMedira}}</td>
                    
                    <td>
                            {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                        <a href="{{route('Indicadores.editarIndicador',$itemIndicador->idIndicador)}}" class = "btn btn-warning">  
                            <i class="fas fa-edit"> </i> 
                            Editar
                        </a>

                        <a href="#" onclick="clickEliminarIndicador({{$itemIndicador->idIndicador}})" class = "btn btn-danger"> 
                            <i class="fas fa-trash-alt"> </i> 
                            Eliminar
                        </a>
                    </td>
                 
                    
                </tr>
            @endforeach
            
          


            </tbody>
          </table>


         

        </div>
        
        <a href="{{$cadenaParaVolverAlEdit}}" class="btn btn-success" style="width: 10%">
          Regresar a la Empresa
        </a>

      </div>


@endsection

@section('script')
  <script>


    idIndicadorAEliminar="";
    function clickEliminarIndicador(idIndicador){
      idIndicadorAEliminar = idIndicador;
      confirmarConMensaje("Confirmación","¿Seguro que desea eliminar por completo este indicador?","warning",ejecutarEliminacionIndicador);

    }

    function ejecutarEliminacionIndicador(){

      location.href = "/Indicadores/eliminar/"+idIndicadorAEliminar;
    }


  </script>

@endsection