@extends('Layout.Plantilla')

@section('titulo')
    Listar Empleados
@endsection

@section('contenido')


<div class="card-body">
    
  <div class="well"><H3 style="text-align: center;"><strong>EMPLEADOS</strong></H3></div>
  <div class="row">
    @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif


    <div class="col-md-2">
      <a href="{{route('GestionUsuarios.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
    </div>
    <div class="col-md-10">
      <form class="form-inline float-right">
        <input class="form-control mr-sm-2" type="search" placeholder="Buscar por DNI" aria-label="Search" name="dniBuscar" id="dniBuscar" value="{{$dniBuscar}}">
        <button class="btn btn-success " type="submit">Buscar</button>
      </form>
    </div>
  </div>
  <br>

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>idBD</th>
          <th>DNI</th>
          <th>USUARIO</th>
          <th>NOMBRES Y APELLIDOS</th>
          <th>Fecha Registro</th>
          <th>PUESTO</th>
          
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

        @foreach($empleados as $itemempleado)
            <tr>
                <td>{{$itemempleado->codEmpleado}}</td>
                <td>{{$itemempleado->dni}}</td>
                
                <td>{{$itemempleado->usuario()->usuario}}</td>
                <td>{{$itemempleado->nombres}}, {{$itemempleado->apellidos}}</td>
                <td>{{$itemempleado->fechaRegistro}}</td>
                <td>{{$itemempleado->getPuestoActual()->nombre}}</td>
                <td>
                    <a href="{{route('GestionUsuarios.editUsuario',$itemempleado->codEmpleado)}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Usuario</a>
                    <a href="{{route('GestionUsuarios.editEmpleado',$itemempleado->codEmpleado)}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Empleado</a>

                    <!--Boton eliminar -->
                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Le quita el acceso al sistema." onclick="swal({//sweetalert
                            title:'<h3>¿Está seguro de cesar el usuario?',
                            text: '',     //mas texto
                            //type: 'warning',  
                            type: '',
                            showCancelButton: true,//para que se muestre el boton de cancelar
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText:  'SÍ',
                            cancelButtonText:  'NO',
                            closeOnConfirm:     true,//para mostrar el boton de confirmar
                            html : true
                        },
                        function(){//se ejecuta cuando damos a aceptar
                            window.location.href='{{route('GestionUsuarios.cesar',$itemempleado->codEmpleado)}}';

                        });"><i class="entypo-cancel"></i>Cesar</a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    
    {{$empleados->links()}}

  </div>


@endsection
