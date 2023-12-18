@extends('layouts.principal')

@section('title') Ver {{ $role->name}} | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>{{ $role->name}}
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
             <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role(s)</a></li>
             <li class="breadcrumb-item active">{{ $role->name}}</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>


 <section class="content">
    <div class="container-fluid">
       <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">
                
                <i class="fas fa-user-lock"></i>
                Detalle del role
                
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <dl class="row">
                <dt class="col-sm-4">Nombre</dt>
                <dd class="col-sm-8">{{ $role->name }}</dd>
                <dt class="col-sm-4">Slug</dt>
                <dd class="col-sm-8">{{ $role->slug }}</dd>
                <dt class="col-sm-4">Descripcción</dt>
                <dd class="col-sm-8">{{ $role->description }}</dd>
                <dt class="col-sm-4">Full acceso</dt>
                <dd class="col-sm-8">
                  <label>{{ Form::radio('full_access', 'yes', true, ['disabled']) }} Si</label>
                  <label>{{ Form::radio('full_access', 'no', true, ['disabled']) }} No</label>
                </dd>
                <dt class="col-sm-4">Lista de Permisos</dt>
                <dd class="col-sm-8">
                  @foreach($permissions as $permission)
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" disabled value="{{ $permission->id }}" id="permission_{{ $permission->id }}" name="permission[]" 
                      
                      @if(is_array(old('permission')) && in_array("$permission->id", old('permission'))) checked 
                      @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role)) checked
                      @endif
                      >
                      <label class="form-check-label" for="permission_{{ $permission->id }}">
                          {{ $permission->id }} - {{ $permission->name }} <em>{{ $permission->description }}</em>
                      </label>
                  </div>
                  @endforeach
                </dd>
                </dl>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
       </div>
    </div>
 </section>


@endsection
