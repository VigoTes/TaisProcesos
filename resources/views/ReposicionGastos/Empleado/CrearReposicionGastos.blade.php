@extends('Layout.Plantilla')

@section('titulo')
  Registrar Reposición de Gastos
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">Registrar Reposición de Gastos</p>


</div>


<form method = "POST" action = "{{route('ReposicionGastos.Empleado.store')}}" id="frmrepo" name="frmrepo"  enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepasEmpleado" id="codigoCedepasEmpleado" value="{{ $empleadoLogeado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$empleadoLogeado->codEmpleado}}">
    
    @csrf
    <div class="container" >
        <div class="row">           
            <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="colLabel">
                            <label for="fecha">Fecha</label>
                      </div>
                      <div class="col">
                                               
                                <div class="input-group date form_date" style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                           
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                              <label for="ComboBoxProyecto" id="lvlProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                        <select class="form-control"  id="codProyecto" name="codProyecto" 
                                onchange="actualizarCodPresupProyecto()" >
                            <option value="-1">Seleccionar</option>
                            @foreach($proyectos as $itemproyecto)
                                <option value="{{$itemproyecto->codProyecto}}" >
                                    [{{$itemproyecto->codigoPresupuestal}}] {{$itemproyecto->nombre}} 
                                </option>                                 
                            @endforeach 
                        </select>   
                      </div>
                      <!--
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Evaluador</label>

                      </div>
                      <div class="col">
                        <select class="form-control"  id="codEmpleadoEvaluador" name="codEmpleadoEvaluador" >
                            <option value="-1">Seleccionar</option>
                            @foreach($empleadosEvaluadores as $itemevaluador)
                                <option value="{{$itemevaluador->codEmpleado}}" >
                                    {{$itemevaluador->apellidos}}, {{$itemevaluador->nombres}}
                                </option>                                 
                            @endforeach 
                        </select> 
                      </div>
                        -->
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Moneda</label>

                      </div>

                      <div class="col">
                        <select class="form-control"  id="codMoneda" name="codMoneda" >
                            <option value="-1">Seleccionar</option>
                            @foreach($monedas as $itemmoneda)
                                <option value="{{$itemmoneda->codMoneda}}" >
                                    {{$itemmoneda->nombre}}
                                </option>                                 
                            @endforeach 
                        </select>
                      </div>
                      

                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Banco</label>

                      </div>

                      <div class="col">
                        <select class="form-control"  id="codBanco" name="codBanco" >
                            <option value="-1">Seleccionar</option>
                            @foreach($bancos as $itembanco)
                                <option value="{{$itembanco->codBanco}}" >
                                    {{$itembanco->nombreBanco}}
                                </option>                                 
                            @endforeach 
                        </select>
                      </div>


                      <div class="w-100"></div>
                      <div  class="colLabel">
                        <label for="fecha">Código Cedepas</label>

                      </div>
                      <div class="col">
                            <input type="text" readonly class="form-control" value="{{App\ReposicionGastos::calcularCodigoCedepas($objNumeracion)}}
                            ">    
                      </div>
                      
                      


                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div style="margin-bottom: 1%">
                        <label for="fecha">Resumen de la actividad</label>
                        <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea"
                             cols="3"></textarea>
        
                    </div>

                    <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                      <div  class="colLabel">
                            <label for="fecha">CuentaBancaria</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" value="">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Girar a Orden de </label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" value="{{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}">    
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
            <div class="col-md-8">
            </div>   
            <div class="col-md-2">                        
                <label for="">Total Gastado: </label>    
            </div>   
            <div class="col-md-2">
                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                <input type="hidden" name="cantElementos" id="cantElementos">
                <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
                <input type="hidden" name="totalRendido" id="totalRendido">                              
                <input type="text" class="form-control text-right" name="total" id="total" readonly>   

            </div>   
            <!--
            <div class="col-md-8">
            </div>   
            <div class="col">                        
                <label for="">Total Recibido: </label>    
            </div>   

            <div class="col">
                                            
                <input type="text" class="form-control text-right" name="totalRecibido" id="totalRecibido" readonly value="">                              
            </div>   
            <div class="col-md-8">
            </div>   
            <div class="col">                        
                <label id="labelAFavorDe" for="">Saldo a favor del Empl: </label>    
            </div>   
            <div class="col">                     
                <input type="text" class="form-control text-right"  
                    name="saldoAFavor" id="saldoAFavor" readonly  value="0.00">                              
            </div>   
            -->
            <div class="w-100">

            </div>
            <div class="col-md-8"></div>



            {{-- Este es para subir todos los archivos x.x  --}}
            <div class="col" id="divEnteroArchivo">            
                <input type="{{App\Configuracion::getInputTextOHidden()}}" name="nombresArchivos" id="nombresArchivos" value="">
                <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                        style="display: none" onchange="cambio()">  
                                <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                <label class="label" for="filenames" style="font-size: 12pt;">       
                        <div id="divFileImagenEnvio" class="hovered">       
                        Subir archivos comprobantes  
                        <i class="fas fa-upload"></i>        
                    </div>       
                </label>       
            </div>    






        </div>
                

            
    </div> 
    
    <div class="col-md-12 text-center">  
        <div id="guardar">
            <div class="form-group">
                <!--
                <button class="btn btn-primary" type="submit"
                    id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                    <i class='fas fa-save'></i> 
                    Registrar
                </button>   -->
                <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                    onclick="registrar()"><i class='fas fa-save'></i> Registrar</button> 
                
                <a href="{{route('ReposicionGastos.Empleado.Listar')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menú</a>              
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

@include('Layout.EstilosPegados')

@section('script')

<script type="application/javascript">

    //SE EJECUTA CUANDO CLICKEAMOS EL BOTON REG
    function registrar(){
        
        msj=validarFormularioCrear();

        if(msj!=''){
            alerta(msj);
            return false;
        }
        confirmar('¿Seguro de crear la reposicion?','info','frmrepo');//[success,error,warning,info]

    }

    
</script>

       {{-- PARA EL FILE  --}}
<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file

        var cont=0;
        var total=0;
        var detalleRepo=[];
        
        $(document).ready(function(){
          

        });
        var listaArchivos = '';
        function registrar(){
            msje = validarFormularioCrear();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }
            
            confirmar('¿Está seguro de crear la reposicion?','info','frmrepo');
            
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

        function validarFormularioCrear(){
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
                msj='La longitud del numero de cuenta tiene que ser maximo de 50 caracteres';
            }

            if($('#girarAOrdenDe').val()=='' ){ 
                cambiarEstilo('girarAOrdenDe','form-control-undefined');
                msj='Debe ingresar el propietario de la cuenta bancaria';
            }else if($('#girarAOrdenDe').val().length>{{App\Configuracion::tamañoMaximoGiraraAOrdenDe}} ){
                cambiarEstilo('girarAOrdenDe','form-control-undefined');
                msj='La longitud de "Girar a orden de.." tiene que ser maximo de 50 caracteres';
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

            if($('#nombresArchivos').val()=="" ) msj='Debe subir los archivos comprobantes de pago.';

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
