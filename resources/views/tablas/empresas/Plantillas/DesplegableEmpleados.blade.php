{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoEmpleados()" data-toggle="collapse" href="#collapseEmpleados"  > 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Lista de Empleados de la Empresa
                </h4>
                <i id="iconoGiradorEmpleados" class="fas fa-plus" style="float:right"></i>
            </div>

        </a>
        <div id="collapseEmpleados" class="panel-collapse collapse card-body p-0">


            <div class="row">
                
                <div class="col">
                    <form id="formAgregarEmpleado" name="formAgregarEmpleado" action="{{route('Empresa.agregarEditarEmpleado')}}" method="POST">
                        @csrf
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idEmpresa" value="{{$empresa->idEmpresa}}">
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="idAI" id="idAI" value="-1" >

                        <div class="row">
                            <div class="col">

                                <label for="">Empleado</label>
                                <select class="form-control"  id="idEmpleado" name="idEmpleado" onchange="" >
                                    <option value="-1"> -- Empleado -- </option>
                                    @foreach($listaEmpleadosTodos as $itemEmpleado)
                                        <option value="{{$itemEmpleado->idEmpleado}}">
                                            {{$itemEmpleado->getNombreCompleto()}}
                                        </option>
                                        
                                    @endforeach
                                </select> 

                            </div>
                            <div class="col">

                                <label for="">Rol</label>
                                <select class="form-control"  id="idRol" name="idRol" onchange="" >
                                    
                                    <option value="-1"> -- Rol -- </option>
                                    @foreach($listaRoles as $itemRol)
                                        <option value="{{$itemRol->idRol}}">
                                            {{$itemRol->nombre}}
                                        </option>
                                        
                                    @endforeach
                                
                                </select> 


                            </div>
                            <div class="col">


                                <br>
                                <button type="button" onclick="clickAgregarEmpleado()" class="btn btn-primary">
                                    <i class="fas fa-plus">Guardar</i>
                                </button>


                            </div>
                        </div>



                        
                    </form>

                </div>
                

            </div>




            {{-- PARA VER LA SOLICITUD ENLAZADA --}}   
            <div class="table-responsive " style="margin: 5px">                           
                <table  id="tablaProcesos" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th  class="text-center">Empleado</th> 
                        <th  class="text-center">Cod Empleado</th> 
                                                               
                        <th  class="text-center">Rol</th>    
                        <th></th> 
                        
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                    --}}
                    </thead>
                    <tbody>
                        @foreach($listaEmpleadosEmpresa as $itemEmp)
                            <tr class="selected">
                                  
                                <td>
                                    {{$itemEmp->getEmpleado()->getNombreCompleto()}}
                                </td>
                                <td>
                                    {{$itemEmp->getEmpleado()->getUsuario()->usuario}}
                                </td>
                                <td>
                                    {{$itemEmp->getRol()->nombre}}
                                </td>
                                <td style="text-align: center;">
                                    <a href="#" class=" btn-primary" onclick="clickEliminarEmpleado({{$itemEmp->idAI}})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>

                                    <a href="#" class=" btn-primary" onclick="clickEditarEmpleado({{$itemEmp->idAI}})">
                                        <i class="fas fa-pen"></i>
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
    #iconoGiradorEmpleados {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorEmpleados.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>

    listaRoles = [];
 
    
    let giradoEmpleados = true;
    function girarIconoEmpleados(){
      const elemento = document.querySelector('#iconoGiradorEmpleados');
      let nombreClase = elemento.className;
      if(giradoEmpleados)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoEmpleados = !giradoEmpleados;
    }

    function generarVectorRoles(){
        console.log("OLE");
        @foreach($listaEmpleadosEmpresa as $itemEmpleadoEmpresa)
        listaRoles.push({
                idAI : "{{$itemEmpleadoEmpresa->idAI}}",
                idRol: "{{$itemEmpleadoEmpresa->idRol}}",
                idEmpleado: `{{$itemEmpleadoEmpresa->idEmpleado}}`
            }); 
        @endforeach
        console.log(listaRoles);
        

    }

    generarVectorRoles();
    
    

    /* ------------------------------------ EMPLEADO ----------------------------------*/

    function clickAgregarEmpleado(){
        msjError = validarAgregarEmpleado();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }
       
        confirmarConMensaje("Confirmación","¿Desea asignar el empleado?","warning",submitearAgregarEmpleado);

    }    

    function validarAgregarEmpleado(){
        idEmpleado = document.getElementById('idEmpleado').value;
        idRol = document.getElementById('idRol').value;
    
        msjError = "";
        if(idEmpleado=="-1"){
            msjError="Debe seleccionar un empleado.";
        }
        
        if(idRol=="-1"){
            msjError="Debe ingresar un rol";

        }
        return msjError;

    }

    function submitearAgregarEmpleado(){
        document.formAgregarEmpleado.submit();
    }

    idRelacion="";
    function clickEliminarEmpleado(idAI){
        idRelacion = idAI;
        confirmarConMensaje("Confirmación","¿Desea eliminar el empleado?","warning",ejecutarEliminacionRelacion);

    }

    function ejecutarEliminacionRelacion(){
        location.href="/Empresas/eliminarEmpleado/" + idRelacion;
    }



    function clickEditarEmpleado(idAI){
        
        empresaUsuario = listaRoles.find(elemento => elemento.idAI == idAI);
        console.log(empresaUsuario);

        document.getElementById('idEmpleado').value = empresaUsuario.idEmpleado;
        document.getElementById('idRol').value = empresaUsuario.idRol;
        document.getElementById('idAI').value = empresaUsuario.idAI;
    }
    

/* ------------------------------               --------------------------- */
    
    



</script>
