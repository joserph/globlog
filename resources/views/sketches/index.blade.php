@extends('layouts.principal')

@section('title') Plano de Carga | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Plano de Carga</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('load.index') }}">Cargas</a></li>
               <li class="breadcrumb-item"><a href="{{ route('load.show', $load->id) }}">{{ $load->bl }}</a></li>
               <li class="breadcrumb-item active">Plano de Carga</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
<section class="content">
   @include('custom.message') 
   <div class="container-fluid">
      <div class="row">
         <!-- /.col -->
         <div class="col-md-12">
            {{ Form::open(['route' => 'sketches.store']) }}
               {!! Form::hidden('id_load', $load->id) !!}
               {!! Form::hidden('id_user', \Auth::user()->id) !!}
               {!! Form::hidden('update_user', \Auth::user()->id) !!}
               @if($space != 1)
               {!! Form::label('quantity', 'Seleccione la cantidad de espacios') !!}
               {!! Form::select('quantity', [
                  '18' => '18', 
                  '20' => '20',
                  '22' => '22',
                  '24' => '24'
                  ], 20, ['placeholder' => 'Seleccione espacios', 'class' => 'form-control col-md-3']) !!}
               @endif
               <button type="submit" class="btn btn-sm btn-primary" @if($space == 1) disabled @endif><i class="fas fa-plus-circle"></i> Generar espacios</button>
            {{ Form::close() }}
            @if($space == 1)
               {!! Form::open(['route' => ['sketches.destroy', $load->id], 'method' => 'DELETE', 'onclick' => 'return confirm("¿Seguro de revertir los espacios?")']) !!}
                  <button class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Revertir espacios"><i class="fas fa-history"></i> Revertir Espacios</button>
               {!! Form::close() !!}
            @endif

            <div class="card">
               <div class="card-header"></div>
               <div class="card-body">
                  <div class="row">
                     @foreach ($sketches as $key => $item)
                     <div class="col">
                        <div class="card @if($item->id_pallet) card-success @else card-default @endif collapsed-card">
                           <div class="card-header">
                              <h5 class="card-title">
                                 Espacio 
                                 <span class="badge rounded-pill bg-dark">{{ $item->space }}</span>
                                 @if($item->id_pallet)
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $key }}" data-toggle="tooltip" data-placement="top" title="Editar paleta en espacio">
                                       <i class="fas fa-edit"></i> Editar
                                    </button>
                                    Paleta <span class="badge rounded-pill bg-info text-dark">{{ $item->pallet->number }}</span>
                                 @else 
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal{{ $key }}" data-toggle="tooltip" data-placement="top" title="Agregar paleta en espacio">
                                       <i class="fas fa-plus-circle"></i> Agregar 
                                       
                                    </button>
                                 @endif
                              </h5>
                              <!-- Modal Pallet -->
                                 @include('sketches.partials.addPallet')
                              <!-- /Modal Pallets -->
                              <!-- Edit modal -->
                                 @include('sketches.partials.editPallet')
                              <!-- /Edit modal -->
                             <div class="card-tools">
                               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                               </button>
                             </div>
                             <!-- /.card-tools -->
                           </div>
                           <!-- List Pallet -->
                              @include('sketches.partials.listPallet')
                           <!-- /List Pallet -->
                         </div>
                     </div>
                     @if($key % 2 != 0)
                        <div class="w-100"></div>
                     @endif
                     @endforeach
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header">
                  Plano de Carga contenedor #{{ $load->shipment }}
               </div>
               <div class="card-body">
                  <div class="row">
                     @foreach ($sketches as $key => $item)
                        <div class="col">
                           <div class="row" style="height: 200px; border-style: solid; border-radius: 1px; border-width: 5px; padding-right: 0; padding-left: 0;">
                              <div class="col-4">
                                 @foreach ($pallets as $palle)
                                    @if ($palle->id == $item->id_pallet)
                                       {{$palle->counter}}
                                    @endif
                                 @endforeach
                              </div>
                              <div class="col-8">
                                 @foreach ($sketchPercent as $percent)
                                    @if ($item->id_pallet == $percent->id_pallet)
                                       @if ($percent->percent < 10)
                                          @php
                                             $newPercent = $percent->percent + 10;
                                          @endphp
                                       @elseif($percent->percent > 90 && $percent->percent < 100)
                                          @php
                                             $newPercent = $percent->percent - 10;
                                          @endphp
                                       @else
                                          @php
                                             $newPercent = $percent->percent;
                                          @endphp
                                       @endif
                                       <div style="height: {{ $newPercent }}%; 
                                       background-color: 
                                       @foreach ($colors as $color)
                                          @if ($color->id_type == $percent->id_client)
                                          {{ $color->color}}
                                          @endif
                                       @endforeach
                                       ">{{ $percent->client->name }}</div>
                                    @endif
                                 @endforeach
                              </div>
                           </div>
                        </div>
                        @if($key % 2 != 0)
                           <div class="w-100"></div>
                        @endif
                     @endforeach
                  </div>
                  <div class="container">
                     <div class="row">
                        
                        @foreach ($sketches as $key => $item)
                           
                           <div class="col" style="height: 200px; border-style: solid; border-radius: 1px; border-width: 5px; padding-right: 0; padding-left: 0;">
                              <div class="col">
                                 @foreach ($pallets as $palle)
                                    @if ($palle->id == $item->id_pallet)
                                       {{$palle->counter}}
                                    @endif
                                 @endforeach
                              </div>
                              <div class="espacio" style="height: 100%; width: 100%;">
                                 @foreach ($sketchPercent as $percent)
                                    @if ($item->id_pallet == $percent->id_pallet)
                                             @if ($percent->percent < 10)
                                                @php
                                                   $newPercent = $percent->percent + 10;
                                                @endphp
                                             @elseif($percent->percent > 90 && $percent->percent < 100)
                                                @php
                                                   $newPercent = $percent->percent - 10;
                                                @endphp
                                             @else
                                                @php
                                                   $newPercent = $percent->percent;
                                                @endphp
                                             @endif
                                             <div style="height: {{ $newPercent }}%; 
                                             background-color: 
                                             @foreach ($colors as $color)
                                                @if ($color->id_type == $percent->id_client)
                                                {{ $color->color}}
                                                @endif
                                             @endforeach
                                             ">{{ $percent->client->name }}</div>
                                          
                                       
                                    @endif
                                 @endforeach
                                 
                              </div>
                           </div>
                           @if($key % 2 != 0)
                              <div class="w-100"></div>
                           @endif
                        @endforeach
                        

                        
                     </div>
                     <hr>
                     
                     
                          
                      
                     
                      
                  </div>
                </div>
               
               <!-- /.card-body -->
            </div>
            <div class="card-footer text-muted">
               <div class="container">
                  <div class="row">
                     @php
                        $totalBoxes = 0;
                     @endphp
                  @foreach ($pallets as $item)
                     
                     
                          <div class="col-sm-6">
                           <li class="list-group-item d-flex justify-content-between align-items-center">
                              Paleta - {{ $item->number }}
                              <span class="badge bg-primary rounded-pill">{{ $item->quantity }} {{ $item->usda ? '- USDA' : ''}}</span>
                              </li>
                          </div>
                          @php
                              $totalBoxes+= $item->quantity;
                           @endphp

                  @endforeach
                  <hr>

                  <div class="col-sm-6">
                     <li class="list-group-item list-group-item-info d-flex justify-content-between align-items-center">
                        Total de cajas: 
                        <span class="badge bg-dark rounded-pill">{{ $totalBoxes }}</span>
                        </li>
                    </div>
               </div>
            </div>
             </div>
            <!-- /.card -->
         </div>
      </div>
   </div>
</section>
@endsection
