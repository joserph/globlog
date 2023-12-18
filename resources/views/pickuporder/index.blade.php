@extends('layouts.principal')

@section('title') Lista de Pick Up Order | Sistema de Carguera v1.1 @stop
@section('css')
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">    
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">    
@endsection
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Pick Up Order
               @can('haveaccess', 'pickuporder.create')
                  <a href="{{ route('pickuporder.create') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Pick Up Order</li>
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
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-user-lock"></i> Lista de Pick Up Order</h3>
                  
               </div>
 
               @include('custom.message') 
 
               <!-- /.card-header -->
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-sm" id="pickuporder-table" style="width:100%">
                        <thead>
                           <tr>
                              <th class="text-center" scope="col">Fecha</th>
                              <th scope="col">Fecha de Carga Inicial</th>
                              <th scope="col">Transportista</th>
                              <th scope="col">Chofer</th>
                              <th scope="col">Carrier #</th>
                              <th scope="col">Lugar de Recogida</th>
                              <th scope="col">Dirección de Recogida</th>
                              <th scope="col">Consignado A</th>
                              <th scope="col">Dirección de Entrega</th>
                              <th class="text-center" width="250px">@can('haveaccess', 'pickuporder.show')Ver @endcan @can('haveaccess', 'pickuporder.edit')Editar @endcan @can('haveaccess', 'pickuporder.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody> 
                           @foreach ($pickuporders as $pickuporder)
                              <tr>
                                 <td class="text-center">{{ $pickuporder->date }}</td>
                                 <td>{{ $pickuporder->loading_date }} / {{ $pickuporder->loading_hour }}</td>
                                 <td>{{ $pickuporder->carrier_company }}</td>
                                 <td>{{ $pickuporder->driver_name }}</td>
                                 <td>{{ $pickuporder->carrier_num }}</td>
                                 <td>{{ $pickuporder->pick_up_location }}</td>
                                 <td>{{ $pickuporder->pick_up_address }}</td>
                                 <td>{{ $pickuporder->consigned_to }}</td>
                                 <td>{{ $pickuporder->drop_off_address }}</td>

                                 <td width="250px" class="text-center">
                                    @can('haveaccess', 'pickuporder.show')
                                       <a href="{{ route('pickuporder.show', $pickuporder->id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan
                                 
                                    @can('haveaccess', 'pickuporder.edit')
                                       <a href="{{ route('pickuporder.edit', $pickuporder->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 
                                    @can('haveaccess', 'pickuporder.destroy')
                                       {{ Form::open(['route' => ['pickuporder.destroy', $pickuporder->id], 'method' => 'DELETE', 'style' => 'display: inline-block']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar permiso', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el permiso?")']) }}
                                       {{ Form::close() }}
                                    @endcan
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  
               </div>
               <div class="card-footer">
                  {{--<div class="card-tools text-right">
                     {{ $pickuporder->links() }}
                  </div>--}}
               </div>
               <!-- /.card-body -->
            </div>
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
       /*$(document).ready(function(){
         $('#pickuporder-table').DataTable({
            processing: true,
            serverSiver: true,
            ajax: '{!! route('dataTablePermission') !!}',
            columns: [
               {data: 'id'},
               {data: 'name'},
               {data: 'slug'},
               {data: 'description'},
               {data: 'created_at'},
               {data: 'btn'}
               //{data: 'show'},
               //{data: 'edit'}
            ]
         });
       });*/

       $(document).ready( function () {
            $('#pickuporder-table').DataTable({
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
