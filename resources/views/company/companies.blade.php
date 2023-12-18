@extends('layouts.principal')

@section('title') Mi Empresa | Sistema de Carguera v1.1 @stop

@section('content')
   @can('haveaccess', 'companies')

   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                  <li class="breadcrumb-item active">Company</li>
               </ol>
            </div>
         </div>
      </div><!-- /.container-fluid -->
   </section>

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         @livewire('company-component')
      </div>
   </section>
   
   @endcan
@endsection
