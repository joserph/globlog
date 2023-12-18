@extends('layouts.principal')

@section('title') Variedades Flores | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Variedades Flores
               @can('haveaccess', 'varietiesflowers.create')
                  <a href="{{ route('varietiesflowers.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Variedades Flores</li>
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
            @can('haveaccess', 'varietiesflowers.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Variedades Flores</h3>
                     <div class="card-tools">
                        {{ $varietiesflowers->links() }}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                     <table class="table table-sm">
                        <thead class="thead-dark">
                           <tr>
                              <th scope="col">Nombre</th>
                              <th scope="col">Tipo</th>
                              <th class="text-center" width="80px" colspan="2">@can('haveaccess', 'varietiesflowers.edit')Editar @endcan @can('haveaccess', 'packing.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($varietiesflowers as $item)
                              <tr>
                                 <td>{{ strtoupper($item->name) }}</td>
                                 <td>{{ strtoupper($item->variety->name) }}</td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'varietiesflowers.edit')
                                       <a href="{{ route('varietiesflowers.edit', $item->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'varietiesflowers.destroy')
                                       {{ Form::open(['route' => ['varietiesflowers.destroy', $item->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Variedad de Flor', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la variedad de la flor?")']) }}
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
