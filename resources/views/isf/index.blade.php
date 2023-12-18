@extends('layouts.principal')

@section('title') ISF | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>ISF</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('load.index') }}">Cargas</a></li>
               <li class="breadcrumb-item"><a href="{{ route('load.show', $load->id) }}">{{ $load->bl }}</a></li>
               <li class="breadcrumb-item active">ISF</li>
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
                  Lista de fincas para ISF contenedor #{{ $load->shipment }}
                  <a href="{{ route('isf.pdf', $code) }}" target="_blank" class="btn btn-xs btn-outline-default pull-right"><i class="far fa-file-pdf"></i></a>
                  <a href="{{ route('isf.isf10_2Pdf', $code) }}" target="_blank" class="btn btn-xs btn-outline-info pull-right"><i class="far fa-file-pdf"></i></a>
               </div>

               @include('custom.message') 

               <!-- /.card-header -->
               <div class="card-body table-responsive p-0">
                  <table class="table">
                     <thead>
                        <tr>
                           <th class="text-center" scope="col">#</th>
                           <th class="text-center" scope="col">Finca</th>
                           <th class="text-center" scope="col">Teléfono</th>
                           <th class="text-center" scope="col">Dirección</th>
                           <th class="text-center" scope="col">Ciudad</th>
                           <th class="text-center" scope="col">Estado</th>
                           <th class="text-center" scope="col">País</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($farmsItemsLoad as $key => $item)
                            <tr>
                                <td class="text-center">{{ $count++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td class="text-center">{{ $item->city }}</td>
                                <td class="text-center">{{ $item->state }}</td>
                                <td class="text-center">{{ $item->country }}</td>
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
