@extends('Layout.Plantilla')

@section('titulo')
    Editar Plan Estratégico
@endsection
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    


<form id="frmPEI" name="frmPEI" action="{{route('PlanEstrategico.actualizar')}}" method="post" >

    @csrf 


    <div class="well">
        <H3 style="text-align: center;">
            Actualizar Plan estratégico
        </H3>
    </div>
    <br>

    <div class="row">
        

        <div class="col" style="">
            <div class="container">
                <div class="row">


                    <div class="col">
                        <label class="" style="">Código:</label>
                        <div class="">
                            <input type="text" class="form-control" id="codPEI" name="codPEI"
                            value="{{$PEI->codPEI}}"  placeholder="..." readonly>
                        </div>
                    </div>

                    
                    <div class="col">

                        
                        <label class="" style="">Año Inicio:</label>
                        
                        
                        <div class="">
                            <input type="number" class="form-control" id="añoInicio" name="añoInicio" 
                                value="{{$PEI->añoInicio}}" placeholder="Ingrese año..." >
                        </div>

                        
                        

                    </div>
                    
                    <div class="col">
                        <label class="" style="">Año Final:</label>
                        
                        <input type="number" class="form-control" id="añoFin" name="añoFin" 
                            value="{{$PEI->añoFin}}" placeholder="Ingrese año..." >
                    </div>
                    <div class="w-100" style="margin-bottom: 5px"></div>
                    
                    














                    <div class="col">
                        <table class="table table-bordered table-hover datatable" id="detalles">
                            <thead >
                                 
                                                                           
                                <th colspan="2">

                                    <label for="nuevoNombre">Nombre del Obj</label>
                                    <input type="text" class="form-control" id="nuevoNombre" name="nuevoNombre" value="">
                                </th>
                                <th class="">
                                    <label for="nuevaDescripcion">Descripcion</label>
                                    <textarea class="form-control" name="nuevaDescripcion" id="nuevaDescripcion" cols="30" rows="2"
                                    ></textarea>
                                </th> 
                                <th class="text-center">
                                    <div>
                                        <button type="button" id="btnadddet" name="btnadddet" 
                                            class="btn btn-success" onclick="agregarDetalle()" >
                                            <i class="fas fa-plus"></i>
                                             Agregar
                                        </button>
                                    </div>      
                                </th>
                            </thead>
                            
                            
                            <thead>                  
                                <tr>
                                    <th width="8%" >#</th>
                                    <th width="15%">Nombre</th>
                                    <th>Objetivo Estratégico</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                        
                        
                        </table>
                    
                    
                    </div>
                
                    <div class="w-100" style="margin-bottom: 5px"></div>
                    
                    <div class="col" style=" text-align:center">
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="cantElementos" id="cantElementos" value="0">
                    
                        <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                            onclick="clickActualizar()">
                            <i class='fas fa-save'></i> 

                            Guardar
                        </button> 
                        
                        <a href="{{route('PlanEstrategico.listar')}}" class='btn btn-info float-left'>
                            <i class="fas fa-arrow-left"></i> 
                            Regresar al Menu
                        </a>
    
                    </div>

                </div>

            </div>
            
        </div>
        


    </div>



</form>
@endsection

@section('script')

<script type="text/javascript"> 
        
    var detalleObj=[];
    $(window).load(function(){

        //cuando apenas carga la pagina, se debe copiar el contenido de la tabla a detalleSol
        cargarDetallesObj();
        $(".loader").fadeOut("slow");
    });


    function cargarDetallesObj(){
            
            //obtenemos los detalles de una ruta GET 
            $.get('/listarObjetivosDePEI/'+{{$PEI->codPEI}}, function(data)
            {      
                    listaDetalles = data;
                    for (let index = 0; index < listaDetalles.length; index++) {
                        console.log('Cargando detalle de solicitud:'+index);
                        
                        detalleObj.push({
                            
                            item:               listaDetalles[index].item,
                            nombre:             listaDetalles[index].nombre,
                            descripcion:           listaDetalles[index].descripcion,
                        });   
                    }
                    actualizarTabla();                

            });
        }

    function clickActualizar(){
        msjError = validarActualizacion();;
        if(msjError!=""){
            alerta(msjError);
            return;
        }
        
       
        confirmarConMensaje('Confirmación','¿Desea actualizar el plan estratégico y sus objetivos?','warning',submitear);
       
    }

    function submitear(){
        document.frmPEI.submit(); // enviamos el formulario	

    }

    function validarActualizacion() 
    {

        msj="";
        if (document.getElementById("añoInicio").value == ""){
            msj = ("Ingrese el año inicial del PEI");
            
        }
        if (document.getElementById("añoFin").value == ""){
            msj = ("Ingrese el año Final del PEI");
            
        }

        return msj;
    }
    
    

</script>
@include('PlanesEstrategicos.ObjetivosEstrategicos.CrearEditarOE-JS')


@endsection