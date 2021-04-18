@extends('Layout.Plantilla')

@section('titulo')
@if($solicitud->verificarEstado('Aprobada'))
    Abonar Solicitud
@else 
    Ver Solicitud
@endif
@endsection

@section('contenido')

<div>
    <p class="h1" style="text-align: center">
        @if($solicitud->verificarEstado('Aprobada'))
            Abonar a Solicitud de Fondos Aprobada
        @else 
            Ver Solicitud de Fondos
        @endif
    
        
    
    </p>
</div>

<form method = "POST" action = "{{route('SolicitudFondos.Administracion.Abonar')}}" id="frmsoli"  
enctype="multipart/form-data">
    {{-- Para saber en el post cual solicitud es  --}}    
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
                    
                    
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <a href="{{route('SolicitudFondos.Administracion.Listar',$solicitud->codSolicitud)}}" 
                                    class='btn btn-primary' style="float:left;">
                                    <i class="fas fa-undo"></i>
                                    Regresar al menú
                                </a>

                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            
                            

                            @if($solicitud->verificarEstado('Aprobada'))
                                

                            <div class="col">
                                <label for="">Observación:</label>
                                <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                            </div>
                            
                            <div class="col">
                                <button type="button" onclick="actualizarEstado('¿Seguro de observar la solicitud?', 'Observar')"
                                    class='btn btn-danger'   style="float:right;">
                                    <i class="fas fa-eye-slash"></i>
                                    Observar
                                </button> 
                                <br>
                            </div>   


                            <div class="col">
                                <a href="{{route('solicitudFondos.rechazar',$solicitud->codSolicitud)}}" 
                                    class='btn btn-danger'  style="float:right;">
                                    <i class='fas fa-ban'></i>
                                    Rechazar
                                </a>    
                            </div>

                            
                            <div class="col">
                                <button type="button" class='btn btn-success' onclick="marcarComoAbonada()" style="float:right;">
                                    <i class="fas fa-check"></i>
                                    Marcar como Abonada
                                </button>
                            </div>
                          
                            @endif






                            
                        </div>
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

@include('Layout.EstilosPegados')
@section('script')

    

     <script src="/public/select2/bootstrap-select.min.js"></script>     
     <script>
        var cont=0;
        
      
        var total=0;
  
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){

            //cuando apenas carga la pagina, se debe copiar el contenido de la tabla a detalleSol
            
        });
        



        function marcarComoAbonada(){
            

            confirmar('¿Está seguro de marcar como abonada la solicitud?','info','frmsoli');//[success,error,warning,info]
        }


        function actualizarEstado(msj, action){
            textoObs = $('#observacion').val();
            if(action=='Observar' && textoObs==''){
                alerta('Ingrese observación');
            }
            if(action=='Observar' && textoObs!=''){
                swal({//sweetalert
                    title: msj,
                    text: '',
                    type: 'warning',  
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText:  'SÍ',
                    cancelButtonText:  'NO',
                    closeOnConfirm:     true,//para mostrar el boton de confirmar
                    html : true
                },
                function(){//se ejecuta cuando damos a aceptar
                    switch (action) {
                        case 'Observar':
                            codigoSolicitud = {{$solicitud->codSolicitud}};
                            location.href = '/SolicitudFondos/Observar/'+ codigoSolicitud +'*' +textoObs;
                            break;
                    }
                    
                }); 
            }
            
        }

        /* function validar(){
            if($('#nombreImgImagenEnvio').val() == '')
                {
                    alerta('Debe subir el comprobante del deposito.')
                    return false;
                }

        } */

        


    
    
    

    
    
    
    </script>
     










@endsection
