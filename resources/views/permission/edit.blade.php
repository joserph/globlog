@extends('layouts.principal')

@section('title') Editar Permiso | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Editar Permiso</h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
             <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permisos</a></li>
             <li class="breadcrumb-item active">Editar Permiso</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">Editar permiso
                  <div class="card-tools">
                     <a href="{{ url()->previous() }}" class="btn btn-outline-warning btn-sm "><i class="fas fa-arrow-left"></i> Atras</a>
                  </div>
                </div>

                <div class="card-body">
                    
                   @include('custom.message')

                    {{ Form::model($permission, ['route' => ['permission.update', $permission->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                        @include('permission.partials.formE')
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                               <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-sync"></i> Actualizar</button>
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
