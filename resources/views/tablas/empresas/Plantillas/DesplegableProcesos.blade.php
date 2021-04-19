{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoProceso()" data-toggle="collapse" href="#collapseProcesos"  > 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Lista de Procesos y subprocesos
                </h4>
                <i id="iconoGiradorProcesos" class="fas fa-plus" style="float:right"></i>
            </div>

        </a>
        <div id="collapseProcesos" class="panel-collapse collapse card-body p-0">


            <div class="row">
                
                <div class="col">
                    <form id="formAgregarProceso" name="formAgregarProceso" action="{{route('Empresa.agregarEditarProceso')}}" method="POST">
                        @csrf
                        <input type="hidden" name="idEmpresa" value="{{$empresa->idEmpresa}}">
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idProceso" id="idProceso" value="-1" >

                        <label for="">Nombre del nuevo Proceso</label>
                        <input class="form-control" name="nombreNuevoProceso" id="nombreNuevoProceso">
                        
                        <label for="">Descripción del nuevo proceso</label>
                        <textarea class="form-control" name="descripcionNuevoProceso" id="descripcionNuevoProceso" cols="3" rows="2"
                        ></textarea>

                        <button type="button" onclick="clickAgregarProceso()" class="btn btn-primary">
                            <i class="fas fa-plus">Guardar</i>
                        </button>
                    </form>

                </div>
                
   
                <div class="col">
                    
                    <form id="formAgregarSubproceso" name="formAgregarSubproceso" action="{{route('Empresa.agregarEditarSubproceso')}}" method="POST">
                        <input type="hidden" name="idEmpresa" value="{{$empresa->idEmpresa}}">
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idSubproceso" id="idSubproceso" value="-1" >

                        @csrf
                        <div class="row">
                            <label for="">Nuevo Subproceso</label>

                        </div>
                        
                        <div class="row">
                            <div class="col">

                                <label for="">Proceso</label>
                                <select class="form-control"  id="ComboBoxProceso" name="ComboBoxProceso" onchange="" >
                                    <option value="-1"> -- Proceso -- </option>
                                    @foreach($listaProcesos as $itemProceso)
                                        <option value="{{$itemProceso->idProceso}}">
                                            {{$itemProceso->nombre}}
                                        </option>
                                        
                                    @endforeach
                                </select> 

                            </div>
                            <div class="col">

                                <label for="">Nombre subproceso</label>
                                <input type="text" class="form-control" name="nombreNuevoSubproceso" id="nombreNuevoSubproceso">

                            </div>
                            <div class="w-100"></div>
                            <div class="col">


                            </div>
                            <div class="col">


                            </div>



                        </div>
                        
                        
                        <button type="button" onclick="clickAgregarSubproceso()" class="btn btn-primary">
                            <i class="fas fa-plus">Guardar</i>
                        </button>

                    </form>

                       
                    
                </div>

            </div>




            {{-- PARA VER LA SOLICITUD ENLAZADA --}}   
            <div class="table-responsive " style="margin: 5px">                           
                <table  id="tablaProcesos" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th  class="text-center">Nombre</th>                                        
                        <th  class="text-center">Descripcion</th>    
                        <th>#Indicadores</th> 
                        <th> Opciones</th>
                  
                        <th> Subprocesos y # Indicadores</th>
                        
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                    --}}
                    </thead>
                    <tbody>
                        @foreach($listaProcesos as $itemProceso)
                            <tr class="selected">
                                <td  style="text-align:center;">               
                                    {{$itemProceso->nombre}}
                                </td>       
                                <td>
                                    {{$itemProceso->descripcion}}
                                </td>
                                <td>
                                    {{$itemProceso->getCantidadIndicadores()}}
                                </td>
                                <td style="text-align: center;">
                                    <a href="#" class=" btn-primary" onclick="clickEliminarProceso({{$itemProceso->idProceso}})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>

                                    <a href="#" class=" btn-primary" onclick="clickEditarProceso({{$itemProceso->idProceso}})">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <a href="{{route('proceso.verIndicadores',$itemProceso->idProceso)}}" class="btn-primary">
                                        <i class="fas fa-italic"></i>

                                    </a>


                                </td>
                                <td>
                                    
                                    <table class="table-striped table-bordered table-condensed table-hover">
                                        <tbody>
                                            @foreach ($itemProceso->getListaSubprocesos() as $itemSubproceso)
                                            <tr>
                                                <td>
                                                    {{$itemSubproceso->nombre}}
                                                </td>
                                                <td>{{$itemSubproceso->getCantidadIndicadores()}}</td>
                                                <td width="10%">
                                                    <a onclick="clickEliminarSubproceso({{$itemSubproceso->idSubproceso}})" class="btn btn-alert">
                                                        <i class="fas fa-trash"></i>
                                                    </a>

                                                    <a href="#" onclick="clickEditarSubproceso({{$itemSubproceso->idSubproceso}})">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('subproceso.verIndicadores',$itemSubproceso->idSubproceso)}}" class="btn-primary">
                                                        <i class="fas fa-italic"></i>
                
                                                    </a>
                
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        
                                    </table>

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
    #iconoGiradorProcesos {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorProcesos.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>

    listaProcesos = [];
    listaSubprocesos =[];
    generarVectorProcesos();
    
    
    let giradoProcesos = true;
    function girarIconoProceso(){
      const elemento = document.querySelector('#iconoGiradorProcesos');
      let nombreClase = elemento.className;
      if(giradoProcesos)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoProcesos = !giradoProcesos;
    }

    



    /* ------------------------------------ PROCESO ----------------------------------*/

    function clickAgregarProceso(){
        msjError = validarAgregarProceso();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }
        nombreNuevoProceso = document.getElementById('nombreNuevoProceso').value;
        confirmarConMensaje("Confirmación","¿Desea agregar el nuevo proceso "+nombreNuevoProceso+"?","warning",submitearAgregarProceso);

    }    
    function validarAgregarProceso(){
        nombreNuevoProceso = document.getElementById('nombreNuevoProceso').value;
        descripcionNuevoProceso = document.getElementById('descripcionNuevoProceso').value;
    
        msjError = "";
        if(nombreNuevoProceso==""){
            msjError="Debe ingresar un nombre válido.";
        }

        if(descripcionNuevoProceso==""){
            msjError="Debe ingresar una descripción válida para el nuevo proceso";

        }
        return msjError;

    }

    function submitearAgregarProceso(){
        document.formAgregarProceso.submit();
    }

    procesoAEliminar="";
    function clickEliminarProceso(idProceso){
        procesoAEliminar = idProceso;
        confirmarConMensaje("Confirmación","¿Desea eliminar el proceso?","warning",ejecutarEliminacionProceso);

    }

    function ejecutarEliminacionProceso(){
        location.href="/Empresa/eliminarProceso/" + procesoAEliminar;
    }



    function clickEditarProceso(idProcesoSeleccionado){
        
        proceso = listaProcesos.find(elemento => elemento.idProceso == idProcesoSeleccionado);
        console.log(proceso);

        document.getElementById('nombreNuevoProceso').value = proceso.nombre;
        document.getElementById('descripcionNuevoProceso').value = proceso.descripcion;
        document.getElementById('idProceso').value = proceso.idProceso;
    }


    








    /* ------------------------------------ SUBPROCESO ----------------------------------*/

    function clickAgregarSubproceso(){
        msjError = validarAgregarSubproceso();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }
        nombreNuevoSubproceso = document.getElementById('nombreNuevoSubproceso').value;
        confirmarConMensaje("Confirmación","¿Desea agregar el nuevo proceso "+nombreNuevoSubproceso+"?","warning",submitearAgregarSubproceso);

    }    
    function validarAgregarSubproceso(){
        ComboBoxProceso = document.getElementById('ComboBoxProceso').value;
        nombreNuevoSubproceso = document.getElementById('nombreNuevoSubproceso').value;
    
        msjError = "";
        if(ComboBoxProceso=="-1"){
            msjError="Debe ingresar un proceso para su nuevo subproceso.";
        }

        if(nombreNuevoSubproceso==""){
            msjError="Debe ingresar un nombre para el nuevo subproceso.";

        }
        return msjError;

    }

    function submitearAgregarSubproceso(){
        document.formAgregarSubproceso.submit();
    }


    subprocesoAEliminar="";
    function clickEliminarSubproceso(idSubproceso){
        subprocesoAEliminar = idSubproceso;
        confirmarConMensaje("Confirmación","¿Desea eliminar el subproceso?","warning",ejecutarEliminacionSubproceso);

    }

    function ejecutarEliminacionSubproceso(){
        location.href="/Empresa/eliminarSubproceso/" + subprocesoAEliminar;
    }
    

    function clickEditarSubproceso(idSubprocesoSeleccionado){
        
        subproceso = listaSubprocesos.find(elemento => elemento.idSubproceso == idSubprocesoSeleccionado);
        console.log(subproceso);

        ComboBoxProceso
        document.getElementById('ComboBoxProceso').value = subproceso.idProceso;
        document.getElementById('nombreNuevoSubproceso').value = subproceso.nombre;
        document.getElementById('idSubproceso').value = subproceso.idSubproceso;
    
    }
    

/* ------------------------------               --------------------------- */
    
    function generarVectorProcesos(){
        console.log("OLE");
        @foreach($listaProcesos as $itemProceso)
            listaProcesos.push({
                idProceso : "{{$itemProceso->idProceso}}",
                nombre: "{{$itemProceso->nombre}}",
                descripcion: "{{$itemProceso->descripcion}}"
            }); 


            
            @foreach($itemProceso->getListaSubprocesos() as $itemSubproceso)
            listaSubprocesos.push({
                    idSubproceso : "{{$itemSubproceso->idSubproceso}}",
                    idProceso : "{{$itemSubproceso->idProceso}}",
                    nombre: "{{$itemSubproceso->nombre}}"
                }); 
            @endforeach

        @endforeach
        console.log(listaProcesos);
        console.log(listaSubprocesos);

        

    }



</script>
