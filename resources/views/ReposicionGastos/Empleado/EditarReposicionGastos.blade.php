@extends('Layout.Plantilla')

@section('titulo')
Editar Reposición de Gastos
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">Editar Reposición de Gastos</p>


</div>


<form method = "POST" action = "{{route('ReposicionGastos.Empleado.update')}}" id="frmrepo" name="frmrepo" enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepasEmpleado" id="codigoCedepasEmpleado" value="{{ $empleadoLogeado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="idEmpleado" id="idEmpleado" value="{{$empleadoLogeado->idEmpleado}}">
    
    @csrf
    <div class="container" >
        <div class="row">           
            <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="colLabel">
                            <label for="fechaHoy">Fecha</label>
                      </div>
                      <div class="col">
                                               
                                <div class="input-group date form_date" style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                           
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                              <label for="ComboBoxProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                        <select class="form-control"  id="codProyecto" name="codProyecto" onchange="actualizarCodPresupProyecto()" >
                            <option value="-1">Seleccionar</option>
                            @foreach($proyectos as $itemproyecto)
                                <option value="{{$itemproyecto->codProyecto}}" 
                                    @if($itemproyecto->codProyecto == $reposicion->codProyecto)
                                        selected
                                    @endif
                                    
                                    >
                                    [{{$itemproyecto->codigoPresupuestal}}] {{$itemproyecto->nombre}}
                                </option>                                 
                            @endforeach 
                        </select>   
                      </div>
             
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="">Moneda</label>

                      </div>

                      <div class="col">
                        <select class="form-control"  id="codMoneda" name="codMoneda" >
                            <option value="-1">Seleccionar</option>
                            @foreach($monedas as $itemmoneda)
                                <option value="{{$itemmoneda->codMoneda}}"
                                    @if($itemmoneda->codMoneda == $reposicion->codMoneda)
                                        selected
                                    @endif
                                    >
                                    {{$itemmoneda->nombre}}
                                </option>                                 
                            @endforeach 
                        </select>
                      </div>
                      

                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="">Banco</label>

                      </div>

                      <div class="col">
                        <select class="form-control"  id="codBanco" name="codBanco" >
                            <option value="-1">Seleccionar</option>
                            @foreach($bancos as $itembanco)
                                <option value="{{$itembanco->codBanco}}" 
                                    @if($itembanco->codBanco == $reposicion->codBanco)
                                        selected
                                    @endif
                                    
                                    >
                                    {{$itembanco->nombreBanco}}
                                </option>                                 
                            @endforeach 
                        </select>
                      </div>
                      
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="">Codigo Cedepas</label>

                      </div>

                      <div class="col">
                        <input type="text" class="form-control" name="" id="" value="{{$reposicion->codigoCedepas}}" disabled>  
                      </div>
                      
                      



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div style="margin-bottom: 1%">
                        <label for="fecha">Resumen de la actividad</label>
                        <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea"
                             cols="3">{{$reposicion->resumen}}</textarea>
        
                    </div>

                    <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                        <div  class="colLabel">
                                <label for="fecha">CuentaBancaria</label>

                        </div>
                        <div class="col">
                                <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" value="{{$reposicion->numeroCuentaBanco}}">    
                        </div>
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="fecha">Girar a Orden de </label>

                        </div>
                        <div class="col">
                                <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" value="{{$reposicion->girarAOrdenDe}}">    
                        </div>
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                            <label for="estado">Estado 
                                @if($reposicion->verificarEstado('Observada')){{-- Si está observada --}}& Obs @endif:</label>
                        </div>


                        <div class="col"> {{-- Combo box de estado --}}
                            <input readonly type="text" class="form-control" name="estado" id="estado"
                            style="background-color: {{$reposicion->getColorEstado()}} ;
                                color:{{$reposicion->getColorLetrasEstado()}};   
                            "
                            readonly value="{{$reposicion->getNombreEstado()}}@if($reposicion->verificarEstado('Observada')): {{$reposicion->observacion}}@endif"  >           
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
                <thead >
                    <th class="text-center">
                                                    
                            <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                {{-- INPUT PARA EL CBTE DE LA FECHA --}}
                                <input type="text" style="text-align: center" class="form-control" name="fechaComprobante" id="fechaComprobante"
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                                
                                <div class="input-group-btn">                                        
                                    <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                        <i class="fas fa-calendar fa-xs"></i>
                                    </button>
                                </div>
                            </div>
                    </th>                                        
                    <th> 
                        <div> {{-- INPUT PARA tipo--}}
                            
                            <select class="form-control"  id="ComboBoxCDP" name="ComboBoxCDP" >
                                <option value="-1">Seleccionar</option>
                                @foreach($listaCDP as $itemCDP)
                                    <option value="{{$itemCDP->nombreCDP}}" >
                                        {{$itemCDP->nombreCDP}}
                                    </option>                                 
                                @endforeach 
                            </select>        
                        </div>
                        
                    </th>                                 
                    <th>
                        <div  > {{-- INPUT PARA ncbte--}}
                            <input type="text" class="form-control" name="ncbte" id="ncbte">     
                        </div>
                    </th>
                    <th  class="text-center">
                        <div > {{-- INPUT PARA  concepto--}}
                            <input type="text" class="form-control" name="concepto" id="concepto">     
                        </div>

                    </th>
                
                    <th class="text-center">
                        <div > {{-- INPUT PARA importe--}}
                            <input type="text" class="form-control" name="importe" id="importe">     
                        </div>

                    </th>
                    <th  class="text-center">
                        <div > {{-- INPUT PARA codigo presup--}}
                            <input type="text" class="form-control" name="codigoPresupuestal" id="codigoPresupuestal">     
                        </div>

                    </th>
                    <th  class="text-center">
                        <div >
                            <button type="button" id="btnadddet" name="btnadddet" 
                                class="btn btn-success btn-sm" onclick="agregarDetalle()" >
                                <i class="fas fa-plus"></i>Agregar
                            </button>
                        </div>      
                    
                    </th>                                            
                    
                </thead>
                
                
                <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                    <th width="10%" class="text-center">Fecha Cbte</th>                                        
                    <th width="13%">Tipo</th>                                 
                    <th width="10%"> N° Cbte</th>
                    <th width="25%" class="text-center">Concepto </th>
                    
                    <th width="10%" class="text-center">Importe </th>
                    <th width="10%" class="text-center">Cod Presup </th>
                    
                    <th width="7%" class="text-center">Opciones</th>                                            
                    
                </thead>
                <tfoot>

                                                                                    
                </tfoot>
                <tbody>
                {{--       <tr>
                        <td>
                            a
                        </td>
                        <td>
                            a
                        </td>
                        <td>
                            a
                        </td>
                        <td>a

                        </td>
                        <td>
                            
        
                            <input type="file" class="btn btn-primary" name="imagen1" id="imagen1" 
                                    style="display: none" accept="" onchange="cambioInputFile()">
                            <label class="label" for="imagen1" style="font-size: 10pt;">
                                <div id='divFile1'>
                                    Subir Archivo
                                    <i class="fas fa-upload"></i> 
                                </div>
                            </label>
                            
                        </td>
                        <td>
        
                        </td>
                        <td>
                            a
                        </td>
                        <td>
                            a
                        </td>
                    </tr> --}}
                    

                </tbody>
            </table>
        </div> 


        
            

        <div class="row" id="divTotal" name="divTotal">     
            <div class="col">
                @include('ReposicionGastos.DesplegableDescargarArchivosRepo')


            </div>
            
            <div class="col">
                <div class="row">


                    <div class="col">
                    </div>   
                    <div class="col">                        
                        <label for="">Total Gastado: </label>    
                    </div>   
                    <div class="col">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">
                        <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
                        <input type="hidden" name="totalRendido" id="totalRendido">                              
                        <input type="text" class="form-control text-right" name="total" id="total" readonly>   

                    </div>   
                    
                    <div class="w-100">

                    </div>
                    <div class="col"></div>



                    {{-- Este es para subir todos los archivos x.x  --}}
                    <div class="col" id="divEnteroArchivo">            
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="nombresArchivos" id="nombresArchivos" value="">
                        <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                                style="display: none" onchange="cambio()">  
                                        <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                        <label class="label" for="filenames" style="font-size: 12pt;">       
                                <div id="divFileImagenEnvio" class="hovered">       
                                Sobrescribir archivos comprobantes  
                                <i class="fas fa-upload"></i>        
                            </div>       
                        </label>       
                    </div>    



                    







                </div>
            </div>












        </div>
                

            
    </div> 
    
    <div class="col-md-12 text-center">  
        <div class="row">
            <div class="col" style="text-align: left">
                <a href="{{route('ReposicionGastos.Empleado.Listar')}}" class='btn btn-info'>
                    <i class="fas fa-arrow-left"></i>
                    Regresar al Menu
                </a>
                
                
                
                            
            </div>   
            
            <div class="col" style="text-align: right">

                <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                    onclick="registrar()">
                    <i class='fas fa-save'></i> 
                    Registrar
                </button> 

            </div>

        </div>
    </div>

    


    <input type="hidden" name = "codReposicionGastos" value="{{$reposicion->codReposicionGastos}}">
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


@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('script')

<script type="application/javascript">
    //SE EJECUTA CUANDO CLICKEAMOS EL BOTON REG
    function registrar(){
        
        msj=validarFormularioEdit();

        if(msj!=''){
            alerta(msj);
            return false;
        }
        confirmar('¿Seguro de guardar los cambios de la reposición?','info','frmrepo');//[success,error,warning,info]

    }
    function cambiarEstilo(name, clase){
            document.getElementById(name).className = clase;
        }
    function limpiarEstilos(){
        cambiarEstilo('codProyecto','form-control');
        cambiarEstilo('codMoneda','form-control');
        cambiarEstilo('numeroCuentaBanco','form-control');
        cambiarEstilo('girarAOrdenDe','form-control');
        cambiarEstilo('codBanco','form-control');
        cambiarEstilo('resumen','form-control');
    }
</script>

       {{-- PARA EL FILE  --}}
<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file
        var cont=0;
        var total=0;
        var detalleRepo=[];
       
        $(window).load(function(){
            cargarDetallesReposicion();
            actualizarCodPresupProyecto();
            $(".loader").fadeOut("slow");
        });

        
        function cargarDetallesReposicion(){

        //console.log('aaaa ' + '/listarDetallesDereposicion/'+);
        //obtenemos los detalles de una ruta GET 
        $.get('/listarDetallesDeReposicion/'+{{$reposicion->codReposicionGastos}}, function(data)
        {      
            listaDetalles = data;
                for (let index = 0; index < listaDetalles.length; index++) {     
                    
                    detalleRepo.push({
                        codDetalleReposicion:   listaDetalles[index].codDetalleReposicion,
                        nroEnreposicion:         listaDetalles[index].nroEnreposicion,
                        fecha:                  listaDetalles[index].fechaFormateada,
                        tipo:                   listaDetalles[index].nombreTipoCDP,
                        ncbte:                  listaDetalles[index].nroComprobante,
                        concepto:               listaDetalles[index].concepto,
                        nombreImagen:           listaDetalles[index].nombreImagen,
                        importe:                listaDetalles[index].importe,            
                        codigoPresupuestal:     listaDetalles[index].codigoPresupuestal
                    });        
                }
                actualizarTabla();                

        });
        }

        


        
        

        function validarFormularioEdit(){ //Retorna '' si es que todo esta OK y 'msje error aqui' si no
            msj='';

            limpiarEstilos();
            if($('#codProyecto').val()==-1 ){ 
                cambiarEstilo('codProyecto','form-control-undefined');
                msj='Debe seleccionar un proyecto';
            }
            if($('#codMoneda').val()==-1 ){ 
                cambiarEstilo('codMoneda','form-control-undefined');
                msj='Debe seleccionar un tipo de moneda';
            }
            
            if($('#numeroCuentaBanco').val()=='' ){ 
                cambiarEstilo('numeroCuentaBanco','form-control-undefined');
                msj='Ingrese una cuenta bancaria';
            }else if($('#numeroCuentaBanco').val().length>{{App\Configuracion::tamañoMaximoNroCuentaBanco}} ){
                cambiarEstilo('numeroCuentaBanco','form-control-undefined');
                msj='La longitud del numero de cuenta tiene que ser maximo de {{App\Configuracion::tamañoMaximoNroCuentaBanco}} caracteres';
            }

            if($('#girarAOrdenDe').val()=='' ){ 
                cambiarEstilo('girarAOrdenDe','form-control-undefined');
                msj='Debe ingresar el propietario de la cuenta bancaria';
            }else if($('#girarAOrdenDe').val().length>{{App\Configuracion::tamañoMaximoGiraraAOrdenDe}} ){
                cambiarEstilo('girarAOrdenDe','form-control-undefined');
                msj='La longitud de "Girar a orden de.." tiene que ser maximo de {{App\Configuracion::tamañoMaximoGiraraAOrdenDe}} caracteres';
            }

            if($('#codBanco').val()==-1 ){ 
                cambiarEstilo('codBanco','form-control-undefined');
                msj='Debe seleccionar un banco';
            }

            if($('#resumen').val()=='' ){ 
                cambiarEstilo('resumen','form-control-undefined');
                msj='Debe ingresar el resumen';
            }else if($('#resumen').val().length>{{App\Configuracion::tamañoMaximoResumen}} ){
                cambiarEstilo('resumen','form-control-undefined');
                msj='La longitud de la resumen tiene que ser maximo de {{App\Configuracion::tamañoMaximoResumen}} caracteres';
            }

            if( $('#cantElementos').val()<=0 ){
                msj='Debe ingresar Items';
            }else if( $('#cantElementos').val()>{{App\Configuracion::valorMaximoNroItem}} ){
                msj='No se puede ingresar mas de {{App\Configuracion::valorMaximoNroItem}} Items';
            }


            //validamos que todos los items tengan el cod presupuestal correspondiente a su proyecto
            for (let index = 0; index < detalleRepo.length; index++) {
                console.log('Comparando ' + index + " starst:" +detalleRepo[index].codigoPresupuestal.startsWith(codPresupProyecto) )
                if(!detalleRepo[index].codigoPresupuestal.startsWith(codPresupProyecto) )
                {
                    msj="Error: el Código presupuestal del Item N°" 
                    + (index+1) + 
                    ": "+detalleRepo[index].codigoPresupuestal+" debe coincidir con el codigo del proyecto ("
                    +codPresupProyecto+
                    ") ";
                }
            }
            return msj;
        }

        
    
    </script>
     @include('ReposicionGastos.Plantillas.EditCreateRepoJS')










@endsection
