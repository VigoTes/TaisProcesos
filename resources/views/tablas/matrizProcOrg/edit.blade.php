

@extends('Layout.Plantilla')
@section('contenido')

<form method = "POST" action = "{{route('celdamatriz.store')}}"  >
    @csrf   

    @if (session('msjLlegada'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('msjLlegada')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif


        <label for="nombreEmpresa">Nombre de la Empresa</label>
        <input type="text" class="form-control"  
          id="nombreEmpresa" name="nombreEmpresa" disabled = "disabled" 
          value="{{$empresaFocus->nombreEmpresa}}">
        
        <label>Nro de matriz</label>
        <input type="text" class="form-control"  
            id="nroMatrizEnEmpresa" name="nroMatrizEnEmpresa" disabled = "disabled" 
            value="{{$matrizAEditar->nroEnEmpresa}}">
            
        <label>Descripcion de la matriz</label>
        <input type="text" class="form-control"  
                id="descripcionMatriz" name="descripcionMatriz" disabled = "disabled" 
                value="{{$matrizAEditar->descripcion}}">
            
                  
                <input type="hidden"
                    id="idEmpresa" name="idEmpresa" 
                    value="{{$empresaFocus->idEmpresa}}">
                <input type="hidden"
                    id="idMatriz" name="idMatriz" 
                    value="{{$matrizAEditar->idMatriz}}">
                
    

    <div style="margin: 20px ;">
        <div style=" width:150px; height: 100px; float: left; margin-left:20px;">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoMarca" id="MARCA_X" value="X">
                <label class="form-check-label" for="MARCA_X">
                Marcar con X
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoMarca" id="MARCA_x" value="x">
                <label class="form-check-label" for="MARCA_x">
                Marcar con x
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoMarca" id="MARCA_/" value="/">
                <label class="form-check-label" for="MARCA_/">
                Marcar con /
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoMarca" id="MARCA_*" value="*">
                <label class="form-check-label" for="MARCA_*">
                Eliminar marca
                </label>
            </div>
        </div>

        <div style="">
            <button type="submit" style="margin-top: 25px; " class="btn btn-primary">  
                Marcar 
            </button>
        </div>
    </div>
   
    <div class="container" Style = "font-size:10pt;">
        
        {{-- 
            TABLA DE PROCESOS/SUBPR VS AREAS/PUESTOS
                        FILAS           COLUMNAS
            --}}

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">
                        {{$tipoMatrizEscrita}}
                    </th>
                    <th scope="col"></th>
                    @foreach($listaColumnas as $itemColumna)
                        <th scope="col"> {{$itemColumna->nombre()}}</th>
                        <input type="hidden" name="nombreC<?php echo($itemColumna->id()) ?>" id="nombreC<?php echo($itemColumna->id()) ?>" value="<?php echo($itemColumna->nombre()) ?>">   
                            
                    @endforeach    
                </tr>  


                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    @foreach($listaColumnas as $itemColumna)
                        <th scope="col"  style="text-align: center;"> 
                            <input type="radio"  id="RB_C<?php echo($itemColumna->id()) ?>" name="columnas" value="RB_C<?php echo($itemColumna->id()) ?>">
                          
                            {{--   {{$itemColumna->id()}} --}}
                        </th>    
                    @endforeach  

                </tr>

            </thead>
            <tbody>
                @foreach($listaFilas as $itemFila)
                <tr> 
                    <td scope="col" style="text-align: center;"> {{$itemFila->nombre()}}</td>
                    <td  style="text-align: center;">   
                        <input type="radio" id="RB_F<?php echo($itemFila->id()) ?>" name="filas" value="RB_F{{$itemFila->id()}}">
                        <input type="hidden" name="nombreF<?php echo($itemFila->id()) ?>" id="nombreF<?php echo($itemFila->id()) ?>" value="<?php echo($itemFila->nombre()) ?>">   
                        {{--  {{$itemFila->id()}} --}}
                    </td>
                    @foreach($listaColumnas as $itemColumna)
                        <th scope="col" style="text-align: center; font-size: 13pt;"> 
                            <?php 
                                $contenido = ($celdaParaFuncion->getContenido($itemFila->id(),$itemColumna->id(),$matrizAEditar->idMatriz));
                                if($contenido=="X")
                                    echo($contenido);
                                else 
                                    echo("<small>".$contenido."</small>");
                                
                            ?>
                        </th>    
                    @endforeach          
                        
                  
                </tr>
                @endforeach  
            </tbody>
        </table>

        
        
         <div class="row" >
           
            
            <div class="w-100"></div>
            <div class="col" style = "text-align: center; position: relative; margin-top: 40px;">
                <a href="{{route('matriz.verinforme',$matrizAEditar->idMatriz)}}" class = "btn btn-primary"> 
                    <i class="fas fa-eye"> </i> 
                    Visualizar Informe
                  </a>
            </div>
            <div class="col" style = "text-align: center; position: relative; margin-top: 40px;">
 
            </div>
        </div> 

    </div>

</form>
@endsection






{{--  GA GA GA A SODISA DSA JSDJ SDAJJ DSAJDSA JASDJL DSJAJDSAJLKADSJLK DSAJLKDSA DSAJL JLKDSAJLKD SAJKL DSAJLK --}}