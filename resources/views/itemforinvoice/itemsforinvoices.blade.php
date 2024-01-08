@extends('layouts.principal')

@section('title') Items para Factura | Sistema de Carguera v1.1 @stop

@section('content')
@can('haveaccess', 'itemforinvoice')

<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Items para Factura</li>
            </ol>
         </div>
      </div>
      
   </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
<section class="content">
   <div class="container-fluid">
      @livewire('item-for-invoice-component')
   </div>
</section>
@endcan



@endsection

