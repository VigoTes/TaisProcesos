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
            @if($requerimiento->listaParaContabilizar())
                Contabilizar 
            @else   
                Ver
            @endif
            Requerimiento de Bienes y Servicios
        
        </p>

    </div>
<form method = "POST" action = "{{route('RequerimientoBS.Gerente.aprobar')}}" onsubmit=""   id="frmRepo"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$requerimiento->codEmpleadoSolicitante}}">
    <input type="hidden" name="codRequerimiento" id="codRequerimiento" value="{{$requerimiento->codRequerimiento}}">

    @include('RequerimientoBS.Plantillas.PlantillaVerRequerimiento')
    
    <div class="row text-center">  

        <div class="col">
            <a href="{{route('RequerimientoBS.Contador.Listar')}}" class='btn btn-info float-left'>
                <i class="fas fa-arrow-left"></i> 
                Regresar al Menú
            </a>
               

        </div>
        <div class="col">
            @if($requerimiento->verificarEstado('Atendida'))
                
                <a href="#" class="btn btn-success float-right" onclick="clickOnContabilizar()">
                    <i class="fas fa-check"></i> 
                    Contabilizar
                </a>


                <!--<a href="" class="btn btn-danger float-right"><i class="entypo-pencil"></i>Rechazar</a>  -->
            @endif   
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
{{-- *****************************************************************************x******************************** --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>



@include('Layout.EstilosPegados')

@section('script')


<script>
    const justificacion = document.getElementById('justificacion');
    var codPresupProyecto = "{{$requerimiento->getProyecto()->codigoPresupuestal}}";

    function clickOnContabilizar(){
        confirmarConMensaje("Confirmar","¿Desea marcar como contabilizada el requerimiento?","info",contabilizar);
    }

    function contabilizar(){
        location.href = "{{route('RequerimientoBS.Contador.Contabilizar',$requerimiento->codRequerimiento)}}";
    }



    
</script>


@endsection
