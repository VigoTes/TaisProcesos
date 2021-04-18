@extends('Layout.Plantilla')

@section('titulo')
    @if($reposicion->verificarEstado('Aprobada'))
                    Abonar
                @else 
                    Ver
                @endif
            
                
                Reposición de Gastos
    @endsection
@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-md-10">
        <p class="h1" style="margin-left:430px;">
            @if($reposicion->verificarEstado('Aprobada'))
                Abonar
            @else 
                Ver
            @endif
        
            
            Reposición de Gastos
        </p>
    </div>
    <div class="col-md-2">
        <br>
        <a  href="{{route('ReposicionGastos.exportarPDF',$reposicion->codReposicionGastos)}}" 
            class="btn btn-warning btn-sm btn-right" style="margin-left:60px;">
            <i class="entypo-pencil"></i>
            PDF
          </a>
        <a target="blank" href="{{route('ReposicionGastos.verPDF',$reposicion->codReposicionGastos)}}" 
            class="btn btn-warning btn-sm btn-right">
            <i class="entypo-pencil"></i>
            verPDF
        </a>
    </div>
</div>


<form method = "POST" action = "{{route('ReposicionGastos.Empleado.store')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="idEmpleado" id="idEmpleado" value="{{$reposicion->idEmpleadoSolicitante}}">
    <input type="hidden" name="codReposicionGastos" id="codReposicionGastos" value="{{$reposicion->codReposicionGastos}}">
    
    @csrf
    
    
    
    @include('ReposicionGastos.PlantillaVerREP')



                   
                
    <div class="row" id="divTotal" name="divTotal">                       
        <div class="col"  style="">

            @include('ReposicionGastos.DesplegableDescargarArchivosRepo')
            <a href="{{route('ReposicionGastos.Administracion.Listar')}}" class='btn btn-info float-left'>
                <i class="fas fa-arrow-left"></i> Regresar al Menú
            </a>  
        </div>   

        
        
            
        <div class="col-md-2" style="text-align:center">                        
            <label for="">Total Gastado: </label>    
            <br><br><br>
            @if($reposicion->verificarEstado('Aprobada'))
                <label for="fecha">Observaciones</label>
                <textarea class="form-control" name="observacion" id="observacion" 
                    aria-label="With textarea" style="resize:none; height:100px;"></textarea>
                <br>
                @endif
        </div>   
        


        <div class="col-md-2">
            {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
            <input type="hidden" name="cantElementos" id="cantElementos">
            <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
            <input type="hidden" name="totalRendido" id="totalRendido">

            <input type="text" class="form-control text-right" name="total" 
                id="total" readonly value="{{number_format($reposicion->totalImporte,2)}}">   

                <br><br><br>
            <!--<a href="#" class="btn btn-warning" onclick="observar()">
                Observar
            </a>-->



            @if($reposicion->verificarEstado('Aprobada'))
                <a href="#" class="btn btn-warning" onclick="actualizarEstado('¿Seguro de observar la reposicion?', 'Observar')">
                    <i class="entypo-pencil"></i>Observar
                </a> 
            @endif
        </div>   

        

    </div>
               
           
        
    <div class="col-md-12 text-center">  
        <div id="guardar">
            <div class="form-group">
                
                

                @if($reposicion->verificarEstado('Aprobada'))
                


                <a href="#" class="btn btn-success float-right" onclick="actualizarEstado('¿Seguro de abonar la reposición?', 'Abonar')">
                    <i class="fas fa-check"></i> Marcar como Abonada</a>
                
                <a href="#" class="btn btn-danger float-right" style="margin-right:5px;" onclick="actualizarEstado('¿Seguro de rechazar la reposición?', 'Rechazar')">
                    <i class="fas fa-times"></i> Rechazar</a> 


                @endif


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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<style>

    .hovered:hover{
    background-color:rgb(97, 170, 170);
}


    </style>

@section('script')



       {{-- PARA EL FILE  --}}
<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file

    function actualizarEstado(msj, action){
        texto=$('#observacion').val();
        if(action=='Observar' && texto==''){
            alerta('Ingrese observacion');
        }
        if((action=='Observar' && texto!='') || action=='Rechazar'|| action=='Abonar'){
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
                        reposicion=$('#codReposicionGastos').val();
                        //window.location.href='/Reposicion/'+reposicion+'*'+texto+'/observar';
                        window.location.href='/ReposicionGastos/'+reposicion+'*'+texto+'/Observar'; 
                        break;
                    case 'Abonar':
                        window.location.href="{{route('ReposicionGastos.abonar',$reposicion->codReposicionGastos)}}";
                        break;
                    case 'Rechazar':
                        window.location.href="{{route('ReposicionGastos.rechazar',$reposicion->codReposicionGastos)}}";    
                        break;
                }
                
            }); 
        }
        
    }


    /*
    function observar(){
        texto=$('#observacion').val();
        if(texto!=''){
            reposicion=$('#codReposicionGastos').val();
            //window.location.href='/Reposicion/'+reposicion+'*'+texto+'/observar';
            window.location.href='/ReposicionGastos/'+reposicion+'*'+texto+'/Observar'; 
        }
        else{ 
            alerta('Ingrese observacion');
        }
    }*/
    function cambio(index){

        if(index=='imagenEnvio'){//si es pal comprobante de envio
            
            //DEPRECADO PORQUE AHORA EL ARCHIVO DE CBTE DE DEVOLUCION DE FONDOS SE ADJUNTA COMO UN CBTE MÁS
            /* var idname= 'imagenEnvio'; 
            var filename = $('#imagenEnvio').val().split('\\').pop();
            console.log('filename= '+filename+'    el id es='+idname+'  el index es '+index)
            jQuery('span.'+idname).next().find('span').html(filename);
            document.getElementById("divFileImagenEnvio").innerHTML= filename;
            $('#nombreImgImagenEnvio').val(filename);
             */
        }
        else{ //para los CDP de la tabla
            var idname= 'imagen'+index; 
            var filename = $('#imagen'+index).val().split('\\').pop();
            console.log('filename= '+filename+'    el id es='+idname+'  el index es '+index)
            //jQuery('span.'+idname).next().find('span').html(filename);
            document.getElementById("divFile"+index).innerHTML= filename;
            $('#nombreImg'+index).val(filename);
            
        
        }
    
    }


</script>

     <script>
        var cont=0;
        
        //var IGV=0;
        var total=0;
        var detalleRend=[];
        //var importes=[];
        //var controlproducto=[];
        //var totalSinIGV=0;
        //var saldoFavEmpl=0;

                //GENERACION DE codigoCedepas
                var d = new Date();
                codEmp = $('#codigoCedepasEmpleado').val();
                mes = (d.getMonth()+1.0).toString();
                if(mes.length > 0) mes = '0' + mes;

                year =  d.getFullYear().toString().substr(2,2)  ;
                $('#codigoCedepas').val( codEmp +'-'+ d.getDate() +mes + year + cadAleatoria(2));
                //alerta($('#codigoCedepas').val());
    
        

        function alertaArchivo(){
            alerta('Asegúrese de haber añadido todos los ítems antes de subir los archivos.');

        }

        function cadAleatoria(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var abecedario = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var charactersLength = characters.length;
            var abecedarioLength = abecedario.length;
            for ( var i = 0; i < length; i++ ) {
                if(i==0)//primer caracter fijo letra
                    result += abecedario.charAt(Math.floor(Math.random() * abecedarioLength));
                else//los demas da igual que sean numeros
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));

            }
            return result;
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
