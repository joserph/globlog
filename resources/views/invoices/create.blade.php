@extends('layouts.principal')

@section('title') Crear Factura | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Crear Factura
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('invoices.index') }}">Facturas</a></li>
                <li class="breadcrumb-item active">Crear Factura</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



 @can('haveaccess', 'invoices.create')
    <!-- Button trigger modal -->
    <div class="container">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#createInvoice" >
            <i class="fas fa-plus-circle"></i> Crear
        </button>
    </div>
    @include('custom.message')
@endcan

<!-- Modal create header invoice -->
<div class="modal fade" id="createInvoice" tabindex="-1" aria-labelledby="createInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
       <div class="modal-header">
          <h5 class="modal-title" id="createInvoiceLabel">Crear Factura</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
       </div>
       <div class="modal-body">
          {{ Form::open(['route' => 'invoices.store', 'class' => 'form-horizontal']) }}
             <div class="modal-body">
               
                @include('invoices.partials.formHeader')
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-outline-primary" onclick="createInvoice()" id="createMasterInvoice" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                   <i class="fas fa-plus-circle"></i> Crear
             </button>
             </div>
          {{ Form::close() }}
       </div>
    </div>
    </div>
 </div>

@endsection
