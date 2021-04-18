{{-- FIN LISTADO DESPLEGABLE DE SOLICITUD ENLAZADA --}}

<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorItems" onclick="girarIconoPoblacionBeneficiaria()" data-toggle="collapse" href="#collapsePobBen" style=""> 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    Poblacion Beneficiaria
                </h4>
                <i id="iconoGiradorItemsPobBen" class="fas fa-plus" style="float:right"></i>
            </div>

        </a>
        <div id="collapsePobBen" class="panel-collapse collapse card-body p-0">

            <form action="{{route('GestionProyectos.agregarPoblacionBeneficiaria')}}" method="POST">
                @csrf
                <input type="hidden" name="codProyecto" value="{{$proyecto->codProyecto}}">
                <div class="row">
                    <div class="col-sm">
                        <textarea class="form-control" name="descripcionPob" id="descripcionPob" cols="30" rows="1"
                        ></textarea>

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
                        <th  class="text-center">Descripcion</th>                                        
                        
                        <th> Opc</th>
                  
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                    --}}
                    </thead>
                    <tbody>
                        @foreach($poblacionesBeneficiarias as $itemPobBen)
                            <tr class="selected">
                                <td  style="text-align:center;">               
                                    {{$itemPobBen->descripcion}}
                                </td>       
                               
                                <td style="text-align: center;">

                                        <a href="#" onclick="confirmarEliminarPoblacionBeneficiaria({{$itemPobBen->codPoblacionBeneficiaria}})">
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
    #iconoGiradorItemsPobBen {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    #iconoGiradorItemsPobBen.rotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>

<script>
    let giradoItemsPobBen = true;
    function girarIconoPoblacionBeneficiaria(){
      const elemento = document.querySelector('#iconoGiradorItemsPobBen');
      let nombreClase = elemento.className;
      if(giradoItemsPobBen)
        nombreClase += ' rotado';
      else
        nombreClase =  nombreClase.replace(' rotado','');
      elemento.className = nombreClase;
      giradoItemsPobBen = !giradoItemsPobBen;
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


    codPoblacionBeneficiariaAEliminar = "0";
    function confirmarEliminarPoblacionBeneficiaria(codPoblacionBeneficiaria){
        console.log('Se eliminará el ' + codPoblacionBeneficiaria);
        codPoblacionBeneficiariaAEliminar = codPoblacionBeneficiaria;
        confirmarConMensaje("Confirmación","¿Seguro de eliminar esta poblacion beneficiaria?","warning",ejecutarEliminacionPoblacionBeneficiaria);

    }

    function ejecutarEliminacionPoblacionBeneficiaria(){

        location.href = "/GestionProyectos/eliminarPoblacionBeneficiaria/" + codPoblacionBeneficiariaAEliminar;

    }

</script>
