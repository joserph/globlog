@extends('layouts.principal')

@section('title') Facturas | Sistema de Carguera v1.1 @stop
@section('css')
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Facturas
               @can('haveaccess', 'invoices.create')
                  <a href="{{ route('invoices.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Facturas</li>
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
            @can('haveaccess', 'invoices.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Facturas</h3>
                     <div class="card-tools">
                        {{-- {{ $invoices->links() }} --}}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                     <table id="invoice-table" class="table table-sm compact" style="width:100%">
                        <thead class="thead-dark">
                           <tr>
                              <th scope="col">Num Factura</th>
                              <th scope="col" width="200px">Cliente</th>
                              <th scope="col">Fecha</th>
                              <th scope="col">Tipo Carga</th>
                              <th scope="col">BL/AWB</th>
                              <th scope="col">Valor</th>
                              <th width="80px" colspan="3">@can('haveaccess', 'load.show')Ver @endcan @can('haveaccess', 'load.edit')Editar @endcan</th>
                           </tr>
                        </thead>
                        {{-- <tbody>
                           @foreach ($invoices as $item)
                              <tr>
                                 <td>
                                    {{ $item->num_invoice }}
                                 </td>
                                 <td>
                                    {{ $item->client->name }}
                                 </td>
                                 <td>
                                    {{ date('d-m-Y', strtotime($item->date)) }}
                                 </td>
                                 <td>
                                    @if ($item->load_id)
                                       <h5><span class="badge badge-success">MARITIMO</span></h5>
                                    @else
                                       <h5><span class="badge badge-warning">AEREO</span></h5>
                                    @endif
                                 </td>
                                 <td>
                                    @php
                                       $load_info = App\Load::select('bl')->find($item->load_id);
                                       $flight_info = App\Flight::select('awb')->find($item->flight_id);
                                    @endphp
                                    @if ($item->load_id)
                                      {{ $load_info->bl }}
                                    @else
                                       {{ $flight_info->awb }}
                                    @endif
                                 </td>
                                 <td>${{ number_format($item->total_amount, 2, '.','') }}</td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'invoices.show')
                                       <a href="{{ route('invoices.show', $item->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'invoices.edit')
                                       <a href="{{ route('invoices.edit', $item->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'invoices.destroy')
                                       {{ Form::open(['route' => ['invoices.destroy', $item->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Vuelo', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el invoices?")']) }}
                                       {{ Form::close() }}
                                    @endcan
                                 </td>
                              </tr>
                           @endforeach
                        </tbody> --}}
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
@section('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
   $(document).ready(function(){
      $('#invoice-table').DataTable({
         processing: true,
         serverSider:true,
         ajax: '{!! route('dataTableInvoice') !!}',
         columns: [
            {data: 'num_invoice'},
            {data: 'client.name'},
            {data: 'date'},
            {data: 'type'},
            {data: 'load_flight'},
            {data: 'total_amount'},
            {data: 'btn'},
            // {data: 'edit'},
         ],
         order: [[0, 'desc']]
      });
   });
</script>
@endsection
