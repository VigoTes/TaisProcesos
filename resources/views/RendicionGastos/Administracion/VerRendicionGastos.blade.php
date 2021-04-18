@extends('Layout.Plantilla')

@section('titulo')
    Ver Rendición
@endsection

@section('contenido')
<div >
    <p class="h1" style="text-align: center">
        Ver Rendición de Gastos
    </p>
</div>

<form method = "POST" action = ""  enctype="multipart/form-data" >
    
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
                        <th width="10%" class="text-center">Código Presup </th>
                        
                        
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
                                            
                            </tr> 
                        @endforeach
                                       







                    </tbody>
                </table>
            </div> 
                
                      
          

            <div class="row" id="divTotal" name="divTotal">                       
                <div class="col">
                    @include('RendicionGastos.DesplegableDescargarArchivosRend')
                    


                    <a href="{{route('RendicionGastos.Administracion.Listar')}}" class='btn btn-info float-left'>
                        <i class="fas fa-arrow-left"></i> 
                        Regresar al Menu
                    </a>  

                </div>   

                <div class="col" >
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
                        
                        @if(
                                $rendicion->verificarEstado('Creada') 
                            ||$rendicion->verificarEstado('Aprobada') 
                            ||$rendicion->verificarEstado('Subsanada') 
                            || $rendicion->verificarEstado('Observada') 
                        )
                            
                        
                            <div class="w-100"></div>
                            <label for="">Observación:</label>
                            <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                            <br>
                            <a href="#" class="btn btn-warning" onclick="observarRendicion()"><i class="entypo-pencil"></i>Observar</a>
                        @endif
                    </div>
                </div>



            </div>
                    

                
        </div> 
        
      

</form>
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


</style>


@section('script')
       
     <script>
        var cont=0;
        
        var IGV=0;
        var total=0;
        var detalleRend=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    


        $(document).ready(function(){
            
        });
    
        
    
    function observarRendicion(){
        textoObs = $('#observacion').val();
        codigoSolicitud = {{$rendicion->codRendicionGastos}};
        console.log('Se presionó el botón observar, el textoobservacion es ' + textoObs + ' y el cod de la rendicion es ' +  codigoSolicitud);
        if(textoObs==''){
            alerta('Debe ingresar la observacion');
        }else{
            swal({//sweetalert
                title:'¿Seguro de observar la rendicion?',
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

    
    
    
    
    function limpiar(){
        $("#cantidad").val(0);
        //$("#precio").val(0);
        $("#producto_id").val(0);
    }
    
    /* Mostrar Mensajes de Error */
    function mostrarMensajeError(mensaje){
        $(".alert").css('display', 'block');
        $(".alert").removeClass("hidden");
        $(".alert").addClass("alert-danger");
        $(".alert").html("<button type='button' class='close' data-close='alert'>×</button>"+
                            "<span><b>Error!</b> " + mensaje + ".</span>");
        $('.alert').delay(5000).hide(400);
    }
    
    
    function number_format(amount, decimals) {
        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
        decimals = decimals || 0; // por si la variable no fue fue pasada
        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);
        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);
        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;
        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
        return amount_parts.join('.');
    }
    
    
    </script>
     










@endsection
