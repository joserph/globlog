@extends('layouts.principal')

@section('title') Lista de usuarios | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Usuarios</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
               <li class="breadcrumb-item active">Usuarios</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- /.col -->
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  Lista de usuarios <a class="btn btn-primary" href="{{ route('user.create') }}">Crear Usuario</a>

                  <div class="card-tools">
                     {{ $users->links() }}
                  </div>
               </div>

               @include('custom.message')  

               <!-- /.card-header -->
               <div class="card-body table-responsive p-0">
                  <table class="table">
                     <thead>
                        <tr>
                           <th class="text-center" scope="col">#</th>
                           <th class="text-center" scope="col">Nombre</th>
                           <th class="text-center" scope="col">Email</th>
                           <th class="text-center" scope="col">Tipo Usuario</th>
                           @can('haveaccess', 'role.index')
                              <th class="text-center" scope="col">Role(s)</th>
                           @endcan
                           <th class="text-center" colspan="3">&nbsp;</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($users as $user)
                        <tr>
                           <td class="text-center">{{ $user->id }}</td>
                           <td class="text-center">{{ $user->name }}</td>
                           <td class="text-center">{{ $user->email }}</td>
                           <td class="text-center">{{ $user->type_user }}</td>
                           @can('haveaccess', 'role.index')
                              <td class="text-center">
                                 @isset($user->roles[0]->name)
                                    {{ $user->roles[0]->name }}
                                 @endisset
                              </td>
                           @endcan
                           <td width="100px" class="text-center">
                              @can('view', [$user, ['user.show', 'userown.show']])
                                 <a href="{{ route('user.show', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>
                              @endcan
                           </td>
                           <td width="100px" class="text-center">
                              @can('update', [$user, ['user.edit', 'userown.edit']])
                                 <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                              @endcan
                           </td>
                           <td width="120px" class="text-center">
                              @can('haveaccess', 'user.destroy')
                                 {{ Form::open(['route' => ['user.destroy', $user->id], 'method' => 'DELETE']) }}
                                    {{ Form::button('<i class="fas fa-trash-alt"></i> ' . 'Eliminar', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar usuario', 'class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el usuario?")']) }}
                                 {{ Form::close() }}
                              @endcan
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
         </div>
      </div>
   </div>
</section>



@endsection
