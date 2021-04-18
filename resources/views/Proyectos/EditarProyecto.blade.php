@extends('Layout.Plantilla')

@section('titulo')
    Editar proyecto
@endsection
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">

    <style>
        .cuadroCircularPlomo1{
            background-color: rgb(175, 175, 175);
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
            /* margin: 0.5%; */
        }

        .cuadroCircularPlomo2{
            background-color: rgba(230, 230, 230, 0.548);
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
            /* margin: 0.5%; */
        }
        .col{
            /* background-color: orange; */
            margin-top: 15px;
            padding-bottom: 5px;
            margin: 0.5%;
        }
        

    </style>

@endsection

@section('contenido')




<form id="frmUpdateInfoProyecto" name="frmUpdateInfoProyecto" role="form" action="{{route('GestiónProyectos.update')}}" 
    class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
    <input type="hidden" name="codProyecto" id="codProyecto" value="{{$proyecto->codProyecto}}">

    @csrf 

    
    @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
        <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times;</span>
        </button>
        
        </div>
    @endif


    <div class="well">
        <H3 style="text-align: center;">
            EDITAR PROYECTO
        </H3>
    </div>
    
    <br>
   
        <div class="row">
            
            

            <div class="col" style="">
              
                <div class="row">

                    <div class="col">
                        <label class="" style="">Nombre del Proyecto:</label>
                        <div class="">
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="{{$proyecto->nombre}}" placeholder="Nombre..." >
                        </div>

                    </div>
                    
                    


                    <div class="col">
                        
                        <label class="" style="">Codigo presupuestal:</label>
                        <input type="text" class="form-control" id="codigoPresupuestal" name="codigoPresupuestal"
                        value="{{$proyecto->codigoPresupuestal}}"  placeholder="..." >
                    </div>
                    

                    <div class="col">
                        <label class="" style="">Sede Principal:</label>
                        <div class="">
                            <select class="form-control" name="codSede" id="codSede">
                                <option value="-1">-- Seleccionar --</option>
                                @foreach($listaSedes as $itemsede)
                                <option value="{{$itemsede->codSede}}"
                                    @if($itemsede->codSede == $proyecto->codSedePrincipal)
                                        selected
                                    @endif
                                    >{{$itemsede->nombre}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-100"></div>

                    <div class="col">
                        <label class="" style="">Financiera:</label>
                        <div class="">
                            <select class="form-control" name="codEntidadFinanciera" id="codEntidadFinanciera">
                                <option value="-1">-- Seleccionar --</option>
                                @foreach($listaFinancieras as $itemFinanciera)
                                <option value="{{$itemFinanciera->codEntidadFinanciera}}"
                                    @if($itemFinanciera->codEntidadFinanciera == $proyecto->codEntidadFinanciera )
                                        selected
                                    @endif
                                    >{{$itemFinanciera->nombre}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="col">
                        <label for="">Fecha de Inicio: </label>
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  
                            style=" ">
                            <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio" 
                                    value="{{$proyecto->getFechaInicio()}}" style="text-align:center;">

                                    <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="col">
                        <label for="">Tipo financiamiento</label>
                        
                        <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" 
                            id="codTipoFinanciamiento" name="codTipoFinanciamiento" data-live-search="true">
                            <option value="-1">- Tipo Financiamiento -</option>          
                            @foreach($listaTipoFinanciamiento as $itemTipoFinanciamiento)
                                <option value="{{$itemTipoFinanciamiento->codTipoFinanciamiento}}" 
                                    {{$itemTipoFinanciamiento->codTipoFinanciamiento==$proyecto->codTipoFinanciamiento ? 'selected':''}}>
                                    {{$itemTipoFinanciamiento->nombre}}
                                </option>                                 
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="">Moneda del Proyecto</label>
                        <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" 
                            id="codMoneda" name="codMoneda" data-live-search="true">
                            <option value="-1">- Seleccione Moneda -</option>          
                            @foreach($listaMonedas as $itemMoneda)
                                <option value="{{$itemMoneda->codMoneda}}" 
                                    {{$itemMoneda->codMoneda==$proyecto->codMoneda ? 'selected':''}}>
                                    {{$itemMoneda->nombre}}
                                </option>                                 
                            @endforeach
                        </select>

                    </div>
                    <div class="w-100"></div>
                    

                    <div class="w-100"></div>
                    <div class="col">
                        <label class="" style="">Nombre Completo:</label>
                        <div class="">
                            <textarea class="form-control" name="nombreLargo" id="nombreLargo" cols="30" rows="2"
                            >{{$proyecto->nombreLargo}}</textarea>
                        </div>
                    </div>

                    <div class="col">
                        <label class="" style="">Objetivo General:</label>
                        <div class="">
                            <textarea class="form-control" name="objetivoGeneral" id="objetivoGeneral" cols="30" rows="2"
                            >{{$proyecto->objetivoGeneral}}</textarea>
                        </div>
                    </div>
                    

                    <div class="w-100"></div>
                    
                    

                    <div class="col cuadroCircularPlomo1">
                        <label for="">Presupuesto Total</label>
                        <input class="form-control" type="number" min="0" name="importePresupuestoTotal" id="importePresupuestoTotal"   value="{{$proyecto->importePresupuestoTotal}}">

                        
                    </div>
                    
                    <div class="col cuadroCircularPlomo2">
                        <label for="">Cptda Cedepas</label>
                        <input class="form-control" type="number" min="0" name="importeContrapartidaCedepas" id="importeContrapartidaCedepas"   value="{{$proyecto->importeContrapartidaCedepas}}">

                    </div>
                    
                    <div class="col cuadroCircularPlomo1">
                        <label for="">Cptda Pob. Beneficiaria</label>
                        <input class="form-control" type="number" min="0" name="importeContrapartidaPoblacionBeneficiaria" id="importeContrapartidaPoblacionBeneficiaria"  value="{{$proyecto->importeContrapartidaPoblacionBeneficiaria}}">

                    </div>
                    
                    <div class="col cuadroCircularPlomo2">
                        <label for="">Cptda Otros</label>
                        <input class="form-control" type="number" min="0" name="importeContrapartidaOtros" id="importeContrapartidaOtros" value="{{$proyecto->importeContrapartidaOtros}}">

                    </div>
                    
                        
                    <div class="w-100"></div>
                    
                        






                    <br>
                    <div class="col" style=" text-align:center">
                        <!--
                        <button class="btn btn-primary"  style="" onclick="validarregistro()"> 
                            <i class="far fa-save"></i>
                            Guardar
                        </button>
                        -->
                        
                        <button type="button" class="btn btn-primary float-right" style="margin-left: 6px" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando"
                            onclick="clickActualizar()">
                            <i class='fas fa-save'></i> 
                            Guardar
                        </button> 
                        
                        <a href="#" class='btn btn-danger float-right' onclick="confirmarEliminacion()"><i class="fas fa-trash-alt"></i> Dar de Baja</a>
    

                        <a href="{{route('GestiónProyectos.Listar')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>
                        
                    </div>

                </div>

            </div>
            


        </div>



</form>

    <div class="row">
        <div class="col">

            @include('Proyectos.Desplegables.LugaresEjecucion')
            <br>
            @include('Proyectos.Desplegables.PorcentajesObjetivos')
        </div>

        <div class="col">
            @include('Proyectos.Desplegables.PoblacionBeneficiaria')

            <br>
            
        </div>
        
    </div>

    <div class="row">
        <div class="col">

            @include('Proyectos.Desplegables.ObjetivoEspecifico')
            <br>
            @include('Proyectos.Desplegables.ResultadoEsperado')

        </div>
        

    </div>













@endsection


@section('script')  


     <script>
         
        const objNombre = document.getElementById('nombre');
        const objCodigoPresupuestal = document.getElementById('codigoPresupuestal');
        const objCodSede = document.getElementById('codSede');
        const objCodEntidadFinanciera = document.getElementById('codEntidadFinanciera');

        const objFechaInicio = document.getElementById('fechaInicio');
        const objCodTipoFinanciamiento = document.getElementById('codTipoFinanciamiento');
        const objCodMoneda = document.getElementById('codMoneda');
        const objNombreLargo = document.getElementById('nombreLargo');

        const objObjetivoGeneral = document.getElementById('objetivoGeneral');
        const objImportePresupuestoTotal = document.getElementById('importePresupuestoTotal');
        const objImporteContrapartidaCedepas = document.getElementById('importeContrapartidaCedepas');
        const objImporteContrapartidaPoblacionBeneficiaria = document.getElementById('importeContrapartidaPoblacionBeneficiaria');

        const objImporteContrapartidaOtros = document.getElementById('importeContrapartidaOtros');
        
        function clickActualizar(){
            msjError = validarActualizacion();
            if(msjError!="")
            {
                alerta(msjError);
                return;
            }

            confirmarConMensaje("Confirmacion","¿Desea actualizar la información del proyecto?","warning",submitearActualizacionInfoProyecto);
        }

        function submitearActualizacionInfoProyecto(){
            document.frmUpdateInfoProyecto.submit(); // enviamos el formulario	
        }

        function validarActualizacion(){
            msjError ="";

            if(objNombre.value=="")
                msjError="ingrese el nombre del proyecto";
            if(objCodigoPresupuestal.value=="")
                msjError="Ingrese un codigo presupuestal válido.";
            if(objCodSede.value=="-1")
                msjError="Ingrese una sede valida";
            if(objCodEntidadFinanciera.value=="-1")
                msjError="Ingrese una entidad financiera";

            if(objFechaInicio.value=="")
                msjError="Ingrese la fecha de inicio del proyecto.";
            if(objCodTipoFinanciamiento.value=="-1")
                msjError="Ingrese el tipo de financiamiento";
            if(objCodMoneda.value=="-1")
                msjError="Ingrese la moneda";
            if(objNombreLargo.value=="")
                msjError="Ingrese el nombre completo del proyecto";

            
            if(objObjetivoGeneral.value=="")
                msjError="Ingrese el objetivo general del proyecto";
            if(objImportePresupuestoTotal.value=="")
                msjError="Ingrese el presupuesto total del proyecto.";
            if(objImporteContrapartidaCedepas.value=="")
                msjError="Ingrese el  importe de contrapartida de cedepas.";
            if(objImporteContrapartidaPoblacionBeneficiaria.value=="")
                msjError="Ingrese el  importe de contrapartida de la poblacion beneficiaria.";
            if(objImporteContrapartidaOtros.value=="")
                msjError="Ingrese el importe de contrapartida otros.";

            return msjError;

        }
        function confirmarEliminacion(){
            swal(
            {//sweetalert
                title:'Dar de baja',
                text: '¿Está seguro de dar de baja el proyecto? Este no aparecerá más en las listas de proyectos activos.',     //mas texto
                //type: 'warning',  
                type: '',
                showCancelButton: true,//para que se muestre el boton de cancelar
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:  'SÍ',
                cancelButtonText:  'NO',
                closeOnConfirm:     true,//para mostrar el boton de confirmar
                html : true
            },
            function(){//se ejecuta cuando damos a aceptar
                window.location.href="{{route('GestiónProyectos.darDeBaja',$proyecto->codProyecto)}}";
            });
        }

    </script>
@endsection

