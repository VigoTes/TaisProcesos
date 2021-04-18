@extends('Layout.Plantilla')

@section('titulo')
    @if($requerimiento->listaParaAprobar())
        Evaluar
    @else   
        Ver
    @endif
        Requerimiento de Bienes y Servicios

@endsection

@section('contenido')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <div >
        <p class="h1" style="text-align: center">
            @if($requerimiento->listaParaAprobar())
                Evaluar Requerimiento de Bienes y Servicios
                <button class="btn btn-success"  onclick="desOactivarEdicion()">Activar Edición</button>
        
            @else   
                Ver Requerimiento de Bienes y Servicios
            @endif
            
            
        </p>

    </div>
<form method = "POST" action = "{{route('RequerimientoBS.Gerente.aprobar')}}" onsubmit=""   id="frmRepo"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="idEmpleado" id="idEmpleado" value="{{$requerimiento->idEmpleadoSolicitante}}">
    <input type="hidden" name="codRequerimiento" id="codRequerimiento" value="{{$requerimiento->codRequerimiento}}">

    @include('RequerimientoBS.Plantillas.PlantillaVerRequerimiento')
    
    <div class="row text-center">  

        <div class="col">
            <a href="{{route('RequerimientoBS.Gerente.Listar')}}" class='btn btn-info float-left'>
                <i class="fas fa-arrow-left"></i> 
                Regresar al Menú
            </a>
               

        </div>
        <div class="col">
            @if($requerimiento->verificarEstado('Creada') || $requerimiento->verificarEstado('Subsanada') )
                
                <a href="#" class="btn btn-success float-right" onclick="aprobar()">
                    <i class="fas fa-check"></i> 
                    Aprobar
                </a>
                <a href="#" class="btn btn-danger float-right" style="margin-right:5px;"onclick="actualizarEstado('¿Seguro de rechazar la reposicion?', 'Rechazar')">
                    <i class="fas fa-times"></i> 
                    Rechazar
                </a>

                <!--<a href="" class="btn btn-danger float-right"><i class="entypo-pencil"></i>Rechazar</a>  -->
            @endif   
        </div>
        @if($requerimiento->verificarEstado('Creada') || $requerimiento->verificarEstado('Subsanada') )
        <div class="col">
            <div class="container">
                <div>
                    <label for="fecha">Observación</label>
                    <textarea class="form-control" name="observacion" id="observacion" aria-label="With textarea" cols="3"></textarea>
                    <a href="#" style="margin-top: 5px" class="btn btn-warning float-right" onclick="actualizarEstado('¿Seguro de observar el requerimiento?', 'Observar')">
                        <i class="entypo-pencil"></i>Observar</a>
                    
                </div>
                


            </div>
        </div>
        @endif
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
{{-- *****************************************************************************x******************************** --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>



@include('Layout.EstilosPegados')

@section('script')


<script>
    const justificacion = document.getElementById('justificacion');
    var codPresupProyecto = "{{$requerimiento->getProyecto()->codigoPresupuestal}}";

    function actualizarEstado(msj, action){
        texto=$('#observacion').val();
        if(action=='Observar' && texto==''){
            alerta('Ingrese observacion');
        }
        if((action=='Observar' && texto!='') || action=='Rechazar'){
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
                        requerimiento=$('#codRequerimiento').val();
                        window.location.href='/RequerimientoBS/'+requerimiento+'*'+texto+'/Observar'; 
                        break;
                    case 'Rechazar':
                        window.location.href="{{route('RequerimientoBS.rechazar',$requerimiento->codRequerimiento)}}";    
                        break;
                }
                
            }); 
        }
        
    }



    function aprobar(){
        msje = validarEdicion();
        if(msje!="")
            {
                alerta(msje);
                return false;
            }
        console.log('TODO OK');
        confirmar('¿Está seguro de Aprobar el requerimiento?','info','frmRepo');
        

    }
    function validarEdicion(){
        msj="";
        
        if(justificacion.value=='')
            msj= "Debe ingresar el resumen de la actividad";
        
        
        i=1;
        @foreach ($detalles as $itemDetalle)
            
            inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleRequerimiento}}');
            if(!inputt.value.startsWith(codPresupProyecto) )
                msj= "El codigo presupuestal del item " + i + " no coincide con el del proyecto ["+ codPresupProyecto +"] .";
            i++;
        @endforeach


        return msj;
    }



    
    
    var edicionActiva = false;
    function desOactivarEdicion(){
        
        console.log('Se activó/desactivó la edición : ' + edicionActiva);
        
        @foreach ($detalles as $itemDetalle)
            inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleRequerimiento}}');
            
            if(edicionActiva){
                inputt.classList.add('inputEditable');
                inputt.setAttribute("readonly","readonly",false);
                justificacion.setAttribute("readonly","readonly",false);
            }else{
                inputt.classList.remove('inputEditable');
                inputt.removeAttribute("readonly"  , false);
                justificacion.removeAttribute("readonly"  , false);
                
            }
        @endforeach
        edicionActiva = !edicionActiva;
        
        
    }
</script>


@endsection
