@extends('Layout.Plantilla')

@section('titulo')
  Editar Indicador {{$indicador->nombre}}
@endsection


@section('contenido')
@if (session('datos'))
    <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
        {{session('datos')}}
        <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times;</span>
        </button>
        
    </div>
@endif

   <div class="form-group">
        <h3>Editar indicador {{$indicador->nombre}} para {{$indicador->getCompletarNombre()}}
            
        </h3>




        <form id="formCrearIndicador" name="formCrearIndicador"  method = "POST" action = "{{route('Indicadores.update')}}"  >
            @csrf   
            
            
            <div class="container">  {{-- Container  --}}
                <div class="row">
                    


                    <div class="col">
                        {{-- CONTENIDO DE LA COLUMNA --}}
                        <label for="nombre">Nombre del Indicador</label>
                        <input type="text" class="form-control"
                            id="nombre" name="nombre" placeHolder="Ingrese el nombre del indicador" value="{{$indicador->nombre}}">

                        <label for="P_QueMedira">Qué se medirá</label>
                        <div class="input-group">
                            <textarea class="form-control "
                                style = "resize: none;"  id="P_QueMedira" name="P_QueMedira"  >{{$indicador->P_QueMedira}}</textarea>                
                        </div>
            
                        <br>
                        <label for="P_Mecanismos">Mecanismos para la medición</label>
                        <div class="input-group">
                            <textarea class="form-control "
                                style = "resize: none;"  id="P_Mecanismos" name="P_Mecanismos"  >{{$indicador->P_Mecanismos}}</textarea>                
                        </div>


                    

                        <br>
                    
                        <label for="P_QueSeHara">Qué se hará con la medición</label>
                        <div class="input-group">
                            <textarea class="form-control "
                                style = "resize: none;"  id="P_QueSeHara" name="P_QueSeHara"  >{{$indicador->P_QueSeHara}}</textarea>                
                        </div>
                    
                        {{-- FIN CONTENIDO COLUMNA --}}
                    </div>
                    <div class="col">
                        {{-- CONTENIDO COLUMNA --}}
                        <label for="P_QuienMedira">Quién Medirá</label>
                        <input type="text" class="form-control" id="P_QuienMedira" name="P_QuienMedira"   value="{{$indicador->P_QuienMedira}}"
                            placeHolder="">

                    
                        
                        <br>
                        <label for="P_Tolerancia">Tolerancia</label>
                        <div class="input-group">
                            <textarea class="form-control" style = "resize: none;"  id="P_Tolerancia" name="P_Tolerancia"  
                            >{{$indicador->P_Tolerancia}}</textarea>                
                        </div>


                        <br>
                        <label for="formula">Formula para el indicador</label>
                        <div class="input-group">
                            <textarea class="form-control "
                                style = "resize: none;" id="formula" name="formula">{{$indicador->formula}}</textarea>
                        
                        </div>



                        {{-- FIN CONTENIDO COLUMNA --}}
                    </div>
                    <div class="w-100"></div>

                    <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idIndicador" id="idIndicador" value="{{$indicador->idIndicador}}">
                    <input type="{{App\Configuracion::getInputTextOHidden()}}" name="sentidoDelSemaforo" id="sentidoDelSemaforo" value="{{$indicador->sentidoDeSemaforo}}">

                    <div class="w-100"></div>



                </div>


                <div class="col">
                    <div class="row">
                        <div class="col">
                            
                            <label for="nombre">Frecuencia de Medición</label>
                            <input type="number" class="form-control" value="{{$indicador->frecuenciaDeMedicion}}"
                                id="frecuenciaDeMedicion" name="frecuenciaDeMedicion" value="0">
                            
                        </div>
                        
                        <div class="col">
                            <label for="unidadDeFrecuencia">Unidad de frecuencia</label>
                            <select class="form-control" name="unidadDeFrecuencia" id="unidadDeFrecuencia" 
                            value="{{$indicador->unidadDeFrecuencia}}"
                            >
                                <option value="Día">Día</option>
                                <option value="Mes">Mes</option>
                                <option value="Año">Año</option>
                                <option value="Año">Proyecto</option>
                                
                            </select>
                        </div>

                    
                        <div class="col">
                            <label for="lineaBase">Linea Base</label>
                            <input type="number" class="form-control"  value="{{$indicador->lineaBase}}"
                                id="lineaBase" name="lineaBase">
                            
                        </div>
                        <div class="col">
                            <label for="unidadDeMedida">Unidad de Medida</label>
                            <input type="text" class="form-control"  value="{{$indicador->unidadDeMedida}}"
                                id="unidadDeMedida" name="unidadDeMedida">


                        </div>
                        <div class="w-100"></div>
                        <br>
                        <div id="cuadradoIzquierda" class="col"></div>
                        <div class="col">
                                
                            <label for="limite1">Lim Inf</label>
                            <input type="number" class="form-control" step="0.1"  value="{{$indicador->limite1}}"
                                id="limite1" name="limite1">
                        </div>

                        
                        <div class="col pintadoAmarillo"></div>
                        
                        <div class="col">

                            <label for="limite2">Lim Sup</label>
                            <input type="number" class="form-control" step="0.1"  value="{{$indicador->limite2}}"
                                id="limite2" name="limite2">
            
                        </div>
                        <div id="cuadradoDerecha" class="col"></div>
                        <div class="col-2">
                            @if(App\Empleado::verificarPermiso('indicador.CEE',$empresa->idEmpresa) )
                     
                            <button class="btn btn-success" type="button" onclick="cambiarSentido()">
                                Cambiar Sentido del Semáforo
                            </button>
                            @endif
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                        
                        <div class="w-100"></div>
                        
                    </div>
                </div>

                <div class="col"> 
                    {{-- CONTENIDO COLUMNA --}}
                    <br>
                    @if(App\Empleado::verificarPermiso('indicador.CEE',$empresa->idEmpresa) )
                            
                        <button type="button" onclick="clickGrabar()" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Grabar
                        </button>
                    @endif
                    
                    <a href = "{{$indicador->volverAlListar()}}" class = "btn btn-danger">
                        <i class="fas fa-ban"></i>
                        Cancelar
                    </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                

                    {{-- FIN CONTENIDO COLUMNA--}}
                </div>


            


            </div>
        </form> {{-- FORM GRUP --}}

        <div class="fondoPaVer">
                
            @include('tablas.Indicadores.DesplegableRegistros')

        </div>
    </div>




@endsection
@section('estilos')
<style>
      .fondoPaVer{

    background-color: rgb(131, 180, 85);
    }
    .pintadoVerde{
        background-color: green;
        border-radius: 100%;
    }
    .pintadoRojo{
        background-color: red;
        border-radius: 100%;
    }

    .pintadoAmarillo{
        background-color: yellow;
        border-radius: 100%;
    }
    
</style>
@endsection
@section('script')
<script>


    sentidoDeSemaforo = 1-{{$indicador->sentidoDeSemaforo}};

    function cambiarSentido(){
        const elementoIzquierda = document.getElementById('cuadradoIzquierda');
        const elementoDerecha = document.getElementById('cuadradoDerecha');
        
        if(sentidoDeSemaforo==1){
            elementoIzquierda.classList= 'pintadoVerde col';
            elementoDerecha.classList = "pintadoRojo col";
            sentidoDeSemaforo=0;
        }else{
            elementoIzquierda.classList= 'pintadoRojo col';
            elementoDerecha.classList = "pintadoVerde col";
            sentidoDeSemaforo=1;

        }

        console.log('Sentido del semaforo: '+ sentidoDeSemaforo);
       document.getElementById('sentidoDelSemaforo').value = sentidoDeSemaforo;
    }

    cambiarSentido();


    function clickGrabar(){
        msjError=validarForm();
        if(msjError!=""){
            alerta(msjError);
            return;
        }

        confirmarConMensaje("Confirmación",'¿Desea actualizar este indicador?',"warning",ejecutarSubmiteo);


    }

    function ejecutarSubmiteo(){

        document.formCrearIndicador.submit();

    }
    function validarForm(){
        msjError = "";

        nombre = document.getElementById('nombre').value;  
        P_Mecanismos = document.getElementById('P_Mecanismos').value;  
        P_QueSeHara = document.getElementById('P_QueSeHara').value;  
        P_QueMedira = document.getElementById('P_QueMedira').value;  
    
        
        P_QuienMedira = document.getElementById('P_QuienMedira').value;  
        P_Tolerancia = document.getElementById('P_Tolerancia').value;  
        formula = document.getElementById('formula').value;  
             

        frecuenciaDeMedicion = document.getElementById('frecuenciaDeMedicion').value;  
        unidadDeFrecuencia = document.getElementById('unidadDeFrecuencia').value;  
        lineaBase = document.getElementById('lineaBase').value;  
        unidadDeMedida = document.getElementById('unidadDeMedida').value;  
        limite1 = document.getElementById('limite1').value;  
        limite2 = document.getElementById('limite2').value;  
          

        msjError="";
        if(nombre=="")
            msjError="Debe ingresar un nombre válido para el indicador.";
        if(P_Mecanismos=="")
            msjError="Debe ingresar qué mecanismo de medicion se usará";
        if(P_QueSeHara=="")
            msjError="Debe ingresar qué se hará con la medición";
        if(P_QueMedira=="")
            msjError="Debe ingresar qué se medirá";

        if(P_QuienMedira=="")
            msjError="Debe ingresar quién medirá el indicador";
        if(P_Tolerancia=="")
            msjError="Debe ingresar una tolerancia";
        if(formula=="")
            msjError="Debe ingresar una formula";
        

        if(frecuenciaDeMedicion=="")
            msjError="Debe ingresar una frecuenciaDeMedicion";
        if(unidadDeFrecuencia=="")
            msjError="Debe ingresar una unidadDeFrecuencia";
        if(lineaBase=="")
            msjError="Debe ingresar una lineaBase";
        if(unidadDeMedida=="")
            msjError="Debe ingresar una unidadDeMedida";
        if(limite1=="")
            msjError="Debe ingresar un limite inferior";
        if(limite2=="")
            msjError="Debe ingresar un limite superior";
        
        if( parseInt(limite1) >= parseInt(limite2) )
            msjError = "El limite inferior debe ser menor al superior.";

        return msjError;


    }

</script>


@endsection