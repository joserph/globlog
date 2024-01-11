@extends('layouts.principal')

@section('content')
<div class="container">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0">Panel Principal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                  <li class="breadcrumb-item active">Panel Principal v1</li>
               </ol>
            </div><!-- /.col -->
         </div><!-- /.row -->
      </div><!-- /.container-fluid -->
   </div>
   
   <div class="row">
      @can('haveaccess', 'farms')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-info">
            <div class="inner">
               <h3>{{ $farms }}</h3>
               <p>Fincas Agregadas</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-spa"></i>
            </div>
            
               <a href="{{ url('farms') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'clients')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-success">
            <div class="inner">
               <h3>{{ $clients }}</h3>
               <p>Clientes</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-user-tie"></i>
            </div>
            
               <a href="{{ url('clients') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'varieties')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-warning">
            <div class="inner">
               <h3>{{ $varieties }}</h3>
               <p>Variedades</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-fan"></i>
            </div>
            
               <a href="{{ url('varieties') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'load.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-danger">
            <div class="inner">
               <h3>{{ $loads }}</h3>
               <p>Contenedores</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-truck-loading"></i>
            </div>
            
               <a href="{{ route('load.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'flight.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-primary">
            <div class="inner">
               <h3>{{ $flights }}</h3>
               <p>Vuelos</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-plane"></i>
            </div>
            
               <a href="{{ route('flight.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'companies')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-info">
            <div class="inner">
               <h3>{{ $company }}</h3>
               <p>{{ Str::title(Str::limit($companyName[0]->name, '16')) }}</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-building"></i>
            </div>
            
               <a href="{{ url('companies') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'logistics')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-success">
            <div class="inner">
               <h3>{{ $logisticCompany }}</h3>
               <p>{{ Str::title(Str::limit($logisticCompanyName[0]->name, '18')) }}</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-warehouse"></i>
            </div>
            
               <a href="{{ url('logistics') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'color.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-warning">
            <div class="inner">
               <h3>{{ $colors }}</h3>
               <p>Colores</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-palette"></i>
            </div>
            
               <a href="{{ route('color.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'marketer.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-danger">
            <div class="inner">
               <h3>{{ $marketers }}</h3>
               <p>Comercializadoras</p>
            </div>
            <div class="icon">
               <i class="fas fa-hand-holding-usd"></i>
            </div>
            
               <a href="{{ route('marketer.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'packing.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-primary">
            <div class="inner">
               <h3>{{ $packings }}</h3>
               <p>Observaciones Empaques</p>
            </div>
            <div class="icon">
               <i class="fas fa-box"></i>
            </div>
            
               <a href="{{ route('packing.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'varietiesflowers.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-info">
            <div class="inner">
               <h3>{{ $varietiesflowers }}</h3>
               <p>Variedades Flores</p>
            </div>
            <div class="icon">
               <i class="fab fa-canadian-maple-leaf"></i>
            </div>
            
               <a href="{{ route('varietiesflowers.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'qacompany.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-success">
            <div class="inner">
               <h3>{{ $qacampanies }}</h3>
               <p>Control de Calidad</p>
            </div>
            <div class="icon">
               <i class="fas fa-certificate"></i>
            </div>
               <a href="{{ route('qacompany.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'dae.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-warning">
            <div class="inner">
               <h3>{{ $daes }}</h3>
               <p>DAEs</p>
            </div>
            <div class="icon">
               <i class="fas fa-file-invoice"></i>
            </div>
            
               <a href="{{ route('dae.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'airline.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-danger">
            <div class="inner">
               <h3>{{ $airlines }}</h3>
               <p>Aerolineas</p>
            </div>
            <div class="icon">
               <i class="fas fa-plane-departure"></i>
            </div>
            
               <a href="{{ route('airline.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'itemforinvoice.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-primary">
            <div class="inner">
               <h3>{{ $itemsforinvoices }}</h3>
               <p>Items para Facturas</p>
            </div>
            <div class="icon">
               <i class="fas fa-receipt"></i>
            </div>
            
               <a href="{{ url('itemsforinvoices') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      @can('haveaccess', 'invoices.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-info">
            <div class="inner">
               <h3>{{ $invoices }}</h3>
               <p>Facturas</p>
            </div>
            <div class="icon">
               <i class="fas fa-file-invoice-dollar"></i>
            </div>
            
               <a href="{{ route('invoices.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan
      {{-- @can('haveaccess', 'distribution-client.index')
      <div class="col-lg-3 col-6">
         <div class="small-box bg-primary">
            <div class="inner">
               <h3>{{ $flights }}</h3>
               <p>Vuelos</p>
            </div>
            <div class="icon">
               <i class="nav-icon fas fa-plane"></i>
            </div>
            
               <a href="{{ route('distribution-client.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            
         </div>
      </div>
      @endcan --}}




   </div><!-- /end row -->
</div>
@endsection
