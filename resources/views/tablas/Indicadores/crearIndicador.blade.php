@extends('Layout.Plantilla')

@section('titulo')
  Crear Indicador
@endsection


@section('contenido')


<form id="formCrearIndicador" name="formCrearIndicador"  method = "POST" action = "{{route('Indicadores.store')}}"  >
    @csrf   

  <div class="form-group">
    <h3>Crear indicador para 
        @if($proceso!="")
            el proceso {{$proceso->nombre}}
        @else 
            el subproceso {{$subproceso->nombre}}
        @endif
    </h3>
   <div class="container">  {{-- Container  --}}
        <div class="row">
            


            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="nombre">Nombre del Indicador</label>
                <input type="text" class="form-control"
                    id="nombre" name="nombre" placeHolder="Ingrese el nombre del indicador">

                <label for="P_QueMedira">Qué se medirá</label>
                <div class="input-group">
                    <textarea class="form-control "
                        style = "resize: none;"  id="P_QueMedira" name="P_QueMedira"  ></textarea>                
                </div>
    
                <br>
                <label for="P_Mecanismos">Mecanismos para la medición</label>
                <div class="input-group">
                    <textarea class="form-control "
                        style = "resize: none;"  id="P_Mecanismos" name="P_Mecanismos"  ></textarea>                
                </div>


               

                <br>
             
                <label for="P_QueSeHara">Qué se hará con la medición</label>
                <div class="input-group">
                    <textarea class="form-control "
                        style = "resize: none;"  id="P_QueSeHara" name="P_QueSeHara"  ></textarea>                
                </div>
            
                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="col">
                {{-- CONTENIDO COLUMNA --}}
                <label for="P_QuienMedira">Quién Medirá</label>
                <input type="text" class="form-control" id="P_QuienMedira" name="P_QuienMedira" 
                    placeHolder="">

            
                
                <br>
                <label for="P_Tolerancia">Tolerancia</label>
                <div class="input-group">
                    <textarea class="form-control" style = "resize: none;"  id="P_Tolerancia" name="P_Tolerancia"  ></textarea>                
                </div>


                <br>
                <label for="formula">Formula para el indicador</label>
                <div class="input-group">
                    <textarea class="form-control "
                         style = "resize: none;" id="formula" name="formula"></textarea>
                 
                </div>



                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="w-100"></div>

            <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idProceso" id="idProceso" value="{{$idProceso}}">
            <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idSubproceso" id="idSubproceso" value="{{$idSubproceso}}">
            <input type="{{App\Configuracion::getInputTextOHidden()}}" name="sentidoDelSemaforo" id="sentidoDelSemaforo" value="0">

            

            <div class="w-100"></div>


            
        </div>

        
        <div class="col">
            <div class="row">
                <div class="col">
                    
                    <label for="nombre">Frecuencia de Medición</label>
                    <input type="number" class="form-control"
                        id="frecuenciaDeMedicion" name="frecuenciaDeMedicion">
                    
                </div>
                   
                <div class="col">
                    <label for="unidadDeFrecuencia">Unidad de frecuencia</label>
                    <select class="form-control" name="unidadDeFrecuencia" id="unidadDeFrecuencia">
                        <option value="Día">Día</option>
                        <option value="Mes">Mes</option>
                        <option value="Año">Año</option>
                        <option value="Año">Proyecto</option>
                            
                    </select>
                </div>

               
                <div class="col">
                    <label for="lineaBase">Linea Base</label>
                    <input type="number" class="form-control"
                        id="lineaBase" name="lineaBase">
                    
                </div>
                <div class="col">
                    <label for="unidadDeMedida">Unidad de Medida</label>
                    <input type="text" class="form-control"
                        id="unidadDeMedida" name="unidadDeMedida">


                </div>
                <div class="w-100"></div>
                <br>
                <div id="cuadradoIzquierda" class="col pintadoVerde"></div>
                <div class="col">
                        
                    <label for="limite1">Limite Inferior</label>
                    <input type="number" class="form-control" step="0.1"
                        id="limite1" name="limite1">
                </div>

                
                <div class="col pintadoAmarillo"></div>
                
                <div class="col">

                    <label for="limite2">Limite superior</label>
                    <input type="number" class="form-control" step="0.1"
                        id="limite2" name="limite2">
    
                </div>
                <div id="cuadradoDerecha" class="col pintadoRojo"></div>
                <div class="col-2">
                    <button class="btn btn-success" type="button" onclick="cambiarSentido()">
                        Cambiar Sentido del Semáforo
                    </button>

                </div>
                <div class="col"></div>
                <div class="col"></div>
                
                <div class="w-100"></div>
                
            </div>
        </div>

        <div class="col" > 
            {{-- CONTENIDO COLUMNA --}}
           
               <button type="button" onclick="clickGrabar()" class="btn btn-primary">
                   <i class="fas fa-save"></i>
                   Grabar
               </button>
               <a href = "{{$rutaVolverAListar}}" class = "btn btn-danger">
                   <i class="fas fa-ban"></i>
                   Cancelar
               </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
           

            {{-- FIN CONTENIDO COLUMNA--}}
       </div>

    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection
@section('estilos')
<style>
    .fondoPaVer{

        background-color: rgb(131, 180, 85);
    }
    .pintadoVerde{
        background-color: rgb(4, 219, 4);
        border-radius: 100%;
    }
    .pintadoRojo{
        background-color: rgb(255, 0, 0);
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

    sentidoDeSemaforo = 0;

    function clickGrabar(){
        msjError=validarForm();
        if(msjError!=""){
            alerta(msjError);
            return;
        }

        confirmarConMensaje("Confirmación",'¿Desea crear este nuevo indicador?',"warning",ejecutarSubmiteo);


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
        
        return msjError;


    }


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


</script>


@endsection