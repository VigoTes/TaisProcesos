{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoLugaresEjecucion()" data-toggle="collapse" href="#collapseLugEjec" style=""> 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Lugares de Ejecución del Proyecto
                </h4>
                <i id="iconoGiradorItemsLugEjec" class="fas fa-plus" style="float:right"></i>
            </div>
        </a>
        <div id="collapseLugEjec" class="panel-collapse collapse card-body p-0">

            <form action="{{route('GestionProyectos.agregarLugarEjecucion')}}" method="POST">
                @csrf
                <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                <div class="row">
                    <div class="col-sm">

                        <select class="form-control select2 select2-hidden-accessible selectpicker" onchange="clickSelectDepartamento()" 
                              data-select2-id="" tabindex="-1" aria-hidden="true" 
                                id="ComboBoxDepartamento" name="ComboBoxDepartamento" data-live-search="true">
                            <option value="0">
                            - Departamento -
                            </option>          
                            
                            @foreach($listaDepartamentos as $itemDepartamento)
                            <option value="{{$itemDepartamento->codDepartamento}}">
                                {{$itemDepartamento->nombre}}
                            </option>                                 
                            @endforeach
                        </select> 

                    </div>
                    <div class="col-sm">

                        <select class="form-control"  id="ComboBoxProvincia" name="ComboBoxProvincia" onchange="clickSelectProvincia()" >
                            <option value="-1">-- Provincia -- </option>
                            
                        </select>  

                    </div>
                    <div class="col-sm">
                        
                        <select class="form-control"  id="ComboBoxDistrito" name="ComboBoxDistrito" onchange="" >
                            <option value="-1">-- Distrito -- </option>
                            
                        </select>  

                    </div>
                    
                    <div class="col-sm-2" style="">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                        </button>
                        
                    </div>
                    
                </div>



                
        
            </form>






            {{-- PARA VER LA SOLICITUD ENLAZADA --}}   
            <div class="table-responsive " style="margin: 5px">                           
                <table  id="tablaDetallesLugares" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th  class="text-center">Departamento</th>                                        
                        <th >Provincia</th>                                 
                        <th >Distrito</th>
                        <th> Opc</th>
                  
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                    --}}
                    </thead>
                    <tbody>
                        @foreach($lugaresEjecucion as $itemLugarEjecucion)
                            <tr class="selected">
                                <td  style="text-align:center;">               
                                    {{$itemLugarEjecucion->getDepartamento()->nombre}}
                                </td>       
                                <td  style="text-align:center;"> 
                                    {{$itemLugarEjecucion->getProvincia()->nombre}}
                                </td>               
                                           
                                <td style="text-align:center;">               
                                    {{$itemLugarEjecucion->getDistrito()->nombre}} 
                                </td>     
                                <td style="text-align: center;">

                                        <a href="#" onclick="confirmarEliminarLugarEjecucion({{$itemLugarEjecucion->codLugarEjecucion}})">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        

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
    #iconoGiradorItemsLugEjec {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorItemsLugEjec.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>
    let giradoItemsLugEjec = true;
    function girarIconoLugaresEjecucion(){
      const elemento = document.querySelector('#iconoGiradorItemsLugEjec');
      let nombreClase = elemento.className;
      if(giradoItemsLugEjec)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoItemsLugEjec = !giradoItemsLugEjec;
    }





    function clickSelectDepartamento(){
        departamento = document.getElementById('ComboBoxDepartamento');
        ComboBoxProvincia =  document.getElementById('ComboBoxProvincia');
        ComboBoxDistrito =  document.getElementById('ComboBoxDistrito'); 
        console.log('el codigo del dep seleccionado es ='+departamento.value);

        $.get('/listarProvinciasDeDepartamento/'+departamento.value, 
            function(data)
            {   
                
                cadenaHTML = `
                    <option value="0" selected>
                        - Provincia -
                    </option> 
                `;
                for (let index = 0; index < data.length; index++) {
                    const element = data[index];
                     
                    cadenaHTML = cadenaHTML + 
                    `
                    <option value="`+element.codProvincia+`">
                        `+ element.nombre +`
                    </option>   
                    `;
                }
                ComboBoxProvincia.innerHTML = cadenaHTML;    
                ComboBoxDistrito.innerHTML =
                `
                    <option value="0" selected>
                        - Distrito -
                    </option> 
                `;
            }
        );

    }


    function clickSelectProvincia(){
        ComboBoxProvincia = document.getElementById('ComboBoxProvincia');
        ComboBoxDistrito =  document.getElementById('ComboBoxDistrito'); 
        console.log('el codigo de provincia seleccionada es ='+ComboBoxProvincia.value);
        
        $.get('/listarDistritosDeProvincia/'+ComboBoxProvincia.value, 
            function(data)
            {   
               
                cadenaHTML = `
                    <option value="0" selected>
                        - Distrito -
                    </option> 
                `;
                for (let index = 0; index < data.length; index++) {
                    const element = data[index];
                     
                    cadenaHTML = cadenaHTML + 
                    `
                    <option value="`+element.codDistrito+`">
                        `+ element.nombre +`
                    </option>   
                    `;
                }
                ComboBoxDistrito.innerHTML = cadenaHTML;                
            }
        );

    }

    codLugarEjecucionAEliminar = "0";
    function confirmarEliminarLugarEjecucion(codLugarEjecucion){
        console.log('Se eliminará el ' + codLugarEjecucion);
        codLugarEjecucionAEliminar = codLugarEjecucion;
        confirmarConMensaje("Confirmación","¿Seguro de eliminar este lugar de ejecución?","warning",ejecutarEliminacionLugarEjecucion);

    }

    function ejecutarEliminacionLugarEjecucion(){

        location.href = "/GestionProyectos/eliminarLugarEjecucion/" + codLugarEjecucionAEliminar;

    }

</script>
