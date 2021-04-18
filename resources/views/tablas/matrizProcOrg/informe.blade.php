@extends('Layout.Plantilla')
@section('contenido')

<h2>Informe de Matriz</h2>
        <label for="nombreEmpresa">Nombre de la Empresa</label> 
        <input type="text" class="form-control"  
          id="nombreEmpresa" name="nombreEmpresa" disabled = "disabled" 
          value="{{$empresaFocus->nombreEmpresa}}">     
        
        <label>N° matriz en la empresa</label> 
        <input type="text" class="form-control"  
            id="nroMatrizEnEmpresa" name="nroMatrizEnEmpresa" disabled = "disabled" 
            value="{{$matrizAEditar->nroEnEmpresa}}">
            
        <label>Descripcion de la matriz</label>
        <input type="text" class="form-control"  
                id="descripcionMatriz" name="descripcionMatriz" disabled = "disabled" 
                value="{{$matrizAEditar->descripcion}}">

   
    <div class="container" Style = "font-size:10pt; margin-top:30px; ">
        Las siguientes {{$nombreFilas}} se encuentran sin {{$nombreColumnas}} asignadas: <br>
       
        <div style="margin-left:20px;">
            @if(count($listaFilasSinColumnas)==0)
                Ninguno
            @endif
            @foreach($listaFilasSinColumnas as $x)
                - {{$x}} <br>
            @endforeach
        </div>

        Los siguientes {{$nombreColumnas}} se encuentran sin {{$nombreFilas}} asignados:  <br>
        
        
        <div style="margin-left:20px;">
            @if(count($listaColumnasSinFilas)==0)
              Ninguna
            @endif
            @foreach($listaColumnasSinFilas as $x)
            - {{$x}} <br>
            @endforeach
        </div> 


        Los siguientes {{$nombreColumnas}} se encuentran sin {{$nombreFilas}} de los que ser responsables:  <br>
        
        
        <div style="margin-left:20px;">
            @if(count($listaColumnasSinX)==0)
                Ninguna
            @endif
            @foreach($listaColumnasSinX as $x)
            - {{$x}} <br>
            @endforeach
        </div> 
        


        Los siguientes {{$nombreFilas}} se encuentran sin {{$nombreColumnas}} de los que ser responsables:  <br>
        
        
        <div style="margin-left:20px;">
            @if(count($listaFilasSinX)==0)
                Ninguna
            @endif
            @foreach($listaFilasSinX as $x)
            - {{$x}} <br>
            @endforeach
        </div> 
        <br>
        
        
        



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
                    
                    @foreach($listaColumnas as $itemColumna)
                        <th scope="col"> {{$itemColumna->nombre()}}</th>    
                    @endforeach    
                </tr>  


               

            </thead>
            <tbody>
                @foreach($listaFilas as $itemFila)
                <tr> 
                    <td scope="col"> {{$itemFila->nombre()}}</td>
                    
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

                <a href="{{route('matriz.exportarInformePDF',$matrizAEditar->idMatriz)}}" class="btn btn-primary btn-lg"> <i class="fas fa-download"></i> Pdf</a>
                
            </div>
            <div class="col" style = "text-align: center; position: relative; margin-top: 40px;">
                <a href="{{route('matriz.exportarInformeWord',$matrizAEditar->idMatriz)}}" class="btn btn-primary btn-lg"> <i class="fas fa-download"></i> Word</a>
                

            </div>
        </div>
    </div>


@endsection






{{--  GA GA GA A SODISA DSA JSDJ SDAJJ DSAJDSA JASDJL DSJAJDSAJLKADSJLK DSAJLKDSA DSAJL JLKDSAJLKD SAJKL DSAJLK --}}