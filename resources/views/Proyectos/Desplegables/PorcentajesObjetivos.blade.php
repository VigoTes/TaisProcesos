{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoPorcentajesObjetivos()" data-toggle="collapse" href="#collapsePorcentajesObj" style=""> 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    % Objetivos Estratégicos de Cedepas 
                </h4>
                <i id="iconoGiradorPorcentajesObjetivos" class="fas fa-plus" style="float:right"></i>
            </div>
        </a>
        <div id="collapsePorcentajesObj" class="panel-collapse collapse card-body p-0"  style="margin-top: 5px">

            <form action="{{route('GestionProyectos.actualizarPEI')}}" id="formPEI" name="formPEI" method="POST">
                @csrf
                <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                <div class="row">
                    <div class="col-sm text-center">
                        <label for="">PEI del proyecto:</label>
                        

                    </div>
                    <div class="col-sm">
                        <select class="form-control" name="codPEI" id="codPEI">
                            <option value="-1">-- Seleccionar --</option>
                            @foreach($listaPEIs as $itemPEI)
                            <option value="{{$itemPEI->codPEI}}"
                                @if($itemPEI->codPEI == $proyecto->codPEI)
                                    selected
                                @endif
                                >{{$itemPEI->getPeriodo()}}</option>    
                            @endforeach
                        </select>
                        
                    </div>
                    
                    
                    <div class="col-sm" style="">

                        <button type="button" onclick="clickCambiarPEI()" class="btn btn-primary">
                            Cambiar PEI
                        </button>
                        
                    </div>
                    
                </div>



                
        
            </form>


            <form action="{{route('GestionProyectos.actualizarPorcentajesObjetivos')}}" id="formPorcentajesObjetivos" name="formPorcentajesObjetivos" method="post">
                @csrf

                <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">

                <div class="table-responsive " style="margin: 5px">                           
                    <table  id="tablaDetallesLugares" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                        <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                            <th> Item</th>
                            <th  class="text-center">Obj Estr</th>                                        
                            <th  class="text-center">%</th>                                        
                            
                            
                        </thead>
                        <tbody>
                            @foreach($listaPorcentajes as $itemPorcentajeObj)
                                <tr class="selected">
                                    <td>
                                        {{$itemPorcentajeObj->getObjetivoEstrategico()->item}}
                                        
                                    </td>
                                    
                                    <td  style="text-align:center;">               
                                        {{$itemPorcentajeObj->getObjetivoEstrategico()->nombre}}
                                    </td>       
                                    <td  style="text-align:right;"> 
                                        
                                        <input class="form-control" step="0.01"  type="number" name="porcentaje{{$itemPorcentajeObj->codRelacion}}"
                                        style="width: 80px; text-align:center" value="{{$itemPorcentajeObj->porcentajeDeAporte}}" 
                                        min="0" max="100">
                                        
                                    </td>               
                                    
                                            
                                </tr>                
                            @endforeach    
                        </tbody>
                    </table>
                    
                    <button type="button" onclick="clickGuardarPorcentajes()" class="btn btn-primary">
                        Guardar Nuevos Porcentajes
                    </button>
                </div> 

            </form>


        </div>


    


    </div>    
</div>
{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<style>
    #iconoGiradorPorcentajesObjetivos {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorPorcentajesObjetivos.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>
    let giradoPorcentajesObjetivos = true;
    function girarIconoPorcentajesObjetivos(){
      const elemento = document.querySelector('#iconoGiradorPorcentajesObjetivos');
      let nombreClase = elemento.className;
      if(giradoPorcentajesObjetivos)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoPorcentajesObjetivos = !giradoPorcentajesObjetivos;
    }


    function clickCambiarPEI(){
        const SelectorPEI = document.getElementById('codPEI');
        if(SelectorPEI.value == "-1")
        {
            alert('Debe seleccionar un PEI');
            return;

        }


        confirmarConMensaje("Confirmación","¿Desea actualizar el PEI del Proyecto?","warning",submitearActualizacionPEI);
       

    }

    function submitearActualizacionPEI(){
        document.formPEI.submit();


    }


    function clickGuardarPorcentajes(){

        confirmarConMensaje("Confirmación","¿Desea actualizar los porcentajes de los objetivos estratégicos?","warning",submitearActualizacionPorcentajes);
       


    }


    function submitearActualizacionPorcentajes(){

        document.formPorcentajesObjetivos.submit();


    }
</script>
