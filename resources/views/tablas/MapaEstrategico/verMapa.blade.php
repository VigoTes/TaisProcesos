
@extends('Layout.Plantilla')
@section('contenido')


<style>

.checkbox{
 
  width: 15px;
}

.divChikito{
  width: 15px;
  height: 15px;

  
-moz-border-radius: 15px;
-webkit-border-radius: 15px;
padding: 10px;

}
</style>


<h3> 
  Mapa Estratégico para el {{$mapaEstrategico->getStringTipo()}} "{{$mapaEstrategico->getNombreProSub()}}"
 </h3>
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif


<div class="card">
        <div class="card-header border-0">         
         

            <form action="{{route('MapaEstrategico.agregarElemento')}}" id="formAgregarElemento" name="formAgregarElemento" method="post">
              <input type="{{App\Configuracion::getInputTextOHidden()}}" id="idMapaEstrategico" name="idMapaEstrategico" value="{{$mapaEstrategico->idMapaEstrategico}}">
              @csrf
              <div class="row">
                <div class="col">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control" name="nombreNuevoElemento" id="nombreNuevoElemento" value="">
                </div>
                <div class="col">

                  <label for="">Nivel</label>
                  <select class="form-control"  id="ComboBoxNivel" name="ComboBoxNivel" onchange="" >
                        <option value="-1"> -- Nivel -- </option>
                        @foreach($listaNiveles as $itemNivel)
                          <option value="{{$itemNivel->idNivel}}">
                              {{$itemNivel->nombre}}
                          </option>
                          
                        @endforeach
                  </select> 
                </div>

              </div>
              <button type="button" onclick="clickAgregarElemento()" href="#" class = "btn btn-primary"> 
                <i class="fas fa-plus"> </i> 
                  Agregar Elemento
              </button>
            </form>
            
            
            

           
          </div>
        
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-striped table-valign-middle">
            <thead>
            <tr>
                <th width="10%"  style="text-align: center">Nivel</th>
                <th>Elementos</th>
            </tr>
            </thead>
            <tbody>
              <tr>
                  <td>
                    FINANCIERA
                  </td>
                  <td>


                    <table>
                      <tbody>
                        @foreach ($listaFinanciera as $itemFinanciera )
                          <th >

                           
                            {{$itemFinanciera->nombre}}
                            <a href="#" onclick="clickEliminarElemento({{$itemFinanciera->idElemento}})">
                              <i class="fas fa-trash"></i>
                            </a>
                            <input class="form-control checkbox" onclick="añadirARelacion({{$itemFinanciera->idElemento}})" type="checkbox" name="">
                            
                            <div class="row">
                              @foreach($itemFinanciera->getListaFlechasDestino() as $flecha)
                                <div class="divChikito col" style="background-color: {{$flecha->getColor()}}"  onclick="clickEliminarRelacion({{$flecha->idFlecha}})">
                                </div>  
                              @endforeach
                            </div>
                            

                          </th>
                        @endforeach
                                               

                      </tbody>
                    </table>

                  </td>
              </tr>
            

              <tr>
                <td>
                  CLIENTES
                </td>
                <td>


                  <table>
                    <tbody>
                      @foreach ($listaClientes as $itemClientes )
                          <th >
                            <div class="row">
                              @foreach($itemClientes->getListaFlechasOrigen() as $flecha)
                                <div class="divChikito col" style="background-color: {{$flecha->getColor()}}"  onclick="clickEliminarRelacion({{$flecha->idFlecha}})">
                                </div>  
                              @endforeach

                            </div>
                            

                            {{$itemClientes->nombre}}
                            <a href="#" onclick="clickEliminarElemento({{$itemClientes->idElemento}})">
                              <i class="fas fa-trash"></i>
                            </a>

                            <input class="form-control checkbox" onclick="añadirARelacion({{$itemClientes->idElemento}})" type="checkbox" name="">
                            
                            <div class="row">
                              @foreach($itemClientes->getListaFlechasDestino() as $flecha)
                                <div class="col divChikito" style="background-color: {{$flecha->getColor()}}"  onclick="clickEliminarRelacion({{$flecha->idFlecha}})">
                                </div>  
                              @endforeach
                            </div>
                            
                            
                          </th>
                      @endforeach
                          
                    </tbody>
                  </table>

                </td>
              </tr>



              <tr>
                <td>
                  PROCESO INTERNOS
                </td>
                <td>


                  <table>
                    <tbody>
                      @foreach ($listaProcesoInternos as $itemProcesosInternos )
                          <th >

                            <div class="row">
                              @foreach($itemProcesosInternos->getListaFlechasOrigen() as $flecha)
                                <div class="col divChikito" style="background-color: {{$flecha->getColor()}}"  onclick="clickEliminarRelacion({{$flecha->idFlecha}})">
                                </div>  
                              @endforeach
                            </div>
                            

                            {{$itemProcesosInternos->nombre}}
                            <a href="#" onclick="clickEliminarElemento({{$itemProcesosInternos->idElemento}})">
                              <i class="fas fa-trash"></i>
                            </a>
                            <input class="form-control checkbox" onclick="añadirARelacion({{$itemProcesosInternos->idElemento}})" type="checkbox" name="">
                            
                            <div class="row">
                              @foreach($itemProcesosInternos->getListaFlechasDestino() as $flecha)
                                <div class="divChikito col" style="background-color: {{$flecha->getColor()}}"  onclick="clickEliminarRelacion({{$flecha->idFlecha}})">
                                </div>  
                              @endforeach
                            </div>
                            
                          </th>
                      @endforeach
                         
                    </tbody>
                  </table>

                </td>
              </tr>

              <tr>
                <td>
                  Aprendizaje y crecimiento
                </td>
                <td>


                  <table>
                    <tbody>
                      @foreach ($listaAprendizaje as $itemAprendizaje )
                          <th >
                            <div class="row">
                              @foreach($itemAprendizaje->getListaFlechasOrigen() as $flecha)
                                <div class="divChikito col" style="background-color: {{$flecha->getColor()}}" onclick="clickEliminarRelacion({{$flecha->idFlecha}})">
                                </div>  
                              @endforeach
                            </div>
                            

                            {{$itemAprendizaje->nombre}}
                            <a href="#" onclick="clickEliminarElemento({{$itemAprendizaje->idElemento}})">
                              <i class="fas fa-trash"></i>
                            </a>
                            <input class="form-control checkbox" onclick="añadirARelacion({{$itemAprendizaje->idElemento}})" type="checkbox" name="">

                          </th>
                      @endforeach
                         
                    </tbody>
                  </table>

                </td>
              </tr>

              
            </tbody>
          </table>


         

        </div>
        <div class="row">
          <div class="col">
            <a href="{{$rutaVolverAEditar}}" class="btn btn-success" style="width: 20%">
              Regresar a la Empresa <i class="fas fa-undo-alt"></i>
            </a>

          </div>
          <div class="col">

            <a href="#" onclick="clickCrearRelacion()" class="btn btn-success" style="width: 20%">
              Crear Relación
            </a>
  

          </div>
        </div>
         

        <br>
      </div>


@endsection

@section('script')
  <script>
    
    listaRelacionParaCrear = [];


    function añadirARelacion(idElemento){
      pos = listaRelacionParaCrear.findIndex(element => element == idElemento);

      if( pos != "-1" ){//ya está en el vector
        listaRelacionParaCrear.splice(pos,1);
      }else{
        listaRelacionParaCrear.push(idElemento);
      
      }

      console.log(listaRelacionParaCrear);
    
    }

    function clickCrearRelacion(){
      if( listaRelacionParaCrear.length != 2)
      {
        alerta("Se requieren solo dos elementos para crear la relación.");
        return;
      }

        confirmarConMensaje("Confirmación","¿Desea crear la relación?","warning",ejecutarCreadoRelacion);
    }

    function ejecutarCreadoRelacion(){
        location.href = "/MapaEstrategico/crearRelacion/" + listaRelacionParaCrear;
    }



    function clickAgregarElemento(){
        msjError = validarAgregarElemento();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }
        nombreNuevoElemento = document.getElementById('nombreNuevoElemento').value;
        confirmarConMensaje("Confirmación","¿Desea agregar el nuevo elemento "+nombreNuevoElemento+"?","warning",submitearAgregarElemento);

    }    
    function validarAgregarElemento(){
        nombreNuevoElemento = document.getElementById('nombreNuevoElemento').value;
        ComboBoxNivel = document.getElementById('ComboBoxNivel').value;
          
        ComboBoxNivel
        msjError = "";
        if(nombreNuevoElemento==""){
            msjError="Debe ingresar un nombre válido.";
        }

        if(ComboBoxNivel=="-1"){
            msjError="Debe ingresar un nivel para el elemento.";
        }



        return msjError;

    }

    function submitearAgregarElemento(){
        document.formAgregarElemento.submit();
    }




    idElementoABorrar = "";
    function clickEliminarElemento(idElemento){
      idElementoABorrar = idElemento;
      confirmarConMensaje("Confirmación","¿Desea borrar el elemento?",'warning',ejecutarEliminacionElemento);

    }

    function ejecutarEliminacionElemento(){
      location.href = "/MapaEstrategico/eliminarElemento/" + idElementoABorrar;

    }





    idFlechaABorrar = "";
    function clickEliminarRelacion(idFlecha){
      idFlechaABorrar = idFlecha;
      confirmarConMensaje("Confirmación","¿Desea borrar la relación?",'warning',ejecutarEliminacionFlecha);
    }

    function ejecutarEliminacionFlecha(){
      location.href = "/MapaEstrategico/eliminarRelacion/"+ idFlechaABorrar;
    }


    



  </script>

@endsection