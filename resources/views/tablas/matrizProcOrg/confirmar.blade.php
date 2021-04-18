@extends('Layout.Plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar la siguiente matriz ?</h1> 
        
        
            idUnico : {{ $matriz->idMatriz }}
            <br>
            Nro de matriz en la Empresa: {{ $matriz->nroEnEmpresa }}
            <br>
            Tipo de Matriz: 
                <?php 
                        $texto="";
                        switch($matriz->tipoDeMatriz)
                        {
                          case 1:
                              $texto = "Procesos vs Areas";
                              break;
                          case 2:
                              $texto = "Procesos vs Puestos";
                              break;
                          case 3:
                              $texto = "Subprocesos vs Areas";
                              break;
                          case 4:
                              $texto = "Subprocesos vs Puesto";
                              break;
                        }
                        echo($texto);
                        
                ?> 
            <br>
            Descripcion de la matriz: {{ $matriz->descripcion }}
            <br>
            
        
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('matriz.destroy',$matriz->idMatriz)}}">
            @method('delete')
            @csrf

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('matriz.listar',$matriz->idEmpresa)}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection