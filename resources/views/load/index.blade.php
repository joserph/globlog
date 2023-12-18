@extends('layouts.principal')

@section('title') Maritimos | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Maritimos
               @can('haveaccess', 'load.create')
                  <a href="{{ route('load.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i></a>
               @endcan
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active">Maritimos</li>
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
            @can('haveaccess', 'load.index')
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Lista de Maritimos</h3>
                     <div class="card-tools">
                        {{ $loads->links() }}
                     </div>
                  </div>
   
                  @include('custom.message') 
   
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                     <table class="table table-sm">
                        <thead class="thead-dark">
                           <tr>
                              <th class="text-center" scope="col">N°</th>
                              <th class="text-center" scope="col">Año</th>
                              <th class="text-center" scope="col">BL</th>
                              <th class="text-center" scope="col">Booking</th>
                              <th class="text-center" scope="col">Agencia</th>
                              <th class="text-center" scope="col">Sellos</th>
                              <!--<th class="text-center" scope="col">Transportista</th>-->
                              <th class="text-center" scope="col">Fecha Salida</th>
                              <th class="text-center" scope="col">Fecha Llegada</th>
                              <th class="text-center" scope="col">Termografo Fondo</th>
                              <th class="text-center" scope="col">Termografo Puerta</th>
                              <th class="text-center" scope="col">Clientes</th>
                              <th class="text-center" scope="col">Coordinado</th>
                              <th class="text-center" scope="col">Embarcado</th>
                              <th class="text-center" scope="col">Estatus de viaje</th>
                              <th class="text-center" width="80px" colspan="3">@can('haveaccess', 'load.show')Ver @endcan @can('haveaccess', 'load.edit')Editar @endcan @can('haveaccess', 'load.destroy')Eliminar @endcan</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($loads as $load)
                              @php
                                 $llegada = strtotime($load->arrival_date);
                                 $salida = strtotime($load->date);
                                 $dife = ($llegada - $salida);
                              @endphp
                              
                              <tr>
                                 <td class="text-center">{{ $load->shipment }}</td>
                                 <td class="text-center">{{ date('Y', strtotime($load->date)) }}</td>
                                 <td class="text-center">{{ $load->bl }}</td>
                                 <td class="text-center">{{ $load->booking }}</td>
                                 <td class="text-center">
                                    @foreach ($logistics_companies as $item)
                                       @if ($load->id_logistic_company == $item->id)
                                          {{ Str::limit($item->name, 15, '...') }}
                                       @endif
                                    @endforeach
                                 </td>
                                 <td>
                                    <button 
                                       type="button" 
                                       class="btn btn-outline-info btn-sm test" 
                                       data-toggle="popover" 
                                       title="Sellos" 
                                       data-content="
                                       CONTENEDOR N° --------> {{ $load->container_number }}
                                       SELLO BOTELLA ---------> {{ $load->seal_bottle }}
                                       SELLO CABLE ------------> {{ $load->seal_cable }}
                                       SELLO STICKER ----------> {{ $load->seal_sticker }}
                                       "
                                       >Ver Sellos
                                    </button>
                                 </td>
                                 <!--<td>{{ $load->carrier }}</td>-->
                                 <td class="text-center">{{ date('d/m/Y', strtotime($load->date)) }}</td>
                                 <td class="text-center">{{ date('d/m/Y', strtotime($load->arrival_date)) }}</td>
                                 <td class="text-center">{{ $load->code_deep }} - {{ $load->brand_deep }}</td>
                                 <td class="text-center">{{ $load->code_door }} - {{ $load->brand_door }}</td>
                                 <td>
                                    <button 
                                       type="button" 
                                       class="btn btn-outline-info btn-sm test" 
                                       data-toggle="popover" 
                                       title="Clientes" 
                                       data-content="
                                       @foreach ($coordination as $item)
                                          @if ($load->id == $item->id_load)
                                             - {{ strtoupper(str_replace('SAG-', '', $item->name)) }}
                                          @endif
                                       @endforeach
                                       "
                                       >Ver Clientes
                                    </button>
                                 </td>
                                 @php
                                    $totalCoord = 0;
                                    $totalEmbarq = 0;
                                 @endphp
                                 <td class="text-center">
                                    @foreach ($coordinacions as $item)
                                       @if ($load->id == $item->id_load)
                                          @php
                                             $totalCoord += $item->pieces;
                                          @endphp
                                       @endif
                                    @endforeach
                                    {{ $totalCoord }}
                                 </td>
                                 <td class="text-center">
                                    @foreach ($palletItem as $item2)
                                       @if ($load->id == $item2->id_load)
                                          @php
                                             $totalEmbarq += $item2->quantity;
                                          @endphp
                                       @endif
                                    @endforeach
                                    {{ $totalEmbarq }}
                                 </td>
                                 @php
                                    $fecha_actual = date("Y-m-d");
                                    /*$dias = date("d-m-Y",strtotime($fecha_actual."- 1 days"));*/
                                    $loadDate = new DateTime($load->date);
                                    $loadArrivalDate = new DateTime($load->arrival_date);
                                    $nowDate = new DateTime($fecha_actual);
                                    $totalTrip = $loadDate->diff($loadArrivalDate); // 14
                                    $advanced = $loadDate->diff($nowDate);
                                    
                                    if($advanced->d >= $totalTrip->d || $nowDate > $loadArrivalDate)
                                    {
                                       $percent = 100;
                                    }elseif($nowDate < $loadDate){
                                       $percent = 0;
                                    }else{
                                       $percent = $advanced->d*100/$totalTrip->d;
                                    }
                                 @endphp
                                 <td>
                                    <p style="margin-bottom: 0"><code>@if($percent == 100) Entregado @elseif($percent == 0) Próximo a salir @else En camino @endif</code></p>
                                    <div class="progress">
                                       <div class="progress-bar @if($percent == 100) bg-success @else bg-primary @endif progress-bar-striped" role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percent }}%">
                                          <span class="sr-only">{{ $percent }}% Complete (success)</span>
                                       </div>
                                    </div>
                                 </td>
                                 
                                 <!--<td>
                                    <div class="progress mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="15" style="width: 5%">
                                      <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                  </div>
                                 </td>-->
                                 <td width="45px" class="text-center">
                                    <!--<div class="btn-group">
                                       <a href="{{ route('load.show', $load->id) }}" type="button" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                       <a href="{{ route('load.edit', $load->id) }}" type="button" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                       {{ Form::open(['route' => ['load.destroy', $load->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar carga', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la carga?")']) }}
                                       {{ Form::close() }}
                                     </div>-->
                                    @can('haveaccess', 'load.show')
                                       <a href="{{ route('load.show', $load->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'load.edit')
                                       <a href="{{ route('load.edit', $load->id) }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endcan
                                 </td>
                                 <td width="45px" class="text-center">
                                    @can('haveaccess', 'load.destroy')
                                       {{ Form::open(['route' => ['load.destroy', $load->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar carga', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la carga?")']) }}
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
@section('scripts')
   <script>
      $(function () {
         $('.test').popover({
            container: 'body'
         })
      });
   </script>
@endsection
