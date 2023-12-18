@extends('layouts.principal')

@section('content')
@can('haveaccess', 'logistics')

<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Empresas de Logítica</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
<section class="content">
   <div class="container-fluid">
      @livewire('invoice-header-component', [
         'id_load' => '$id_load', 
         'bl' => '$bl', 
         'id_company' => '$id_company', 
         'shipment' => '$shipment', 
         'company' => '$company',
         'id_logistics_company' => '$id_logistics_company',
         'logi' => '$logi'
      ])
   </div>
</section>
@endcan
@endsection
