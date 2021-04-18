{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoObjetivoEspecifico()" data-toggle="collapse" href="#collapseObjEspec" style=""> 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Objetivos Especificos e Indicadores
                </h4>
                <i id="iconoGiradorObjEspecif" class="fas fa-plus" style="float:right"></i>
            </div>

        </a>
        <div id="collapseObjEspec" class="panel-collapse collapse card-body">

               @csrf
                <div class="row">
                    
                    
                        <div class="col">
                            <form action="{{route('GestionProyectos.agregarObjetivoEspecifico')}}" method="POST">
                                @csrf
                                <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                
                                <label for="">Nuevo Obj Esp</label>
                                <textarea class="form-control" name="descripcionObjetivo" id="descripcionObjetivo" cols="15" rows="1"
                                ></textarea>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus">Agregar</i>
                                </button>
                            </form>

                        </div>
                    
       
                    <div class="col">
                        
                        <form id="formAgregarIndicador" name="formAgregarIndicador" action="{{route('GestionProyectos.agregarIndicador')}}" method="POST">
                            <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                            @csrf
                            <label for="">Nuevo Indicador</label>
                            <br>
                            <label for="">Objetivo al que apunta</label>
                            <select class="form-control"  id="ComboBoxObjetivoEspecifico" name="ComboBoxObjetivoEspecifico" onchange="" >
                                <option value="-1"> -- Obj Esp -- </option>
                                @foreach($listaObjetivosEspecificos as $itemObjEspecifico)
                                    <option value="{{$itemObjEspecifico->codObjEspecifico}}">
                                        {{$itemObjEspecifico->getDescripcionAbreviada()}}
                                    </option>
                                    
                                @endforeach
                            </select> 
                            <label for="">Descripción del Indicador</label>
                            <textarea class="form-control" name="descripcionNuevoIndicador" id="descripcionNuevoIndicador" cols="3" rows="2"
                            ></textarea>


                            <button type="button" onclick="clickAgregarIndicador()" class="btn btn-primary">
                                <i class="fas fa-plus">Agregar</i>
                            </button>

                        </form>

                           
                        
                    </div>
                    
                </div>



                
        
            





            {{-- PARA VER LA SOLICITUD ENLAZADA --}}   
            <div class="table-responsive " style="margin: 5px">                           
                <table  id="tablaDetallesLugares" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th> Opc</th>
                        <th  class="text-center">Obj Esp</th>                                        
                        <th> Indicadores</th>
                        
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                    --}}
                    </thead>
                    <tbody>
                        @foreach($listaObjetivosEspecificos as $itemObjEspecifico)
                            <tr  class="selected">
                                <td  style="text-align: center;">

                                    <a href="#" onclick="confirmarEliminarObjEspecifico({{$itemObjEspecifico->codObjEspecifico}})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    

                                </td>
                                <td  style="text-align:center;">               
                                    {{$itemObjEspecifico->descripcion}}
                                </td>       

                                <td>



                                    <table class="table table-striped table-bordered table-condensed table-hover">
                                        <tbody>
                                            @foreach ($itemObjEspecifico->getListaDeIndicadores() as $itemIndicadorObjEsp)
                                            <tr>
                                                <td>
                                                    {{$itemIndicadorObjEsp->descripcion}}
                                                </td>
                                                <td  width="10%">
                                                    <a onclick="clickEliminarIndicador({{$itemIndicadorObjEsp->codIndicadorObj}})" class="btn btn-alert">
                                                        <i class="fas fa-trash"></i>
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
    #iconoGiradorObjEspecif {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorObjEspecif.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>

    indicadorAEliminar="";
    function clickEliminarIndicador(codIndicador){

        indicadorAEliminar=codIndicador;
        confirmarConMensaje("Confirmacion","¿Seguro que desea eliminar el indicador?","warning",ejecutarEliminacionIndicador);


    }   
    function ejecutarEliminacionIndicador(){
        location.href = "/GestionProyectos/eliminarIndicador/"+indicadorAEliminar;
    }

    function clickAgregarIndicador(){

        msjError = validarFormAgregarIndicador();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }


        document.formAgregarIndicador.submit();

    }

    function validarFormAgregarIndicador(){
        codObjEspecifico = document.getElementById('ComboBoxObjetivoEspecifico').value;
        descripcionNuevoIndicador = document.getElementById('descripcionNuevoIndicador').value;
        
        msjError = "";
        if(codObjEspecifico=="-1")
        {
            msjError="Debe seleccionar el objetivo específico.";
        }
        
        if(descripcionNuevoIndicador=="")
        {
            msjError="Debe ingresar la descripción.";            
        }


        return msjError;
    }


    let giradoItemsObjEsp = true;
    function girarIconoObjetivoEspecifico(){
      const elemento = document.querySelector('#iconoGiradorObjEspecif');
      let nombreClase = elemento.className;
      if(giradoItemsObjEsp)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoItemsObjEsp = !giradoItemsObjEsp;
    }



    codObjetivoEspecifico = "0";
    function confirmarEliminarObjEspecifico(codObjEspecifico){
        console.log('Se eliminará el ' + codObjEspecifico);
        codObjetivoEspecifico = codObjEspecifico;
        confirmarConMensaje("Confirmación","¿Seguro de eliminar esta el objetivo específico? Se eliminarán también sus indicadores","warning",ejecutarEliminacionObjetivoEspecifico);

    }

    function ejecutarEliminacionObjetivoEspecifico(){

        location.href = "/GestionProyectos/eliminarObjetivoEspecifico/" + codObjetivoEspecifico;

    }

</script>
