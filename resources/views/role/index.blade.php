@extends('layouts.principal')

@section('title') Lista de Role(s) | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Role(s)
               @can('haveaccess', 'role.create')
                  <a href="{{ route('role.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Crear</a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Role(s)</li>
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
                  Lista de roles

                  <div class="card-tools">
                     {{ $roles->links() }}
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
                           <th class="text-center" scope="col">Slug</th>
                           <th class="text-center" scope="col">Descripción</th>
                           <th class="text-center" scope="col">Full Acceso</th>
                           <th class="text-center" colspan="3">&nbsp;</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($roles as $role)
                        <tr>
                           <td class="text-center">{{ $role->id }}</td>
                           <td class="text-center">{{ $role->name }}</td>
                           <td class="text-center">{{ $role->slug }}</td>
                           <td class="text-center">{{ $role->description }}</td>
                           @if($role->full_access === 'no')
                              <td class="text-center"><span class="badge bg-warning">{{ $role->full_access }}</span></td>
                           @else
                              <td class="text-center"><span class="badge bg-success">{{ $role->full_access }}</span></td>
                           @endif

                           <td width="100px" class="text-center">
                              @can('haveaccess', 'role.show')
                                 <a href="{{ route('role.show', $role->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>
                              @endcan
                           </td>
                           <td width="100px" class="text-center">
                              @can('haveaccess', 'role.edit')
                                 <a href="{{ route('role.edit', $role->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                              @endcan
                           </td>
                           <td width="120px" class="text-center">
                              @can('haveaccess', 'role.destroy')
                                 {{ Form::open(['route' => ['role.destroy', $role->id], 'method' => 'DELETE']) }}
                                    {{ Form::button('<i class="fas fa-trash-alt"></i> ' . 'Eliminar', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar cliente', 'class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el role?")']) }}
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
