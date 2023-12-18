@extends('layouts.principal')

@section('title') Aerolineas | Sistema de Carguera v1.1 @stop
@section('css')
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">    
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">    
@endsection
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Aerolineas
               @can('haveaccess', 'airline.create')
                  <a href="{{ route('airline.create') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Aerolineas</li>
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
            @can('haveaccess', 'airline.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Aerolineas</h3>
                     <div class="card-tools">
                        {{ $airlines->links() }}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-sm" id="table-airline" style="width:100%">
                           <thead>
                              <tr>
                                 <th class="text-center" scope="col">Nombre</th>
                                 <th class="text-center" scope="col">RUC</th>
                                 <th class="text-center" scope="col">Teléfono</th>
                                 <th class="text-center" scope="col">Correo</th>
                                 <th class="text-center" width="250px">@can('haveaccess', 'airline.edit')Editar @endcan @can('haveaccess', 'airline.destroy')Eliminar @endcan</th>
                              </tr>
                           </thead>
                           <tbody> 
                              @foreach ($airlines as $item)
                                 <tr>
                                    <td class="text-center">{{ Str::upper($item->name) }}</td>
                                    <td class="text-center">{{ $item->ruc }}</td>
                                    <td class="text-center">{{ $item->phone }}</td>
                                    <td class="text-center">{{ $item->email }}</td>
                                    <td width="250px" class="text-center">
                                       {{-- @can('haveaccess', 'airline.show')
                                          <a href="{{ route('airline.show', $item->id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                                       @endcan --}}
                                       @can('haveaccess', 'airline.edit')
                                          <a href="{{ route('airline.edit', $item->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                       @endcan
                                       @can('haveaccess', 'airline.destroy')
                                          {{ Form::open(['route' => ['airline.destroy', $item->id], 'method' => 'DELETE', 'style' => 'display: inline-block']) }}
                                             {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Aerolinea', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la Aerolinea?")']) }}
                                          {{ Form::close() }}
                                       @endcan
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     
                  </div>
               </div>
            @endcan
            <!-- /.card -->
         </div>
      </div>
   </div>
</section>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
       $(document).ready( function () {
            $('#table-airline').DataTable({
               "language": {
                     "lengthMenu": "Mostrar _MENU_ registros por página",
                     "zeroRecords": "No se encontró nada, lo siento",
                     "info": "Mostrando página _PAGE_ de _PAGES_",
                     "infoEmpty": "No hay registros disponibles",
                     "infoFiltered": "(filtrado de _MAX_ registros totales)",
                     "search": "Buscar:",
                     "pagingType": "full_numbers",
                     'paginate': {
                        'previous': 'Anterior',
                        'next': 'Siguiente'
                     }
               }
         });
      });
    </script>
@endsection
