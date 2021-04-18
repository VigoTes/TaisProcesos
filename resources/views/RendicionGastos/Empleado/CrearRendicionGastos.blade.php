@extends('Layout.Plantilla')

@section('titulo')
Crear Rendición
@endsection

@section('contenido')

<div >
    <p class="h1" style="text-align: center">Registrar Rendición de Gastos</p>


</div>


<form method = "POST" action = "{{route('RendicionGastos.Empleado.Store')}}" 
onsubmit="return validarFormCrear()"  enctype="multipart/form-data" id="frmrend" name="frmrend">
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleadoLogeado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    
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
                              <label for="ComboBoxProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                          <input readonly type="text" class="form-control" name="proyecto" id="proyecto" value="{{$solicitud->getNombreProyecto()}}">    
        
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Colaborador</label>

                      </div>
                      <div class="col">
                            <input  readonly type="text" class="form-control" name="colaboradorNombre" id="colaboradorNombre" value="{{$empleadoLogeado->nombres}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Cod Colaborador</label>

                      </div>

                      <div class="col">
                            <input readonly  type="text" class="form-control" name="codColaborador" id="codColaborador" value="{{$empleadoLogeado->codigoCedepas}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Importe Recibido</label>

                      </div>
                      <div class="col">
                            <input readonly  type="text" class="form-control" name="importeRecibido" id="importeRecibido"value="{{number_format($solicitud->totalSolicitado,2)}}">    
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

                    <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                        <div class="row">
                            <div  class="colLabel">
                                    <label for="fecha">Cod Rendición</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" value="{{App\RendicionGastos::calcularCodigoCedepas($objNumeracion)}}" readonly>     
                            </div>
                            <div  class="colLabel" style="width: 15%">
                            <label for="moneda">Moneda</label>
                            </div>
                            <div class="col"> {{-- input de moneda viene de solicitud --}}
                                <input readonly  type="text" class="form-control" name="moneda" id="moneda" 
                                    readonly value="{{$solicitud->getMoneda()->nombre}}">     
                            </div>

                            <div class="w-100"></div> {{-- SALTO LINEA --}}
                            <div  class="colLabel">
                                    <label for="codSolicitud">Codigo Solicitud de Fondos</label>
                            </div>
                            <div class="col">
                                    <input value="{{$solicitud->codigoCedepas}}" type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                            </div>


                        </div>
                    </div>

                </div>

                
                
            </div>
        </div>
    </div>

        
        
        @include('SolicitudFondos.Plantillas.DesplegableDetallesSOF')  

        {{-- LISTADO DE DETALLES  --}}
         
        <div class="table-responsive">                           
            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                <thead >
                    <th></th>
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
                                class="btn btn-success" onclick="agregarDetalle()" >
                                <i class="fas fa-plus"></i>
                                    Agregar
                            </button>
                        </div>      
                    
                    </th>                                            
                    
                </thead>
                
                
                <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                    <th width="5%" class="text-center">#</th>          
                    <th width="10%" class="text-center">Fecha Cbte</th>                                        
                    <th width="13%">Tipo</th>                                 
                    <th width="10%"> N° Comprob</th>
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
                <input type="hidden" name="totalRendido" id="totalRendido">                              
                <input type="text" class="form-control text-right" name="total" id="total" readonly>   

            </div>   
            
            <div class="col-md-8">
            </div>   
            <div class="col">                        
                <label for="">Total Recibido: </label>    
            </div>   

            <div class="col">
                                            
                <input type="text" class="form-control text-right" name="totalRecibido" id="totalRecibido" readonly value="{{number_format($solicitud->totalSolicitado,2)}}">                              
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
            

        
        <div class="col">  
            <a href="{{route('RendicionGastos.Empleado.Listar')}}" class='btn btn-info'>
                <i class='fas fa-arrow-left'></i> 
                Regresar al Menú
            </a> 
            <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                onclick="registrar()"><i class='fas fa-save'></i> Registrar</button> 
               
             
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



       {{-- PARA EL FILE  --}}
<script type="application/javascript">

        var cont=0;
        var total=0;
        var detalleRend=[];
        var codPresupProyecto = "{{$solicitud->getProyecto()->codigoPresupuestal}}";


        $(document).ready(function(){
            
            document.getElementById('codigoPresupuestal').placeholder = codPresupProyecto + "...";
        });

        function registrar(){
            msje = validarFormCrear();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }
            
            confirmar('¿Estás seguro de crear la Rendición?','info','frmrend');
            
        }
        function cambiarEstilo(name, clase){
            document.getElementById(name).className = clase;
        }
        function limpiarEstilos(){
            cambiarEstilo('resumen','form-control');

        }

        var listaArchivos = '';
                    
        function validarFormCrear(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
            msj='';
            
            limpiarEstilos();
            if($('#resumen').val()=='' ){
                cambiarEstilo('resumen','form-control-undefined');
                msj='Debe ingresar la resumen';
            }else if($('#resumen').val().length>{{App\Configuracion::tamañoMaximoResumen}} ){
                cambiarEstilo('resumen','form-control-undefined');
                msj='La longitud de la resumen tiene que ser maximo de {{App\Configuracion::tamañoMaximoResumen}} caracteres';
            }
            
            if( $('#cantElementos').val()<=0 ){
                msj='Debe ingresar Items';
            }else if( $('#cantElementos').val()>{{App\Configuracion::valorMaximoNroItem}} ){
                msj='No se puede ingresar mas de {{App\Configuracion::valorMaximoNroItem}} Items';
            }

            if($('#nombresArchivos').val()=="" ) 
                msj='Debe subir los archivos comprobantes de pago.';
            

            return msj;
        }

    </script>
    @include('RendicionGastos.Empleado.PlantillasUsables.CrearEditarRendJS')









@endsection
