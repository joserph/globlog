@extends('layouts.principal')

@section('title') Crear Rol | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Crear Rol
               
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active"><a href="{{ route('role.index') }}">Role(s)</a></li>
               <li class="breadcrumb-item active">Crear Role</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">Crear Rol
                </div>

                <div class="card-body">
                    
                   @include('custom.message')

                    {{ Form::open(['route' => 'role.store', 'class' => 'form-horizontal']) }}
                        @include('role.partials.form')
                        <hr>
                        <div class="form-group row">
                           <div class="col-sm-12">
                              <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Crear</button>
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
