@extends('Layout.Plantilla')
@section('titulo')
@if($solicitud->verificarEstado('Creada'))
    Revisar Solicitud
@else
    Ver Solicitud
@endif 
@endsection
{{-- ESTA VISTA SIRVE TANTO COMO PARA REVISAR (aprobar rechazar observar)  COMO PARA VERLA NOMAS LUEGO--}}
@section('contenido')
    <div>
        <p class="h1" style="text-align: center">
            @if($solicitud->verificarEstado('Creada'))
                Revisar Solicitud de Fondos
            
                <br>
                <button class="btn btn-success"  onclick="desOactivarEdicion()">
                    Activar Edición
                </button>
          
            

            @else
                Ver Solicitud de Fondos
            @endif 
                

        </p>
        
    </div>


<form method = "POST" action = "{{route('SolicitudFondos.Gerente.Aprobar')}}"  
     id="frmSoli" >    
    {{-- CODIGO DEL EMPLEADO --}}
        <input type="hidden" name="codigoCedepas" id="codigoCedepas" 
            value="{{ $empleadoLogeado->codigoCedepas }}">
        <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
                                
        @csrf
        @include('SolicitudFondos.Plantillas.VerSOF')
                
        <div class="row" id="divTotal" name="divTotal">                       
            <div class="col-md-8">
            </div>   
            <div class="col-md-2">                        
                <label for="">Total : </label>    
            </div>   
            <div class="col-md-2">
                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                <input type="hidden" name="cantElementos" id="cantElementos">                              
                <input type="text" class="form-control text-right" name="total" id="total" value="{{number_format($solicitud->totalSolicitado,2)}}" readonly>                              
            </div>   
        </div>
                    

    
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    
                    
                    <div class="">
                        <div class="row">
                            <div class="col"><!--
                                <a href="{{route('SolicitudFondos.Gerente.Listar')}}" 
                                    class='btn btn-primary' style="float:left;">
                                    <i class="fas fa-undo"></i>
                                    Regresar al menú
                                </a>-->
                                <a href="{{route('SolicitudFondos.Gerente.Listar')}}" class='btn btn-info float-left'>
                                    <i class="fas fa-arrow-left"></i> 
                                    Regresar al Menú
                                </a>
                            </div>
                            <div class="col"></div>
                       
                          
                            
                            @if($solicitud->verificarEstado('Creada') || $solicitud->verificarEstado('Subsanada') )

                                @csrf     
                                <div class="row">
                                    <div class="col">
                                        <label for="">Observación:</label>
                                        <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                                    </div>
                                    
                                    <div class="col">
                                        <button type="button" onclick="observar()"
                                            class='btn btn-danger'   style="float:right;">
                                            <i class="fas fa-eye-slash"></i>
                                            Observar
                                        </button> 
                                        <br>
                                    </div>    
                                </div>
                        
                                <div class="col">
                                    <a href="{{route('solicitudFondos.rechazar',$solicitud->codSolicitud)}}" 
                                        class='btn btn-danger'  style="float:right;">
                                        <i class='fas fa-ban'></i>
                                        Rechazar
                                    </a>    
                                </div>
                        
                                <div class="col">
                                    <button type="button" onclick="aprobar()" class='btn btn-success'  style="float:right;">
                                        <i class="fas fa-check"></i>
                                        Aprobar
                                    </button>    
                                </div>
                            
                            
                            @endif
                        </div>
                    </div>
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



@section('script')
        
     <script>
        var cont=0;
        
        var total=0;
        var detalleSol=[];
        const textJustificacion = document.getElementById('justificacion');
        var codPresupProyecto = "{{$solicitud->getProyecto()->codigoPresupuestal}}";


        $(document).ready(function(){

           

        });

        function observar(){


            textoObs = $('#observacion').val();
            if(textoObs==""){
                alerta('No ha ingresado ninguna observación.');
                return; 
            }


            swal(
                {//sweetalert
                    title: 'Confirmación',
                    text: '¿Desea observar la Solicitud?',     //mas texto
                    type: 'info',//e=[success,error,warning,info]
                    showCancelButton: true,//para que se muestre el boton de cancelar
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText:  'SÍ',
                    cancelButtonText:  'NO',
                    closeOnConfirm:     true,//para mostrar el boton de confirmar
                    html : true
                },
                function(value){//se ejecuta cuando damos a aceptar
                    if(value){

                        codigoSolicitud = {{$solicitud->codSolicitud}};
                        console.log('Se presionó el botón observar, el texto observación es ' + textoObs + ' y el cod de la solicitud es ' +  codigoSolicitud);
            
                        location.href = '/SolicitudFondos/Observar/'+ codigoSolicitud +'*' +textoObs;
                    }
                }
            );



        }


        function aprobar(){
            msje = validarEdicion();
            if(msje!="")
            {
                alerta(msje);
                return false;
            }

            console.log('TODO OK');
            confirmar('¿Está seguro de Aprobar la Solicitud?','info','frmSoli');
        }



        var edicionActiva = false;
        function desOactivarEdicion(){
            console.log('Se activó/desactivó la edición : ' + edicionActiva);

            @foreach ($detallesSolicitud as $itemDetalle)
                inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleSolicitud}}');
                console.log(inputt);
                if(edicionActiva){
                    inputt.classList.add('inputEditable');
                    inputt.setAttribute("readonly","readonly",false);
                    textJustificacion.setAttribute("readonly","readonly",false);
                }else{
                    inputt.classList.remove('inputEditable');
                    inputt.removeAttribute("readonly"  , false);
                    textJustificacion.removeAttribute("readonly"  , false);
                }
            @endforeach
            edicionActiva = !edicionActiva;
            
            
        }
    
    
  
        function validarEdicion(){
            msj="";
            
            if(textJustificacion.value=='')
                msj= "Debe ingresar la justificacion.";
            
            
            i=1;
            @foreach ($detallesSolicitud as $itemDetalle)
                
                inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleSolicitud}}');
                if(!inputt.value.startsWith(codPresupProyecto) )
                    msj="El codigo presupuestal del item " + i + " no coincide con el del proyecto ["+ codPresupProyecto +"] .";
                i++;
            @endforeach


            return msj;
        }
    
    
    
    
    
    
    </script>
     










@endsection
