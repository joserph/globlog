@extends('layouts.principal')

@section('title') Editar Comercializadora | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Editar Comercializadora
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('marketer.index') }}">Comercializadoras</a></li>
                <li class="breadcrumb-item active">Editar Comercializadora</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Comercializadora
                </div>

                <div class="card-body">
                    
                   @include('custom.message')

                     {{ Form::model($marketer, ['route' => ['marketer.update', $marketer->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                        @include('marketer.partials.form2')
                        <hr>
                        <div class="form-group row">
                           <div class="col-sm-12">
                              <button type="submit" class="btn btn-outline-warning"><i class="fas fa-sync-alt"></i></i></button>
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
