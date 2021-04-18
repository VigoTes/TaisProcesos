@extends ('Layout.Plantilla')

@section('titulo')
Listar Reposiciones
@endsection
@section('contenido')

<style>

  .col{
    margin-top: 15px;
  
    }
  
  .colLabel{
  width: 13%;
  margin-top: 18px;
  
  
  }
  
  
  </style>
  
<div>
  <h3> Mis Reposiciones de Gastos </h3>
  
  <br>
  <div class="row">
    <div class="col-md-2">
      <a href="{{route('ReposicionGastos.Empleado.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
    </div>
    <div class="col-md-10">
      <form class="form-inline float-right">

        <label style="" for="">
          Fecha:
          
        </label>
        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  style="width: 140px; margin-left: 10px">
          <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio" style="text-align: center"
                 value="{{$fechaInicio==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaInicio}}" style="text-align:center;font-size: 10pt;">
          <div class="input-group-btn">                                        
              <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
          </div>
        </div>
         - 
        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  style="width: 140px">
          <input type="text"  class="form-control" name="fechaFin" id="fechaFin" style="text-align: center"
                 value="{{$fechaFin==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaFin}}" style="text-align:center;font-size: 10pt;">
          <div class="input-group-btn">                                        
              <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
          </div>
        </div>

        <label style="" for="">
          &nbsp; Proyecto:
          
        </label>

        <select class="form-control mr-sm-2"  id="codProyectoBuscar" name="codProyectoBuscar" style="margin-left: 10px;width: 300px;">
          <option value="0">--Seleccionar--</option>
          @foreach($proyectos as $itemproyecto)
              <option value="{{$itemproyecto->codProyecto}}" {{$itemproyecto->codProyecto==$codProyectoBuscar ? 'selected':''}}>
                [{{$itemproyecto->codigoPresupuestal}}] {{$itemproyecto->nombre}}
              </option>                                 
          @endforeach 
        </select>


        <button class="btn btn-success " type="submit">Buscar</button>
      </form>
    </div>
  </div>
  
  
    

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif

    <table class="table" style="font-size: 10pt; margin-top:10px;">
            <thead class="thead-dark">
              <tr>
                <th width="9%" scope="col">Cod. Reposición</th> {{-- COD CEDEPAS --}}
                <th width="9%"  scope="col" style="text-align: center">F. Emisión</th>
                <th with="3%">Cod.</th>
                <th  scope="col">Proyecto</th>              
                <th width="16%"  scope="col">Orden de</th>
                <th width="6%"  scope="col">Banco</th>
                <th width="8%"  scope="col" style="text-align: center">Total</th>
                <th width="11%"  scope="col" style="text-align: center">Estado</th>
                <th width="9%"  scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($reposiciones as $itemreposicion)

      
            <tr>
              <td style = "padding: 0.40rem">{{$itemreposicion->codigoCedepas  }}</td>
              <td style = "padding: 0.40rem; text-align: center">{{$itemreposicion->formatoFechaHoraEmision()}}</td>
              
              <td style = "padding: 0.40rem">{{$itemreposicion->getProyecto()->codigoPresupuestal  }}</td>
              <td style = "padding: 0.40rem">{{$itemreposicion->getProyecto()->nombre  }}</td>
              <td style = "padding: 0.40rem">{{$itemreposicion->girarAOrdenDe  }}</td>
              <td style = "padding: 0.40rem">{{$itemreposicion->getBanco()->nombreBanco  }}</td>
              <td style="text-align: right; padding: 0.40rem">{{$itemreposicion->getMoneda()->simbolo}} {{number_format($itemreposicion->monto(),2)}}</td>
              
        
              <td style="text-align: center; padding: 0.40rem">
                
                <input type="text" value="{{$itemreposicion->getNombreEstado()}}" class="form-control" readonly 
                style="background-color: {{$itemreposicion->getColorEstado()}};
                        height: 26px;
                        text-align:center;
                        color: {{$itemreposicion->getColorLetrasEstado()}} ;
                "  title="{{$itemreposicion->getMensajeEstado()}}">
              </td>
              <td style = "padding: 0.40rem">       
                <a href="{{route('ReposicionGastos.Empleado.ver',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-info btn-sm" title="Ver Reposición" ><i class="fas fa-eye"></i></a>
                @if($itemreposicion->codEstadoReposicion==5 || $itemreposicion->codEstadoReposicion==1 || $itemreposicion->codEstadoReposicion==6)
                <a href="{{route('ReposicionGastos.Empleado.editar',$itemreposicion->codReposicionGastos)}}"
                   class="btn btn-warning btn-sm" title="Editar Reposición"><i class="fas fa-edit"></i></a>
                @endif
                @if($itemreposicion->codEstadoReposicion<3)
                <a href="#" class="btn btn-sm btn-danger" title="Cancelar Reposición" onclick="swal({//sweetalert
                    title:'¿Está seguro de cancelar la reposicion: {{$itemreposicion->codReposicionGastos}} ?',
                    //type: 'warning',  
                    type: 'warning',
                    showCancelButton: true,//para que se muestre el boton de cancelar
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText:  'SÍ',
                    cancelButtonText:  'NO',
                    closeOnConfirm:     true,//para mostrar el boton de confirmar
                    html : true
                },
                function(){//se ejecuta cuando damos a aceptar
                  window.location.href='{{route('ReposicionGastos.cancelar',$itemreposicion->codReposicionGastos)}}';
                });"><i class="fas fa-trash-alt"> </i></a>
                @endif
              </td>

            </tr>
        @endforeach
      </tbody>
    </table>
    {{$reposiciones->links()}}

      
</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
<style>
/* PARA COD ORDEN CON CIRCULITOS  */

  span.grey {
    background: #000000;
    border-radius: 0.8em;
    -moz-border-radius: 0.8em;
    -webkit-border-radius: 0.8em;
    color: #fff;
    display: inline-block;
    font-weight: bold;
    line-height: 1.6em;
    margin-right: 15px;
    text-align: center;
    width: 1.6em; 
    font-size : {{$fontSize}};
  }
  


  span.red {
  background:#932425;
   border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}


span.green {
  background: #5EA226;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.blue {
  background: #5178D0;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.pink {
  background: #EF0BD8;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}
   </style>
