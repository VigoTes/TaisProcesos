
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
         
          @if(App\Empleado::verificarPermiso('indicador.CEE',$empresa->idEmpresa) )
        
           <a href="{{route('Indicadores.crearIndicador',$cadenaParaCrear)}}" class = "btn btn-primary"> 
                <i class="fas fa-plus"> </i> 
                  Nuevo Indicador
           </a>

          @endif

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
                          @if(App\Empleado::verificarPermiso('indicador.CEE',$empresa->idEmpresa) )
                            <i class="fas fa-edit"></i> 
                                Editar
                          @else  
                            <i class="fas fa-eye"></i> 
                            Ver
                          @endif
                          </a>

                      @if(App\Empleado::verificarPermiso('indicador.CEE',$empresa->idEmpresa) )
        
                        <a href="#" onclick="clickEliminarIndicador({{$itemIndicador->idIndicador}})" class = "btn btn-danger"> 
                            <i class="fas fa-trash-alt"> </i> 
                            Eliminar
                        </a>
                      @endif
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