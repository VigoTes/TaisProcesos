{{-- EN ESTE VAN LAS SOLICITUDES POR RENDIR Y LAS OBSERVADAS --}}

<li class="nav-item dropdown">
    <?php 
        $reposicionesObservadas = App\Empleado::getEmpleadoLogeado()->getReposicionesObservadas();
     
    ?>

    {{-- CABECERA DE TODA LA NOTIF  --}}
    <a class="nav-link" data-toggle="dropdown" href="#">
      REP
      @if(count($reposicionesObservadas)!=0)
        <span class="badge badge-danger navbar-badge">
          {{count($reposicionesObservadas)}}
        </span>
      @endif
    </a>



    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      
      
      @if(count($reposicionesObservadas)==0)
        <a href="#" class="dropdown-item dropdown-footer notificacionObservada">
          <b>No tiene Reposiciones Observadas</b> 
        </a>
      @else
        <a href="#" class="dropdown-item dropdown-footer notificacionObservada">
          <b>Reposiciones Observadas</b> 
        </a>
        @foreach($reposicionesObservadas as $detalleRepoObservada)
          <div class="dropdown-divider"></div>
          
          <a href="{{route('ReposicionGastos.Empleado.Listar')}}" class="dropdown-item notificacionObservada">
            <div class="media" >
                <h3 class="dropdown-item-title">
                  {{$detalleRepoObservada->codigoCedepas}}
                  <span class="float-right text-sm text-warning"></span>
                </h3>
                <p class="text-sm">
                  &nbsp; por {{$detalleRepoObservada->getMoneda()->simbolo}}
                    {{number_format($detalleRepoObservada->totalImporte,2)}}
                  
                </p>
            </div>
          </a>
        @endforeach
      @endif  



    </div>


  </li> 