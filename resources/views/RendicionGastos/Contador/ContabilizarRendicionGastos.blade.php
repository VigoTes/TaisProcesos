@extends('Layout.Plantilla')

@section('titulo')
Contabilizar Rendición
@endsection

@section('contenido')
<div >
    <p class="h1" style="text-align: center">Contabilizar Rendición de  Gastos</p>
</div>


    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    <input type="hidden" name="codRendicionGastos" id="codRendicionGastos" value="{{ $rendicion->codRendicionGastos }}">
    

    @csrf
    
    
    @include('RendicionGastos.PlantillaVerRG')
      


        {{-- LISTADO DE DETALLES  --}}
        <div class="col-md-12 pt-3">     
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="13%" class="text-center">Fecha</th>                                        
                        <th width="13%">Tipo CDP</th>
                                                   
                        <th width="10%"> N° Cbte</th>
                        <th width="20%" class="text-center">Concepto </th>
                        <th width="10%" class="text-center">Importe </th>
                        <th width="10%" class="text-center">Cod Presup </th>
                        <th width="10%" class="text-center">Contabilizado</th>
                        
                        
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        @foreach($detallesRend as $itemDetalle)
                            <tr class="selected" id="filaItem" name="filaItem">                
                                <td style="text-align:center;">     
                                    {{$itemDetalle->fecha  }}
                                    
                                </td>               
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->getNombreTipoCDP()  }}
                                </td>               
                               
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->nroComprobante  }}
                                </td>               
                                <td> 
                                    {{$itemDetalle->concepto  }}
                                
                                </td>               
                                <td  style="text-align:right;">               
                                {{$rendicion->getMoneda()->simbolo}} {{  number_format($itemDetalle->importe,2)  }}
                                </td>               
                                <td style="text-align:center;">               
                                    {{$itemDetalle->codigoPresupuestal  }}
                                </td>               
                                <td style="text-align:center;">               
                                    <input type="checkbox"  readonly
                                    @if($rendicion->verificarEstado('Contabilizada')) {{-- Ya está contabilizada --}}
                                        @if($itemDetalle->contabilizado=='1')
                                            checked
                                        @endif    
                                        onclick="return false;"
                                    @else {{-- Caso normal cuando se está contabilizando --}}
                                        onclick="contabilizarItem({{$itemDetalle->codDetalleRendicion}})"
                                    @endif
                                    
                                    >
                                </td>               
                                            
                            </tr> 
                        @endforeach
                                       







                    </tbody>
                </table>
            </div> 
                
                <input type="{{App\Configuracion::getInputTextOHidden()}}" id="listaContabilizados" 
                    name = "listaContabilizados" value="">

                <div class="row" id="divTotal" name="divTotal">       
                    <div class="col"> 
                    
                        @include('RendicionGastos.DesplegableDescargarArchivosRend')
                        
                        <a href="{{route('RendicionGastos.ListarRendiciones')}}" 
                            class='btn btn-primary' style="float:left;">
                            <i class="fas fa-undo"></i>
                            Regresar al menú
                        </a>    
                               
                    
                    </div>   
                    <div class="col">
                        <div class="row">
                             
                            <div class="col">                        
                                <label for="">Total Rendido/Gastado: </label>    
                            </div>   
                            <div class="col">
                                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                                <input type="hidden" name="cantElementos" id="cantElementos">                              
                                <input type="text" class="form-control text-right" name="total" id="total" readonly value="{{number_format(($rendicion->totalImporteRendido),2)}}">                              
                            </div>   
                            <div class="w-100"></div> 
                            <div class="col">                        
                                <label for="">Total Recibido: </label>    
                            </div>   

                            <div class="col">
                            
                                <input type="text" class="form-control text-right" name="total" id="total" readonly value="{{number_format($rendicion->totalImporteRecibido,2)}}">                              
                            </div>   
                            <div class="w-100"></div> 
                            <div class="col">                        
                                <label for="">

                                    @if($rendicion->saldoAFavorDeEmpleado>0) {{-- pal empl --}}
                                        Saldo a favor del Empleado: 
                                    @else
                                        Saldo a favor de Cedepas: 
                                    @endif
                                    
                                </label>    
                            </div>   
                            <div class="col">
                                <input type="text" class="form-control text-right" name="total" id="total" 
                                readonly value="{{number_format(abs($rendicion->saldoAFavorDeEmpleado),2)}}">                              
                            </div>   
                            
                            
                            <div class="w-100"></div>
             
                            
                            @if($rendicion->verificarEstado('Aprobada') )
                            @csrf     
                            <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
                            
                                <div class="col">
                                    <label for="">Observación:</label>
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                                
                                    <button type="button" onclick="observarRendicion()"
                                        class='btn btn-danger'   style="float:right;">
                                        <i class="fas fa-eye-slash"></i>
                                        Observar
                                    </button> 
                                    <br>
                                </div>    
                                {{-- <div class="col">
                                    <a href="{{route('RendicionGastos.Gerente.Rechazar',$rendicion->codRendicionGastos)}}" 
                                        class='btn btn-danger'  style="float:right;">
                                        <i class='fas fa-ban'></i>
                                        Rechazar
                                    </a>    
                                </div> --}}
                        
                                <div class="col">
                                    <button type="button" onclick="guardarContabilizar()"
                                        class='btn btn-success'  style="float:right;">
                                        <i class="fas fa-check"></i>
                                        Guardar como Contabilizado
                                    </button>    
                                </div>
                        
                    
                            @endif


                        </div>
                    </div>









                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                   
                </div>    
            </div>
        </div>
    
@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}



<style>
    .hovered:hover{
        background-color:rgb(97, 170, 170);
    }

    input[type='checkbox'] {
        /* -webkit-appearance:none; */
        width:25px;
        height:25px;
        background:white;
        border-radius:15px;
        border:2px solid #555;
    }
    input[type='checkbox']:checked {
        background: #abd;
    }
    
    
    </style>

@section('script')
       
     <script>
       
       
        $(document).ready(function(){
          
    
        });
    
        @if (App\Configuracion::enProduccion)
            document.getElementById('listaContabilizados').type = "hidden";
        @endif

        var listaItems = [];

        function contabilizarItem(item){
            
            if( listaItems.indexOf(item)==-1  )
            { //no lo tiene 
                listaItems.push(item);
            }
            else 
            { //ya lo tiene, lo quitamos
                let pos = listaItems.indexOf(item);
                listaItems.splice(pos,1);
                
            }
           
            $('#listaContabilizados').val(listaItems);

        }


        function guardarContabilizar (){
            codRendicion = {{$rendicion->codRendicionGastos}};

            msjExtra = "";
            if(listaItems.length==0){
                msjExtra = "No ha marcado ningún Ítem... ";
                
            }


            swal({//sweetalert
                title: msjExtra+'¿Seguro de contabilizar la rendición?',
                text: '',
                type: 'info',  
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:  'SÍ',
                cancelButtonText:  'NO',
                closeOnConfirm:     true,//para mostrar el boton de confirmar
                html : true
            },
            function(){
                location.href = '/rendicion/contabilizar/'+ codRendicion +'*' +listaItems;
            });
        }


        function observarRendicion(){
            textoObs = $('#observacion').val();
            codigoSolicitud = {{$rendicion->codRendicionGastos}};
            console.log('Se presionó el botón observar, el texto observación es ' + textoObs + ' y el cod de la rendición es ' +  codigoSolicitud);
            if(textoObs==''){
                alerta('Debe ingresar la observación');
            }else{
                swal({//sweetalert
                    title:'¿Seguro de observar la rendición?',
                    text: '',
                    type: 'info',  
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText:  'SÍ',
                    cancelButtonText:  'NO',
                    closeOnConfirm:     true,//para mostrar el boton de confirmar
                    html : true
                },
                function(){
                    location.href = '/rendiciones/observar/'+ codigoSolicitud +'*' +textoObs;
                });
            }
        }


    
    
    
    </script>
     










@endsection
