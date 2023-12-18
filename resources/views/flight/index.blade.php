@extends('layouts.principal')

@section('title') Vuelos | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Vuelos
               @can('haveaccess', 'flight.create')
                  <a href="{{ route('flight.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Vuelos</li>
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
            @can('haveaccess', 'flight.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Vuelos</h3>
                     <div class="card-tools">
                        {{ $flights->links() }}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                     <table class="table table-sm">
                        <thead class="thead-dark">
                           <tr>
                              <th class="text-center" scope="col">AWB</th>
                              <th class="text-center" scope="col">Transportista</th>
                              <th class="text-center" scope="col">Código Termografo</th>
                              <th class="text-center" scope="col">Marca Termografo</th>
                              <th class="text-center" scope="col">Fecha Salida</th>
                              <th class="text-center" scope="col">Fecha Llegada</th>
                              <th class="text-center" scope="col">Tipo de AWB</th>
                              <th class="text-center" scope="col">Estatus</th>
                              <th class="text-center" scope="col">Ciudad Origen</th>
                              <th class="text-center" scope="col">País Origen</th>
                              <th class="text-center" scope="col">Ciudad Destino</th>
                              <th class="text-center" scope="col">País Destino</th>
                              {{-- <th class="text-center" scope="col">Estatus</th> --}}
                              <th class="text-center" class="text-center" width="80px" colspan="3">@can('haveaccess', 'flight.show')Ver @endcan @can('haveaccess', 'flight.edit')Editar @endcan @can('haveaccess', 'flight.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($flights as $flight)
                              <tr>
                                 <td class="text-center">{{ $flight->awb }}</td>
                                 <td class="text-center">
                                    @if ($flight->airline != NULL)
                                       {{ Str::upper($flight->airline->name) }}
                                    @else
                                       {{ Str::upper($flight->carrier) }}
                                    @endif
                                 </td>
                                 <td class="text-center">{{ $flight->code }}</td>
                                 <td class="text-center">{{ $flight->brand }}</td>
                                 <td class="text-center">{{ date('d/m/Y', strtotime($flight->date)) }}</td>
                                 <td class="text-center">{{ date('d/m/Y', strtotime($flight->arrival_date)) }}</td>
                                 {{-- <td class="text-center">
                                    <!--<div class="progress mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="15" style="width: 5%">
                                      <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                  </div>-->
                                 </td> --}}
                                 <td class="text-center">
                                    @if ($flight->type_awb == 'own')
                                       <span class="badge badge-success">PROPIA</span>
                                    @else
                                       <span class="badge badge-secondary">EXTERNA</span>
                                    @endif
                                 </td>
                                 <td class="text-center">
                                    @if ($flight->status == 'open')
                                       <span class="badge badge-primary"><i class="fas fa-lock-open"></i> ABIERTA</span>
                                    @else
                                       <span class="badge badge-dark"><i class="fas fa-lock"></i> CERRADA</span>
                                    @endif
                                 </td>
                                 <td class="text-center">{{ $flight->origin_city }}</td>
                                 <td class="text-center">{{ $flight->origin_country }}</td>
                                 <td class="text-center">{{ $flight->destination_city }}</td>
                                 <td class="text-center">{{ $flight->destination_country }}</td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'flight.show')
                                       <a href="{{ route('flight.show', $flight->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'flight.edit')
                                       <a href="{{ route('flight.edit', $flight->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'flight.destroy')
                                       {{ Form::open(['route' => ['flight.destroy', $flight->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Vuelo', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el vuelo?")']) }}
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
