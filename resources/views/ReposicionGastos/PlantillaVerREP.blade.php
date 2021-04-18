
@include('Layout.EstilosPegados')
<div class="container" >
    <div class="row">           
        <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
            <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                <div class="row">
                    <div  class="colLabel">
                            <label for="fecha">Fecha</label>
                    </div>
                    <div class="col">
                                            
                                <div class="input-group date form_date" style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                        value="{{$reposicion->getFechaHoraEmision()}}" >     
                                </div>
                        
                    </div>

                    <div class="w-100"></div> {{-- SALTO LINEA --}}
                    <div  class="colLabel">
                            <label for="ComboBoxProyecto">Proyecto</label>

                    </div>
                    <div class="col"> {{-- input de proyecto --}}
                        <input type="text" class="form-control" name="codProyecto" id="codProyecto" value="{{$reposicion->getProyecto()->nombre}}" disabled>
                    </div>
                
                    <div class="w-100"></div> {{-- SALTO LINEA --}}
                    <div  class="colLabel">
                            <label for="fecha">Moneda</label>

                    </div>

                    <div class="col">
                        <input type="text" class="form-control" name="codMoneda" id="codMoneda" value="{{$reposicion->getMoneda()->nombre}}" disabled>
                    </div>
                    

                    <div class="w-100"></div> {{-- SALTO LINEA --}}
                    <div  class="colLabel">
                            <label for="fecha">Banco</label>

                    </div>

                    <div class="col">
                        <input type="text" class="form-control" name="codBanco" id="codBanco" value="{{$reposicion->getBanco()->nombreBanco}}" disabled>  
                    </div>



                    <div class="w-100"></div> {{-- SALTO LINEA --}}
                    <div  class="colLabel">
                            <label for="fecha">Código Cedepas</label>

                    </div>

                    <div class="col">
                        <input type="text" class="form-control" name="" id="" value="{{$reposicion->codigoCedepas}}" disabled>  
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md"> {{-- COLUMNA DERECHA --}}
            <div class="container">
                <div class="row">
                    <div class="col">
                        <label for="fecha">Resumen de la actividad</label>
                        <textarea class="form-control" name="resumen" id="resumen" 
                            aria-label="With textarea" style="resize:none; height:50px;" readonly
                            >{{$reposicion->resumen}}</textarea>
        
                    </div>
                </div>

                <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}
                  <div  class="colLabel2">
                        <label for="fecha">CuentaBancaria</label>

                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" 
                    value="{{$reposicion->numeroCuentaBanco}}" readonly>  
                  </div>

                  <div class="w-100"></div> {{-- SALTO LINEA --}}
                  <div  class="colLabel2">
                        <label for="fecha">Girar a Orden de </label>

                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" 
                    value="{{$reposicion->girarAOrdenDe}}" readonly>  
                  </div>

                  <div class="w-100"></div>
                  <div class="colLabel2">
                      <label for="">Estado:</label>
                  </div>

                  <div class="col">
                    <input type="text" value="{{$reposicion->getNombreEstado()}}" class="form-control" readonly 
                        style="background-color: {{$reposicion->getColorEstado()}};
                                width:95%;
                                color: {{$reposicion->getColorLetrasEstado()}} ;
                        ">
                  </div>





                </div>

            </div>

            
            
        </div>
    </div>
</div>
<br>

<div class="table-responsive">                           
    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
        
        <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
            <th width="11%" class="text-center">Fecha Cbte</th>                                        
            <th width="14%">Tipo</th>                                 
            <th width="11%"> N° Cbte</th>
            <th width="26%" class="text-center">Concepto </th>
            
            <th width="11%" class="text-center">Importe </th>
            <th width="11%" class="text-center">Cod Presup </th>                                         
            
        </thead>
        <tbody>
            
            @foreach($detalles as $itemdetalle)
                <tr>
                    <td>{{$itemdetalle->getFechaComprobante()}}</td>
                    <td>{{$itemdetalle->getNombreTipoCDP()}}</td>
                    <td>{{$itemdetalle->nroComprobante}}</td>
                    <td>{{$itemdetalle->concepto}}</td>
                    <td style="text-align: right;">{{number_format($itemdetalle->importe,2)}}</td>
                    <td>
                        <input class="form-control" type="text" name="CodigoPresupuestal{{$itemdetalle->codDetalleReposicion}}" id="CodigoPresupuestal{{$itemdetalle->codDetalleReposicion}}" 
                        value="{{$itemdetalle->codigoPresupuestal}}" readonly>
                        

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> 
