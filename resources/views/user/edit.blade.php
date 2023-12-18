@extends('layouts.principal')
@section('css')
   <style>
      .hide{
         display: none;
      }
   </style>
   
@endsection
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Editar Usuarios</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Usuarios</a></li>
               <li class="breadcrumb-item active">Editar Usuario</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card card-warning">
            <div class="card-header">Editar Usuario</div>
               <div class="card-body">
                    
                  @include('custom.message')

                  {{ Form::model($user, ['route' => ['user.update', $user->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                     @include('user.partials.formE')
                     <hr>
                     <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                           <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-sync-alt"></i> Actualizar</button>
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
@section('scripts')
   <script>
      $('.id_farm').select2({
         theme: 'bootstrap4',
      });
      $('.id_client').select2({
         theme: 'bootstrap4',
      });

      let farms = document.getElementById('farms_input')
      let clients = document.getElementById('clients_input')
      let type_user = document.getElementById('type_user')
      type_user.addEventListener('change', (e) => {
         if(e.target.value == 'farm'){
            farms.classList.remove('hide')
            clients.classList.add('hide')
         }else if(e.target.value == 'charge_agency'){
            farms.classList.add('hide')
            clients.classList.remove('hide')
         }else{
            clients.classList.add('hide')
            farms.classList.add('hide')
         }
      })
   </script>
@endsection
