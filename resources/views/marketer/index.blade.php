@extends('layouts.principal')

@section('title') Comercializadoras | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Comercializadoras
               @can('haveaccess', 'marketer.create')
                  <a href="{{ route('marketer.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Comercializadoras</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- /.col -->
         <div class="col-md-12">
            @can('haveaccess', 'marketer.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Comercializadoras</h3>
                     <div class="card-tools">
                        {{ $marketers->links() }}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                     <table class="table table-sm">
                        <thead class="thead-dark">
                           <tr>
                              <th scope="col">Nombre</th>
                              <th scope="col">Clientes</th>
                              <th class="text-center" width="80px" colspan="2">@can('haveaccess', 'marketer.edit')Editar @endcan @can('haveaccess', 'marketer.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($marketers as $marketer)
                              <tr>
                                 <td>{{ $marketer->name }}</td>
                                 <td>{{ $marketer->clients }}</td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'marketer.edit')
                                       <a href="{{ route('marketer.edit', $marketer->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'marketer.destroy')
                                       {{ Form::open(['route' => ['marketer.destroy', $marketer->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Comercializadora', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la comercializadora?")']) }}
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
            @endcan
            <!-- /.card -->
         </div>
      </div>
   </div>
</section>
@endsection
