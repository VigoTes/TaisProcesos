{{-- EN ESTE VAN LAS RENDICIONES OBSERVADAS --}}

<li class="nav-item dropdown">
    <?php 
        $rendicionesObservadas = App\Empleado::getEmpleadoLogeado()->getRendicionesObservadas();
     
    ?>

    {{-- CABECERA DE TODA LA NOTIF  --}}
    <a class="nav-link" data-toggle="dropdown" href="#">
      REN
      
      @if(count($rendicionesObservadas)!=0)
        <span class="badge badge-danger navbar-badge">
          {{count($rendicionesObservadas)}}
        </span>
      @endif
    </a>

    

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      
      
      @if(count($rendicionesObservadas)==0)
        <a href="#" class="dropdown-item dropdown-footer notificacionObservada">
          <b>No tiene Rendiciones Observadas</b> 
        </a>
      @else
        <a href="#" class="dropdown-item dropdown-footer notificacionObservada">
          <b>Rendiciones Observadas</b> 
        </a>
        @foreach($rendicionesObservadas as $detalleRendObservada)
          <div class="dropdown-divider"></div>
          
          <a href="{{route('RendicionGastos.Empleado.Listar')}}" class="dropdown-item notificacionObservada">
            <div class="media" >
                <h3 class="dropdown-item-title">
                  {{$detalleRendObservada->codigoCedepas}}
                  <span class="float-right text-sm text-warning"></span>
                </h3>
                <p class="text-sm">
                  &nbsp; por gasto de {{$detalleRendObservada->getMoneda()->simbolo}}
                    {{number_format($detalleRendObservada->totalImporteRendido,2)}}
                  
                </p>
            </div>
          </a>
        @endforeach
      @endif  



    </div>


  </li> 