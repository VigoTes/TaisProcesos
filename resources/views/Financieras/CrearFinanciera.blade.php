@extends('Layout.Plantilla')

@section('titulo')
    Crear Financiera
@endsection
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    

<form id="frmempresa" name="frmempresa" role="form" action="{{route('EntidadFinanciera.guardar')}}" 
class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">

@csrf 


<div class="well"><H3 style="text-align: center;">Registrar nueva Entidad Financiera</H3></div>
<br>
<div class="container">
    <div class="row">
        <div class="col-2" style="">
            
        
        </div>
        

        <div class="col" style="">
            <div class="container">
                <div class="row">

                    <div class="col">

                        
                        <label class="" style="">Nombre:</label>
                        
                        
                        <div class="">
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="" placeholder="Nombre..." >
                        </div>
                    </div>
                    
                    <div class="w-100"></div>
                    <br>
                    <div class="col" style=" text-align:center">
                        
                        <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" onclick="swal({//sweetalert
                            title:'¿Seguro de crear la entidad financiera?',
                            text: '',     //mas texto
                            type: 'info',//e=[success,error,warning,info]
                            showCancelButton: true,//para que se muestre el boton de cancelar
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText:  'SÍ',
                            cancelButtonText:  'NO',
                            closeOnConfirm:     true,//para mostrar el boton de confirmar
                            html : true
                        },
                        function(){//se ejecuta cuando damos a aceptar
                            validarregistro();
                        });">
                        <i class='fas fa-save'></i> 
                        Registrar</button> 
                        
                        <a href="{{route('EntidadFinanciera.listar')}}" class='btn btn-info float-left'>
                            <i class="fas fa-arrow-left"></i> 
                            Regresar al Menu
                        </a>
    
                    </div>

                </div>

            </div>
               
        </div>
        <div class="col-2" >
         
        
        </div>


    </div>


</div>

</form>


<script type="text/javascript"> 
          
    function validarregistro() 
        {


            if (document.getElementById("nombre").value == ""){
                alerta("Ingrese el nombre del proyecto");
                $("#nombre").focus();
            }

            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>
@endsection