@extends('Layout.Plantilla')

@section('titulo')
  Mis Empresas
@endsection
@section('contenido')

<h1> Mis Empresas </h1>
      @if (session('msjLlegada'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('msjLlegada')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif
 
<div class="card">
        @if(App\Empleado::verificarAdminSistema())
              
          <div class="card-header border-0">         
                        
                <a href="{{route('empresa.create')}}" class = "btn btn-primary"> 
                      <i class="fas fa-plus"> </i> 
                        Nuevo Registro
                </a>
              
          </div>
        @endif
        <div class="card-body table-responsive p-0">
          @include('tablas.empresas.Plantillas.listaDeEmpresasPlantilla')
        </div>
      </div>


@endsection

@section('script')

<script>
  idEmpresaAEliminar="";

  function clickEliminar(idEmpresa){
    idEmpresaAEliminar = idEmpresa;
    confirmarConMensaje("Confirmar","¿Desea eliminar la empresa?","warning",ejecutarEliminacion);
  }

  function ejecutarEliminacion(){

    location.href="/Empresas/eliminarComoEmpleado/"+idEmpresaAEliminar;

  }
</script>

@endsection