@extends('layouts.principal')

@section('title') Coordinaciones | Sistema de Carguera v1.1 @stop
@section('css')
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">    
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">    
@endsection
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Coordinaciones</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Coordinaciones</li>
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
                @if ($code == 0)
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @elseif ($code == 1)
                    <div class="alert alert-info" role="alert">
                        {{ $message }}
                    </div>
                @endif
                
                @can('haveaccess', 'distribution-client.index')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Coordinaciones ({{ $farm_user->farm->name }})</h3>
                    </div>
    
                    @include('custom.message') 
    
                    <div class="card-body">
                        @if ($code != 0)
                            @can('haveaccess', 'distribution-client.create')
                                {{-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#agregarItem">
                                    <i class="fas fa-plus-circle"></i> Crear Coordinación
                                </button> --}}
                                <a href="{{ route('distribution-client.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Crear Coordinación</a>
                            @endcan
                        @endif
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered border-primary" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">AWB</th>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">Finca</th>
                                        <th class="text-center">HAWB</th>
                                        <th class="text-center">Variedad</th>
                                        <th class="text-center table-secondary">PCS</th>
                                        <th class="text-center table-secondary">HB</th>
                                        <th class="text-center table-secondary">QB</th>
                                        <th class="text-center table-secondary">EB</th>
                                        <th class="text-center table-secondary">FULL</th>
                                        <th class="text-center" colspan="2">Aciones</th>
                                      </tr>
                                </thead>
                                <tbody> 
                                    @foreach($distributions as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->flight->awb }}</td>
                                            <td class="text-center">{{ $item->client->name }}</td>
                                            <td class="text-center">{{ $item->farm->name }}</td>
                                            <td class="text-center">{{ $item->hawb }}</td>
                                            <td class="text-center">{{ $item->variety->name }}</td>
                                            <td class="text-center">{{ $item->pieces }}</td>
                                            <td class="text-center">{{ $item->hb }}</td>
                                            <td class="text-center">{{ $item->qb }}</td>
                                            <td class="text-center">{{ $item->eb }}</td>
                                            <td class="text-center">{{ number_format($item->fulls, 3, '.','') }}</td>
                                            <td class="text-center">
                                                @can('haveaccess', 'distribution-client.edit')
                                                    <a href="{{ route('distribution-client.edit', $item->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('haveaccess', 'distribution-client.destroy')
                                                    {{ Form::open(['route' => ['distribution-client.destroy', $item->id], 'method' => 'DELETE', 'style' => 'display: inline-block']) }}
                                                        {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Coordinación', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la coordinacion?")']) }}
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
            
            <!-- /Modal de coordinacion -->
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
@endsection
