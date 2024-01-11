@extends('layouts.principal')

@section('title') Perfil {{ ucwords(Auth::user()->name) }} | Sistema de Carguera v1.1 @stop

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1><a href="#"><i class="fas fa-back"></i> </a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Usuarios</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                src="{{ asset('/profiles') }}/{{ Auth::user()->profile }}"
                       alt="User profile picture">
                </div>
                <div>
                <form method="POST" action="{{ url('user/updateprofilepicture') }}" enctype="multipart/form-data" >
                  {{ csrf_field() }}
                  <div class="form-group">
                    <label for="">Cambiar foto de perfil</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="" name="image">
                        <label class="custom-file-label" for="">Subir foto</label>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-upload"></i> Subir Foto</button>
                </form>
                </div>
                
                <hr>

                <h3 class="profile-username text-center">{{ Str::title(Auth::user()->name) }}</h3>

                <p class="text-muted text-center">
                  @isset($user->roles[0]->name)
                    Role: {{ $user->roles[0]->name }}
                  @endisset
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item text-center">
                    <b>{{ Auth::user()->email }}</b>
                  </li>
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            {{-- <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div> --}}
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Configuracion</a></li>
                  <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Cambio de contraseña</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  


                  <!-- /.tab-pane -->

                  <div class="tab-pane active" id="settings">

                      @include('custom.message')

                    {{ Form::model($user, ['route' => ['user.update', $user->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                      
                        @include('user.partials.formP')
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                              <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-sync"></i> Actualizar</button>
                            </div>
                        </div>
                    {{ Form::close() }}


                      
                  </div>
                  <div class="tab-pane" id="password">

                    @include('custom.message')

                  <form action="{{ url('user/updatepassword') }}" method="POST">
                    {{ csrf_field() }}
                    @include('user.partials.formPass')
                    <hr>
                    <div class="form-group row">
                      <div class="col-sm-12">
                         <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-sync"></i> Actualizar</button>
                      </div>
                   </div>
                  </form>


                    
                </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
