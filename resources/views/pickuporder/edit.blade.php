@extends('layouts.principal')

@section('title') Editar Pick Up Order | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Editar Pick Up Order
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('pickuporder.index') }}">Pick Up Orders</a></li>
                <li class="breadcrumb-item active">Editar Pick Up Order</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Pick Up Order
                </div>

                <div class="card-body">
                    
                   @include('custom.message')

                    {{ Form::model($pickuporder, ['route' => ['pickuporder.update', $pickuporder->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                        @include('pickuporder.partials.formEdit')
                        <hr>
                        <div class="form-group row">
                           <div class="col-sm-12">
                                <button type="submit" class="btn btn-outline-warning"><i class="fas fa-sync"></i></button>
                           </div>
                        </div>
                    {{ Form::close() }}
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
