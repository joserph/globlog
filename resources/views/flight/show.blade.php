@extends('layouts.principal')

@section('title') {{ $flight->awb }} | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>AWB - {{ $flight->awb }} - @if ($flight->type_awb == 'own')
              <span class="badge badge-success">PROPIA</span>
             @else
             <span class="badge badge-secondary">EXTERNA</span>
             @endif</h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('flight.index') }}">Vuelos</a></li>
                <li class="breadcrumb-item active">{{ $flight->awb }}</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <!-- Factura Master -->
            <div class="row">
              <!-- Coordinaciones -->
              @can('haveaccess', 'distribution.index')
              <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>{{ $distributionCount }}</h3>
    
                    <p>Cajas Coordinadas</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-plane-departure"></i>
                  </div>
                   <a href="{{ route('distribution.index', $flight->id) }}" class="small-box-footer">
                    Ver coordinaciones <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              @endcan
              @can('haveaccess', 'weight-distribution.index')
              <!-- Proyeccion de peso -->
              <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h3>{{ number_format($weightCount, 2, '.','') . ' KG' }}</h3>
    
                    <p>Proyeccion de peso</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-weight"></i>
                  </div>
                   <a href="{{ route('weight-distribution.index', $flight->id) }}" class="small-box-footer">
                    Ver Proyeccion de peso <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              @endcan
           </div>

        
        </div>
    </div>
</div>
@endsection
