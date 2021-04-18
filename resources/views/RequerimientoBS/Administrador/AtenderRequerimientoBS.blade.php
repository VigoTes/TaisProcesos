@extends('Layout.Plantilla')

@section('titulo')
    @if($requerimiento->listaParaAtender())
        Atender 
    @else   
        Ver
    @endif
        Requerimiento de Bienes y Servicios

@endsection

@section('contenido')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <div >
        <p class="h1" style="text-align: center">
            @if($requerimiento->listaParaAtender())
                Atender 
            @else   
                Ver
            @endif
            Requerimiento de Bienes y Servicios

        </p>

    </div>
    

    @include('RequerimientoBS.Plantillas.PlantillaVerRequerimiento')
    <form method = "POST" action = "{{route('RequerimientoBS.Administrador.Atender')}}" 
            id="frmAtender" name="frmAtender"  enctype="multipart/form-data">
        @csrf
        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="codRequerimiento" value="{{$requerimiento->codRequerimiento}}">
        <div class="row">  
            
                <div class="col">
                    <a href="{{route('RequerimientoBS.Administrador.Listar')}}" class='btn btn-info float-left'>
                        <i class="fas fa-arrow-left"></i> 
                        Regresar al Menú
                    </a>      

                </div>
                
                @if($requerimiento->listaParaAtender())
                    
                
                {{-- Este es para subir todos los archivos x.x  --}}
                <div class="col" id="divEnteroArchivo">            
                    <input type="{{App\Configuracion::getInputTextOHidden()}}" name="nombresArchivos" id="nombresArchivos" value="">
                    <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                            style="display: none" onchange="cambio()">  
                                    <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                    <label class="label" for="filenames" style="font-size: 12pt;">       
                            <div id="divFileImagenEnvio" class="hovered">       
                            Subir archivos  
                            <i class="fas fa-upload"></i>        
                        </div>       
                    </label>       
                </div>   

                <div class="col">



                    <button type="button" onclick="clickAtenderReq()" class="btn btn-success">
                        Atender Requerimiento
                    </button>


                </div>
                <div class="col">
                    <div class="container">
                    
                            <label for="fecha">Observación</label>
                            <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea" cols="3"></textarea>
                            <a style="margin-top: 5px" href="#" class='btn btn-warning float-right btn-sm'>
                                Observar
                            </a>  
                    


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
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@include('Layout.EstilosPegados')

@section('script')

<script>


    function clickAtenderReq(){

        msjError = validarPesoArchivos();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }


        confirmarConMensaje("Confirmación","¿Seguro que desea atender el requerimiento? Se subirán los archivos seleccionados.","warning",submitearAtender);


    }


    function submitearAtender(){

        document.frmAtender.submit();
    }

    function cambio(){
        msjError = validarPesoArchivos();
        if(msjError!=""){
            alerta(msjError);
            return;
        }

        listaArchivos="";
        cantidadArchivos = document.getElementById('filenames').files.length;

        console.log('----- Cant archivos seleccionados:' + cantidadArchivos);
        for (let index = 0; index < cantidadArchivos; index++) {
            nombreAr = document.getElementById('filenames').files[index].name;
            console.log('Archivo ' + index + ': '+ nombreAr);
            listaArchivos = listaArchivos +', '+  nombreAr; 
        }
        listaArchivos = listaArchivos.slice(1, listaArchivos.length);
        document.getElementById("divFileImagenEnvio").innerHTML= listaArchivos;
        $('#nombresArchivos').val(listaArchivos);
    }

    function validarPesoArchivos(){
        cantidadArchivos = document.getElementById('filenames').files.length;
        
        msj="";
        for (let index = 0; index < cantidadArchivos; index++) {
            var imgsize = document.getElementById('filenames').files[index].size;
            nombre = document.getElementById('filenames').files[index].name;
            if(imgsize > {{App\Configuracion::pesoMaximoArchivoMB}}*1000*1000 ){
                msj=('El archivo '+nombre+' supera los  {{App\Configuracion::pesoMaximoArchivoMB}}Mb, porfavor ingrese uno más liviano o comprima.');
            }
        }
        

        return msj;

    }
</script>


<style>
    
    .hovered:hover{
        background-color:rgb(97, 170, 170);

    }
</style>
@endsection
