@extends('Layout.Plantilla')
@section('contenido')

<h1> Mis Empresas</h1>
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
         

           <a href="{{route('empresa.create')}}" class = "btn btn-primary"> 
                <i class="fas fa-plus"> </i> 
                  Nuevo Registro
           </a>

            <nav class = "navbar float-right"> {{-- PARA MANDARLO A LA DERECHA --}}
                <form class="form-inline my-2 my-lg-0">
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
              <th>id</th>
              <th>Nombre de la Empresa</th>
              <th>RUC</th>
              <th>Direccion</th>
              <th>Opciones</th>
              
            </tr>
            </thead>
            <tbody>
            
            @foreach($listaEmpresas as $itemEmpresa)       
                <tr>
                    <td>{{$itemEmpresa->idEmpresa  }}</td>
                    <td>{{$itemEmpresa->nombreEmpresa  }}</td>
                    <td>{{$itemEmpresa->ruc}}</td>
                    <td>{{$itemEmpresa->direccion}}</td>
                    
                    <td>


                            {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                        <a href="{{route('empresa.edit',$itemEmpresa->idEmpresa)}}" class = "btn btn-warning">  
                            <i class="fas fa-edit"> </i> 
                            Editar
                        </a>

                        <a href="#" onclick="clickEliminar({{$itemEmpresa->idEmpresa}})" class = "btn btn-danger"> 
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
@section('script')

<script>
  idEmpresaAEliminar="";

  function clickEliminar(idmpresa){
    idEmpresaAEliminar = idmpresa;
    confirmarConMensaje("Confirmar","¿Desea eliminar la empresa?","warning",ejecutarEliminacion);
  }

  function ejecutarEliminacion(){

    location.href="/Empresas/eliminarComoAdmin/"+idEmpresaAEliminar;

  }
</script>

@endsection