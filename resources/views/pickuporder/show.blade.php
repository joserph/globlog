@extends('layouts.principal')

@section('title') Lista de Pick Up Order | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Pick Up Order Carrier #{{ $pickuporder->carrier_num }}</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item active"><a href="{{ route('pickuporder.index') }}">Pick Up Orders</a></li>
               <li class="breadcrumb-item active">Carrier #{{ $pickuporder->carrier_num }}</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

<section class="content">
   <div class="container-fluid">
      
        <div class="invoice p-3 mb-3">

            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i> Pick Up Order Carrier #{{ $pickuporder->carrier_num }}
                        <small class="float-right">Date: {{ $pickuporder->date }}</small>
                    </h4>
                </div>
            </div>
            
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    Pick Up Locations:
                    <address>
                        <strong>{{ $pickuporder->pick_up_location }}</strong><br>
                        {{ $pickuporder->pick_up_address }}<br>
                    </address>
                </div>
            
                <div class="col-sm-4 invoice-col">
                    Consigned To:
                    <address>
                        <strong>{{ $pickuporder->consigned_to }}</strong><br>
                        {{ $pickuporder->drop_off_address }}<br>
                    </address>
                </div>
            
                <div class="col-sm-4 invoice-col">
                    <b>Carrier #{{ $pickuporder->carrier_num }}</b><br>
                    <b>Loading Starting Date:</b> {{ $pickuporder->loading_date }} / {{ $pickuporder->loading_hour }}<br>
                    <b>Carrier Company:</b> {{ $pickuporder->carrier_company }}<br>
                    <b>Diver Name:</b> {{ $pickuporder->driver_name }}
                </div>
            </div>
            <a href="{{ route('pickuporder.pdf', $pickuporder) }}" target="_blank" class="btn btn-xs btn-outline-success pull-right"><i class="far fa-file-pdf"></i> Descargar</a>
        </div>
        <hr>
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#agregarItem">
            <i class="fas fa-plus-circle"></i> Crear Item
        </button>

        @include('custom.message')
        <hr>
        <!-- Lista de Pick Up -->
         <div class="table-responsive">
            <table class="table table-sm" id="pickuporder-table" style="width:100%">
               <thead class="thead-dark">
                  <tr>
                     <th class="text-center" scope="col">AWB Number</th>
                     <th class="text-center" scope="col">Description</th>
                     <th class="text-center" scope="col"># Of Pieces</th>
                     <th class="text-center" scope="col"># Of Pallets</th>
                     <th class="text-center" width="250px">@can('haveaccess', 'pickuporderitem.edit')Editar @endcan @can('haveaccess', 'pickuporderitem.destroy')Eliminar @endcan</th>
                  </tr>
               </thead>
               <tbody>
                  @php
                     $totalPcs = 0; $totalPallets = 0;
                  @endphp
                  @foreach ($pickuporderItems as $item)
                     <tr>
                        <td class="text-center">{{ $item->awb }}</td>
                        <td class="text-center">{{ $item->description }}</td>
                        <td class="text-center">
                           @if ($item->pieces)
                              {{ $item->pieces }} PCS.
                           @endif
                        </td>
                        <td class="text-center">
                           @if ($item->pallets && $item->pallets == 1)
                              {{ $item->pallets }} PALLET
                           @elseif($item->pallets && $item->pallets > 1)
                              {{ $item->pallets }} PALLETS
                           @endif
                        </td>

                        <td width="250px" class="text-center">
                           @can('haveaccess', 'pickuporderitem.edit')
                              <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editItem{{ $item->id }}">
                                 <i class="fas fa-edit"></i>
                              </button>
                           @endcan
                        
                           @can('haveaccess', 'pickuporderitem.destroy')
                              {{ Form::open(['route' => ['pickuporderitem.destroy', $item->id], 'method' => 'DELETE', 'style' => 'display: inline-block']) }}
                                 {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar Item', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el Item?")']) }}
                              {{ Form::close() }}
                           @endcan
                        </td>
                     </tr>

                     <div class="modal fade" id="editItem{{ $item->id }}" tabindex="-1" aria-labelledby="editItemLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="editItemLabel">Agregar item de Pick Up Order</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 @include('custom.message')
                                 {{ Form::model($pickuporderItems, ['route' => ['pickuporderitem.update', $item->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                                    <div class="modal-body">
                                       @include('pickuporderItem.partials.formEdit')
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                                       <button type="submit" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                                          <i class="fas fa-sync-alt"></i> Actualizar
                                       </button>
                                    </div>
                                 {{ Form::close() }}
                              </div>
                           </div>
                        </div>
                     </div>


                     @php
                        $totalPcs += $item->pieces; $totalPallets += $item->pallets;
                     @endphp
                  @endforeach
               </tbody>
               <tfoot>
                  <tr>
                     <th class="text-center" scope="col" colspan="2"></th>
                     <th class="text-center" scope="col">
                        @if ($totalPcs && $totalPcs == 1)
                           {{ $totalPcs }} PC.
                        @elseif($totalPcs && $totalPcs > 1)
                           {{ $totalPcs }} PCS.
                        @endif
                     </th>
                     <th class="text-center" scope="col">
                        @if ($totalPallets && $totalPallets == 1)
                           {{ $totalPallets }} PALLET
                        @elseif($totalPallets && $totalPallets > 1)
                           {{ $totalPallets }} PALLETS
                        @endif
                     </th>
                  </tr>
               </tfoot>
            </table>
         </div>
        <!-- End Lista de Pick Up -->

        <div class="modal fade" id="agregarItem" tabindex="-1" aria-labelledby="agregarItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="agregarItemLabel">Agregar item de Pick Up Order</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     @include('custom.message')
                     {{ Form::open(['route' => 'pickuporderitem.store', 'class' => 'form-horizontal']) }}
                        <div class="modal-body">
                           @include('pickuporderItem.partials.form')
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                           <button type="submit" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                              <i class="fas fa-plus-circle"></i> Crear
                           </button>
                        </div>
                     {{ Form::close() }}
                  </div>
               </div>
            </div>
        </div>


    </div>
</section>
@endsection
