{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoResultadoEsperado()" data-toggle="collapse" href="#collapseResEsp" style=""> 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Resultados Esperados e Indicadores
                </h4>
                <i id="iconoGiradorResEsp" class="fas fa-plus" style="float:right"></i>
            </div>

        </a>
        <div id="collapseResEsp" class="panel-collapse collapse card-body">

               @csrf
                <div class="row">
                    
                    
                        <div class="col">
                            <form action="{{route('GestionProyectos.agregarResultadoEsperado')}}" method="POST">
                                @csrf
                                <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                
                                <label for="">Nuevo Resultado Esperado</label>
                                <textarea class="form-control" name="descripcionNuevoResultado" id="descripcionNuevoResultado" cols="15" rows="1"
                                ></textarea>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus">Agregar</i>
                                </button>
                            </form>

                        </div>
                    
       
                    <div class="col"  >
                        
                        <form id="frmAgregarIndicadorResultado" name="frmAgregarIndicadorResultado" action="{{route('GestionProyectos.agregarIndicadorResultado')}}" method="POST">
                            <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                            @csrf
                            <label for="">Nuevo Indicador</label>
                            <br>
                            <label for="">Resultado Esperado al que apunta</label>
                            <select class="form-control"  id="ComboBoxResultadoEsperado" name="ComboBoxResultadoEsperado" onchange="" >
                                <option value="-1"> -- Res Esp -- </option>
                                @foreach($listaResultadosEsperados as $itemResEsperado)
                                    <option value="{{$itemResEsperado->codResultadoEsperado}}">
                                        {{$itemResEsperado->getDescripcionAbreviada()}}
                                    </option>
                                    
                                @endforeach
                            </select> 
                            <label for="">Descripción del Indicador</label>
                            <textarea class="form-control" name="descripcionNuevoIndicadorResultado" id="descripcionNuevoIndicadorResultado" cols="3" rows="2"
                            ></textarea>


                            <button type="button" onclick="clickAgregarIndicadorRes()" class="btn btn-primary">
                                <i class="fas fa-plus">Agregar</i>
                            </button>

                        </form>

                           
                        
                    </div>
                    
                </div>



                
        
            





            {{-- PARA VER LA SOLICITUD ENLAZADA --}}   
            <div class="table-responsive " style="margin: 5px">                           
                <table  id="" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th> Opc</th>
                        <th  class="text-center">Res Esp</th>                                        
                        <th> Indicadores</th>
                        
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                    --}}
                    </thead>
                    <tbody>
                        @foreach($listaResultadosEsperados as $itemResEsperado)
                            <tr  class="selected">
                                <td  style="text-align: center;">

                                    <a href="#" onclick="confirmarEliminarResultadoEsperado({{$itemResEsperado->codResultadoEsperado}})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    

                                </td>
                                <td  style="text-align:center;">               
                                    {{$itemResEsperado->descripcion}}
                                </td>       

                                <td>



                                    <table class="table table-striped table-bordered table-condensed table-hover">
                                        <tbody>
                                            @foreach ($itemResEsperado->getListaDeIndicadores() as $itemIndicadorResEsp)
                                            <tr>
                                                <td>
                                                    {{$itemIndicadorResEsp->descripcion}}
                                                </td>
                                                <td width="10%">
                                                    <a onclick="clickEliminarIndicadorResultado({{$itemIndicadorResEsp->codIndicadorResultado}})" class="btn btn-alert">
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
    #iconoGiradorResEsp {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorResEsp.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>

    indicadorAEliminar="";
    function clickEliminarIndicadorResultado(codIndicador){

        indicadorAEliminar=codIndicador;
        confirmarConMensaje("Confirmacion","¿Seguro que desea eliminar el indicador?","warning",ejecutarEliminacionIndicadorResultado);


    }   
    function ejecutarEliminacionIndicadorResultado(){
        location.href = "/GestionProyectos/eliminarIndicadorResultadoEsperado/"+indicadorAEliminar;
    }

    function clickAgregarIndicadorRes(){

        msjError = validarfrmAgregarIndicadorResultado();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }


        document.frmAgregarIndicadorResultado.submit();

    }

    function validarfrmAgregarIndicadorResultado(){

        codResultadoEsperado = document.getElementById('ComboBoxResultadoEsperado').value;
        descripcionNuevoIndicadorResultado = document.getElementById('descripcionNuevoIndicadorResultado').value;
        
        msjError = "";
        if(codResultadoEsperado=="-1")
        {
            msjError="Debe seleccionar el resultado esperado.";
        }
        
        if(descripcionNuevoIndicadorResultado=="")
        {
            msjError="Debe ingresar la descripción.";            
        }


        return msjError;
    }


    let giradoItemsResEsperado = true;
    function girarIconoResultadoEsperado(){
      const elemento = document.querySelector('#iconoGiradorResEsp');
      let nombreClase = elemento.className;
      if(giradoItemsResEsperado)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoItemsResEsperado = !giradoItemsResEsperado;
    }



    codResultadoEsperadoAEliminar = "0";
    function confirmarEliminarResultadoEsperado(codResultadoEsperado){
        console.log('Se eliminará el ' + codResultadoEsperado);
        codResultadoEsperadoAEliminar = codResultadoEsperado;
        confirmarConMensaje("Confirmación","¿Seguro de eliminar esta el resultado esperado? Se eliminarán también sus indicadores","warning",ejecutarEliminacionResultadoEsperado);

    }

    function ejecutarEliminacionResultadoEsperado(){

        location.href = "/GestionProyectos/eliminarResultadoEsperado/" + codResultadoEsperadoAEliminar;

    }

</script>
