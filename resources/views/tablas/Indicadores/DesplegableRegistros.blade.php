{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoRegistro()" data-toggle="collapse" href="#collapseRegistros"  > 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Seguimiento de los indicadores
                </h4>
                <i id="iconoGiradorRegistro" class="fas fa-plus" style="float:right"></i>
            </div>

        </a>
        <div id="collapseRegistros" class="panel-collapse collapse card-body p-0">

            @if(App\Empleado::verificarPermiso('registro.CEE',$empresa->idEmpresa) )
                        
                <div class="row">
                    
                    <div class="col">
                        <form id="formAgregarRegistro" name="formAgregarRegistro" action="{{route('Indicadores.agregarEditarRegistro')}}" method="POST">
                            @csrf
                            <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idIndicador" value="{{$indicador->idIndicador}}">
                            <input type="{{App\Configuracion::getInputTextOHidden()}}" id="idRegistro" name="idRegistro" value="-1"> {{-- Este solo se activa al editar --}}
                            
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="">Valor del Indicador</label>
                                    <input type="number" class="form-control" name="valorNuevoRegistro" id="valorNuevoRegistro">
                                    
                                </div>
                                <div class="col">

                                    <label for="">Nombre del Periodo</label>
                                    <input class="form-control" name="nombrePeriodo" id="nombrePeriodo">

                                </div>
                            </div>
                            

                            <button type="button" onclick="clickAgregarRegistro()" class="btn btn-primary">
                                <i class="fas fa-plus">Guardar</i>
                            </button>
                        </form>

                    </div>
                    
    

                </div>
            @endif



            {{-- PARA VER LA SOLICITUD ENLAZADA --}}   
            <div class="table-responsive " style="margin: 5px">                           
                <table  id="tablaProcesos" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th  class="text-center">Periodo</th>                                        
                        <th  class="text-center">Valor</th>    
                        
                        <th> Opciones</th>
                    </thead>
                    <tbody>
                        @foreach($listaRegistros as $itemRegistro)
                            <tr class="selected">
                                <td  style="text-align:center;">               
                                    {{$itemRegistro->nombrePeriodo}}
                                </td>       
                                <td class="centrado " style="background-color: {{$itemRegistro->getColor()}}">
                                    {{$itemRegistro->valor}}
                                    
                                </td>
                                <td style="text-align: center;">
                                    @if(App\Empleado::verificarPermiso('registro.CEE',$empresa->idEmpresa) )
                
                                        <a href="#" class=" btn-primary" onclick="clickEliminarRegistro({{$itemRegistro->idRegistro}})">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                        <a href="#" class=" btn-primary" onclick="clickEditarRegistro({{$itemRegistro->idRegistro}})">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                
                                    @endif
                                </td>
                             
                                        
                            </tr>                
                        @endforeach    
                    </tbody>
                </table>
            </div> 

            

        </div>

    </div>    
</div>
{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<style>

    .centrado{
        text-align: center;
        font-size: 20pt;
    }

    #iconoGiradorRegistro {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorRegistro.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>

    listaRegistros = [];
   
    let giradoRegistro = true;
    function girarIconoRegistro(){
      const elemento = document.querySelector('#iconoGiradorRegistro');
      let nombreClase = elemento.className;
      if(giradoRegistro)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoRegistro = !giradoRegistro;
    }

    function generarVectorRegistros(){
        console.log("OLE");
        @foreach($listaRegistros as $itemRegistro)
            listaRegistros.push({
                idRegistro : "{{$itemRegistro->idRegistro}}",
                nombrePeriodo : "{{$itemRegistro->nombrePeriodo}}",
                valor: "{{$itemRegistro->valor}}"
            }); 

        @endforeach
        console.log(listaRegistros);
         

    }

    generarVectorRegistros();



    /* ------------------------------------ PROCESO ----------------------------------*/

    function clickAgregarRegistro(){
        msjError = validarAgregarRegistro();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }

        if(document.getElementById('idRegistro').value == "-1"){
            //nuevo registro
            mensaje = "agregar el nuevo indicador";
        }else{
            mensaje = "actualizar el indicador";
        }


        nombrePeriodo = document.getElementById('nombrePeriodo').value;
        confirmarConMensaje("Confirmación","¿Desea agregar el nuevo indicador "+nombrePeriodo+"?","warning",submitearAgregarRegistro);

    }    

    function validarAgregarRegistro(){
        valorNuevoRegistro = document.getElementById('valorNuevoRegistro').value;
        nombrePeriodo = document.getElementById('nombrePeriodo').value;
        
        msjError = "";
        if(valorNuevoRegistro==""){
            msjError="Debe ingresar valor para el indicador.";
        }
        
        if(nombrePeriodo==""){
            msjError="Debe ingresar un nombre del periodo para el indicador";

        }
        return msjError;

    }

    function submitearAgregarRegistro(){
        document.formAgregarRegistro.submit();
    }

    registroAEliminar="";
    function clickEliminarRegistro(idRegistro){
        registroAEliminar = idRegistro;
        confirmarConMensaje("Confirmación","¿Desea eliminar el registro?","warning",ejecutarEliminacionRegistro);

    }

    function ejecutarEliminacionRegistro(){
        location.href="/Indicadores/eliminarRegistro/" + registroAEliminar;
    }



    function clickEditarRegistro(idRegistroSeleccionado){
        
        registro = listaRegistros.find(elemento => elemento.idRegistro == idRegistroSeleccionado);

        console.log(registro);

        document.getElementById('valorNuevoRegistro').value = registro.valor;
        document.getElementById('nombrePeriodo').value = registro.nombrePeriodo;
        document.getElementById('idRegistro').value = registro.idRegistro;


    }


    
    




</script>
