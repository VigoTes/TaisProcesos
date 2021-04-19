<table class="table table-striped table-valign-middle">
    <thead>
    <tr>
      <th>id</th>
      <th>Nombre de la Empresa</th>
      <th>RUC</th>
      <th>Direccion</th>
      <th>Opciones</th>
    
    </tr>
    </thead>
    <tbody>
    
    @foreach($listaEmpresas as $itemEmpresa)       
        <tr>
            <td>{{$itemEmpresa->idEmpresa  }}</td>
            <td>{{$itemEmpresa->nombreEmpresa  }}</td>
            <td>{{$itemEmpresa->ruc}}</td>
            <td>{{$itemEmpresa->direccion}}</td>
            
            <td>


                    {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                <a href="{{route('empresa.edit',$itemEmpresa->idEmpresa)}}" class = "btn btn-warning">  
                    <i class="fas fa-edit"> </i> 
                    Editar
                </a>

                <a href="#" onclick="clickEliminar({{$itemEmpresa->idEmpresa}})" class = "btn btn-danger"> 
                    <i class="fas fa-trash-alt"> </i> 
                    Eliminar
                </a>


            </td>
        
        </tr>
    @endforeach
    
  

                  










    </tbody>
  </table>