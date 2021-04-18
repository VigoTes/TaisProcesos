<!DOCTYPE html>
<html lang="en">


  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FODA System</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">

    
    <!-- Font Awesome ESTOS SON LOS ICONOS WE XD-->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">


    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
 

  </head>
<body>
    <h2>Informe de Matriz</h2>
        <label for="nombreEmpresa">Nombre de la Empresa</label> <br>
        <input type="text" class="form-control"  
          id="nombreEmpresa" name="nombreEmpresa" disabled = "disabled" 
          value="{{$empresaFocus->nombreEmpresa}}">     <br>
        
        <label>N° matriz en la empresa</label>  <br>
        <input type="text" class="form-control"  
            id="nroMatrizEnEmpresa" name="nroMatrizEnEmpresa" disabled = "disabled" 
            value="{{$matrizAEditar->nroEnEmpresa}}"><br>
            
        <label>Descripcion de la matriz</label><br>
        <input type="text" class="form-control"  
                id="descripcionMatriz" name="descripcionMatriz" disabled = "disabled" 
                value="{{$matrizAEditar->descripcion}}"><br>

   
    <div class="container" Style = "font-size:12pt; margin-top:30px; ">
        Las siguientes {{$nombreFilas}} se encuentran sin {{$nombreColumnas}} asignadas: <br>
       
        <div style="margin-left:20px;">
            @if(count($listaFilasSinColumnas)==0)
                Ninguno
            @endif
            @foreach($listaFilasSinColumnas as $x)
                {{$x}} <br>
            @endforeach
        </div>

        Los siguientes {{$nombreColumnas}} se encuentran sin {{$nombreFilas}} asignados:  <br>
        
        
        <div style="margin-left:20px;">
            @if(count($listaColumnasSinFilas)==0)
              Ninguna
            @endif
            @foreach($listaColumnasSinFilas as $x)
                {{$x}} <br>
            @endforeach
        </div> 


        Los siguientes {{$nombreColumnas}} se encuentran sin {{$nombreFilas}} de los que ser responsables:  <br>
        
        
        <div style="margin-left:20px;">
            @if(count($listaColumnasSinX)==0)
                Ninguna
            @endif
            @foreach($listaColumnasSinX as $x)
                {{$x}} <br>
            @endforeach
        </div> 
        


        Los siguientes {{$nombreFilas}} se encuentran sin {{$nombreColumnas}} de los que ser responsables:  <br>
        
        
        <div style="margin-left:20px;">
            @if(count($listaFilasSinX)==0)
                Ninguna
            @endif
            @foreach($listaFilasSinX as $x)
                {{$x}} <br>
            @endforeach
        </div> 
        <br>
        
            {{-- 
            TABLA DE PROCESOS/SUBPR VS AREAS/PUESTOS
                        FILAS           COLUMNAS
            --}}

        <table border="1" >
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

        
        
        
    </div>


</body>

</html>


{{--  GA GA GA A SODISA DSA JSDJ SDAJJ DSAJDSA JASDJL DSJAJDSAJLKADSJLK DSAJLKDSA DSAJL JLKDSAJLKD SAJKL DSAJLK --}}