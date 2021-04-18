
    <div class="container" >
        <div class="row">           
            <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="colLabel">
                            <label for="fecha">Fecha y Hora Emisión</label>
                      </div>
                      <div class="col">
                                               
                        <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" readonly
                        value="{{$requerimiento->fechaHoraEmision}}" >  
                           
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                              <label for="ComboBoxProyecto" id="lvlProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                          <input type="text" class="form-control" value="[{{$requerimiento->getProyecto()->codigoPresupuestal}}] {{$requerimiento->getProyecto()->nombre}}" readonly>
                      
                      </div>
                      

                      <div class="w-100"></div>
                      <div  class="colLabel">
                        <label for="fecha">Código Requerimiento</label>

                      </div>
                      <div class="col">
                            <input type="text" readonly class="form-control" value="{{$requerimiento->codigoCedepas}}
                            ">    
                      </div>
                      
                      


                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div style="margin-bottom: 1%">
                        <label for="fecha">Justificacion</label>
                        <textarea class="form-control" name="justificacion" id="justificacion" readonly aria-label="With textarea"
                             cols="3">{{$requerimiento->justificacion}}</textarea>
        
                    </div>
                    


                </div>
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        
                        <div class="w-100">
                        </div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="estado">Estado de la Solicitud 
                                    @if($requerimiento->verificarEstado('Observada')){{-- Si está observada --}}& Observación @endif:</label>
                        </div>
                        <div class="col"> {{-- Combo box de estado --}}
                            <input readonly type="text" class="form-control" name="estado" id="estado"
                            style="background-color: {{$requerimiento->getColorEstado()}} ;
                                color:{{$requerimiento->getColorLetrasEstado()}};
                                
                            "
                            readonly value="{{$requerimiento->getNombreEstado()}}{{$requerimiento->getObservacionONull()}}">     
                            
                                    
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    
        {{-- LISTADO DE DETALLES  --}}
    <div class="col-md-12 pt-3">     
        <div class="table-responsive">                           
            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
               
                
                <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                    <!--
                    <th width="10%" class="text-center">Fecha Cbte</th>                                        
                    -->
                    <th width="14%">Unidad Medida</th>                                 
                    <th width="12%"> Cantidad</th>
                    <th width="48%" class="text-center">Descripcion </th>
                    
                    
                    <th width="11%" class="text-center">Cod Presup </th>
                                      
                    
                </thead>
                <tbody>
                    @foreach($detalles as $itemdetalle)
                    <tr class="selected" id="fila`+item+`" name="fila` +item+`">          
                        <td style="text-align:center;">            
                            <input type="text" class="form-control" value="{{$itemdetalle->getNombreTipoUnidad()}}" readonly>
                        </td>              
                        <td style="text-align:center;">               
                            <input type="text" class="form-control" value="{{$itemdetalle->cantidad}}" readonly>
                        </td>             
                        <td>

                            <input type="text" class="form-control" value="{{$itemdetalle->descripcion}}" readonly>
                        </td>              
                    
                        <td style="text-align:center;">              
                            <input type="text" class="form-control" name="CodigoPresupuestal{{$itemdetalle->codDetalleRequerimiento}}"
                                 id="CodigoPresupuestal{{$itemdetalle->codDetalleRequerimiento}}" value="{{$itemdetalle->codigoPresupuestal}}" readonly>
                        </td>     
                       
                    </tr>
    
                    @endforeach
                    
                </tbody>
            </table>
        </div> 


        
            

        <div class="row" id="" name="">                       
            <div class="col" style="">
                @include('RequerimientoBS.Plantillas.Desplegables.DescargarArchivosEmp')

            </div> 
            <div class="col">

                @if($requerimiento->verificarEstado('Atendida') || $requerimiento->verificarEstado('Contabilizada')   )
                    @include('RequerimientoBS.Plantillas.Desplegables.DescargarArchivosAdm')
                @endif
                
            </div>
            
            <div class="col"></div>


        </div>
                
        
            
    </div> 