<!-- Sidebar Menu -->
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Solicitud de Fondos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
         

              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Empleado.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Empleado</p>
                </a>
              </li>
          
         
              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Gerente.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Gerente/Director</p>
                </a>
              </li>
          

              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Administracion.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Administrador</p>
                </a>
              </li>

            
              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Contador.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Contador</p>
                </a>
              </li>
           
              
            

        </ul>

      </li>




      <li class="nav-item has-treeview">
       
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Rendición de Gastos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">
         
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Empleado.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Empleado</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Gerente.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Gerente/Director</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Administracion.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Adminsitración</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Contador.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Contabilidad</p>
              </a>
            </li>
        
            

        </ul>

      </li>



      


      



      




      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Reposición de Gastos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Empleado</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Gerente.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Gerente/Director</p>
            </a>
          </li>
          

          
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Administracion.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Administración</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Contador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Contador</p>
            </a>
          </li>
        </ul>
      </li>


      

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Requerimientos BS
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Empleado</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Gerente.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Gerente/Director</p>
            </a>
          </li>
          

          
          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Administrador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Administración</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Contador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Contador</p>
            </a>
          </li>
        </ul>
      </li>








      <li class="nav-header">--------- Admin</li>

   
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            PERSONAL
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('GestionUsuarios.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Empleados</p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="{{route('GestiónPuestos.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Puestos</p>
            </a>
          </li>
          
          
        </ul>
      </li>


      
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            Proyectos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
         
          <li class="nav-item">
            <a href="{{route('GestiónProyectos.Listar')}}" class="nav-link">
            
              <p>Listar Proy</p>
            </a>
          </li>
          
            
          <li class="nav-item">
            <a href="{{route('EntidadFinanciera.listar')}}" class="nav-link">
              <p>Financieras</p>
            </a>
          </li>
          
            

          <li class="nav-item">
            <a href="{{route('TipoFinanciamiento.listar')}}" class="nav-link">
              <p>Tipos de Financiamiento</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('GestiónUnidadMedida.listar')}}" class="nav-link">
            
              <p>Unidades</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('PlanEstrategico.listar')}}" class="nav-link">
              <p>Plan Estratégico</p>
            </a>
          </li>

          


        </ul>
      </li>



      

        
       







      <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->
     
