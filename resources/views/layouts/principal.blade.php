<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title', 'Carga Hub v1.1')</title>
   
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Fonts -->
   <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

   <!-- Styles -->
   <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
   @yield('css')
   @livewireStyles
</head>


<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse">
   <!-- Site wrapper -->
   <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
         </ul>
         <!-- Right navbar links -->
         <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
               <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}"><!--{{ __('Login') }}--> Iniciar Sesión</a>
               </li>
               {{-- @if (Route::has('register'))
                  <li class="nav-item">
                     <a class="nav-link" href="{{ route('register') }}"><!--{{ __('Register') }}--> Registrar</a>
                  </li>
               @endif --}}
            @else
               <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                     <img src="{{ asset('/profiles') }}/{{ Auth::user()->profile }}" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">  
                     {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="{{ route('user.show', Auth::user()->id) }}">Mi perfil</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                           {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                  </div>
               </li>
            @endguest
         </ul>
         </nav>
         <!-- /.navbar -->
         <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
               <a href="{{ route('home') }}" class="brand-link elevation-4">
                  <img src="{{ asset('img/Logo_Carga_Hub_500.png') }}"
                  alt="Logo Carga Hub"
                  class="brand-image img-circle elevation-3"
                  style="opacity: .8">
                  <span class="brand-text font-weight-light">Carga Hub</span>
               </a>
               <!-- Sidebar -->
               <div class="sidebar">
                  <!-- Sidebar user (optional) -->
                  @guest
          
                  @else
                     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                           <img src="{{ asset('/profiles') }}/{{ Auth::user()->profile }}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                           <a href="{{ route('user.show', Auth::user()->id) }}" class="d-block">{{ ucwords(Auth::user()->name) }}</a>
                        </div>
                     </div>
                  @endguest
                  <!-- Sidebar Menu -->
                  @guest
          
                  @else
                     <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                           <!-- Add icons to the links using the .nav-icon class
                              with font-awesome or any other icon font library -->
                           <li class="nav-item has-treeview">
                              @can('haveaccess', 'user.index')
                                 <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                       Panel Usuario
                                       <i class="right fas fa-angle-left"></i>
                                    </p>
                                 </a>
                              @endcan
                              <ul class="nav nav-treeview">
                                 @can('haveaccess', 'user.index')
                                    <li class="nav-item">
                                       <a href="{{ route('user.index') }}" class="nav-link">
                                          <i class="fas fa-users nav-icon"></i>
                                          <p>Usuarios</p>
                                       </a>
                                    </li>
                                 @endcan
                                 @can('haveaccess', 'role.index')
                                    <li class="nav-item">
                                       <a href="{{ route('role.index') }}" class="nav-link">
                                          <i class="fas fa-address-book nav-icon"></i>
                                          <p>Roles</p>
                                       </a>
                                    </li>
                                 @endcan
                                 @can('haveaccess', 'permission.index')
                                    <li class="nav-item">
                                       <a href="{{ route('permission.index') }}" class="nav-link">
                                          <i class="fas fa-user-lock nav-icon"></i>
                                          <p>Permisos</p>
                                       </a>
                                    </li>
                                 @endcan
                              </ul>
                           </li>
                           @can('haveaccess', 'farms')
                              <li class="nav-item">
                                 <a href="{{ url('farms') }}" class="nav-link">
                                    <i class="nav-icon fas fa-spa"></i>
                                    <p>Fincas</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'clients')
                              <li class="nav-item">
                                 <a href="{{ url('clients') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>Clientes</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'varieties')
                              <li class="nav-item">
                                 <a href="{{ url('varieties') }}" class="nav-link">
                                    <i class="nav-icon fas fa-fan"></i>
                                    <p>Variedades</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'load.index')
                              <li class="nav-item">
                                 <a href="{{ route('load.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-truck-loading"></i>
                                    <p>Maritimos</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'flight.index')
                              <li class="nav-item">
                                 <a href="{{ route('flight.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plane"></i>
                                    <p>Vuelos</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'companies')
                              <li class="nav-item">
                                 <a href="{{ url('companies') }}" class="nav-link">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>Mi Empresa</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'logistics')
                              <li class="nav-item">
                                 <a href="{{ url('logistics') }}" class="nav-link">
                                    <i class="nav-icon fas fa-warehouse"></i>
                                    <p>Empresa de logística</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'color.index')
                              <li class="nav-item">
                                 <a href="{{ route('color.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-palette"></i>
                                    <p>Colores</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'marketer.index')
                              <li class="nav-item">
                                 <a href="{{ route('marketer.index') }}" class="nav-link">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <p>Comercializadoras</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'packing.index')
                              <li class="nav-item">
                                 <a href="{{ route('packing.index') }}" class="nav-link">
                                    <i class="fas fa-box"></i>
                                    <p>Observaciones Empaques</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'varietiesflowers.index')
                              <li class="nav-item">
                                 <a href="{{ route('varietiesflowers.index') }}" class="nav-link">
                                    <i class="fab fa-canadian-maple-leaf"></i>
                                    <p>Variedades Flores</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'qacompany.index')
                              <li class="nav-item">
                                 <a href="{{ route('qacompany.index') }}" class="nav-link">
                                    <i class="fas fa-certificate"></i>
                                    <p>Control de Calidad</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'dae.index')
                              <li class="nav-item">
                                 <a href="{{ route('dae.index') }}" class="nav-link">
                                    <i class="fas fa-file-invoice"></i>
                                    <p>DAEs</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'airline.index')
                              <li class="nav-item">
                                 <a href="{{ route('airline.index') }}" class="nav-link">
                                    <i class="fas fa-plane-departure"></i>
                                    <p>Aerolineas</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'itemforinvoice.index')
                              <li class="nav-item">
                                 <a href="{{ url('itemsforinvoices') }}" class="nav-link">
                                    <i class="fas fa-receipt"></i>
                                    <p>Items para Facturas</p>
                                 </a>
                              </li>
                           @endcan
                           @can('haveaccess', 'invoices.index')
                              <li class="nav-item">
                                 <a href="{{ route('invoices.index') }}" class="nav-link">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    <p>Facturas</p>
                                 </a>
                              </li>
                           @endcan
                           {{-- @can('haveaccess', 'distribution-client.index')
                              <li class="nav-item">
                                 <a href="{{ route('distribution-client.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plane"></i>
                                    <p>Coordinaciones Aéreas</p>
                                 </a>
                              </li>
                           @endcan --}}
                        </ul>
                     </nav>
                  @endguest
                  <!-- /.sidebar-menu -->
               </div>
               <!-- /.sidebar -->
            </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
            @yield('content')
              
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.1
    </div>
    <strong>Copyright &copy; 2023 <a target="_blank" href="#">Carga Hub</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Scripts -->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->

<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->
<script>
  $(function () {
    $('[data-toggle="popover"]').popover()
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>
<script src="{{ asset('js/app.js') }}"></script>
@livewireScripts
@yield('scripts')


</body>
</html>

