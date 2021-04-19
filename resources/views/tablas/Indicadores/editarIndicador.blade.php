@extends('Layout.Plantilla')
@section('contenido')


<form id="formCrearIndicador" name="formCrearIndicador"  method = "POST" action = "{{route('Indicadores.update')}}"  >
    @csrf   
    
  <div class="form-group">
    <h1>Editar indicador para {{$indicador->getCompletarNombre()}}
        
    </h1>
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
            
            <div class="w-100"></div>
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                
                  

                <br>
                    
                <div style=         "float: right;">    

                    <button type="button" onclick="clickGrabar()" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Grabar
                    </button>
                    <a href = "{{$indicador->volverAlListar()}}" class = "btn btn-danger">
                        <i class="fas fa-ban"></i>
                        Cancelar
                    </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection
@section('script')
<script>


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

</script>


@endsection