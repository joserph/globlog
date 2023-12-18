@extends('layouts.principal')

@section('title') Fincas | Sistema de Carguera v1.1 @stop

@section('content')
@can('haveaccess', 'farms')

<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Fincas</li>
            </ol>
         </div>
      </div>
      <div class="alert alert-warning alert-dismissible">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <h5><i class="icon fas fa-info"></i> Atención!</h5>
         Antes de crear una finca verificar en el buscador si esta se encuentra agregada, tanto por nombre como por nombre comercial y así evitar duplicados.
      </div>
   </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
<section class="content">
   <div class="container-fluid">
      @livewire('farm-component')
   </div>
</section>
@endcan



@endsection

