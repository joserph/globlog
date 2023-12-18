@extends('layouts.principal')

@section('title') Paletas | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Paletas
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('load.index') }}">Cargas</a></li>
               <li class="breadcrumb-item"><a href="{{ route('load.show', $load->id) }}">{{ $load->bl }}</a></li>
               <li class="breadcrumb-item active">Paletas</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>
<section class="content">
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-sm">
            @include('custom.message') 
            <h4>Paletas ingresadas contenedor #{{ $load->shipment }}</h4>
            @can('haveaccess', 'pallets.create')
               <button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" title="Agregar nuevas paletas"><i class="fas fa-plus-circle"></i> Agregar Paleta</button>
            @endcan
            <a href="{{ route('reports-client.excel', $load->id) }}" target="_blank" class="btn btn-xs btn-outline-success float-right"><i class="fas fa-file-excel"></i> INFORMES</a>
            <a href="{{ route('palletitems.excel', $load->id) }}" target="_blank" class="btn btn-xs btn-outline-success float-right"><i class="fas fa-file-excel"></i> PLANO DE CARGA</a>
            <hr>
            @if ($palletsExist)
               <div class="form-group">
                  {{ Form::model($palletsExist, ['route' => ['pallets.update', $palletsExist->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                     <div class="modal-body">
                        <div class="form-check">
                           <label class="form-check-label">
                              {!! Form::hidden('id_load', $load->id) !!}
                              {!! Form::hidden('id', $palletsExist->id) !!}
                              {!! Form::hidden('id_user', \Auth::user()->id) !!}
                              {!! Form::hidden('update_user', \Auth::user()->id) !!}
                              <input class="form-check-input" name="coordination" {{ ($palletsExist2) ? 'checked' : ''}} type="checkbox">
                           Usar fincas y clientes coordinados</label>
                           <button type="submit" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                              <i class="fas fa-sync"></i> Actualizar
                           </button>
                        </div>
                     </div>
                  {{ Form::close() }}
                  
               </div>
            @endif
            
               
               
                  
                  
                  
                  @foreach ($pallets as $indexKey =>$item)
                     <div class="card">
                        <div class="card-header">
                           <i class="fas fa-pallet"></i> Paleta # <span class="badge bg-dark">{{ $item->number }}</span>
                           <input type="hidden" name="prueba" id="prueba_{{ $indexKey }}" value="{{ $item->number }}">
                           
                           @can('haveaccess', 'palletitems.create')
                           <button type="button" onclick="mifuncion(this)" value="{{ $item->id }}" class="btn btn-xs btn-info float-right" data-toggle="modal" data-target="#addPalletItem_{{ $item->id }}" data-toggle="tooltip" data-placement="top" title="Agregar item de paleta">
                              <i class="fas fa-plus-circle"></i>
                           </button>
                           @endcan
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-sm">
                                 <thead>
                                 <tr>
                                    <th class="text-center">Finca</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Piso</th>
                                    <th class="text-center">HB</th>
                                    <th class="text-center">QB</th>
                                    <th class="text-center">EB</th>
                                    <th class="text-center">Total</th>
                                    <th colspan="2" class="text-center">Aciones</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                    @php
                                       $hb = 0; $qb = 0; $eb = 0; $total = 0;
                                    @endphp
                                    @foreach ($palletItem as $item2)
                                       @if($item->id == $item2->id_pallet)
                                          @php 
                                             $hb+=$item2->hb;
                                             $qb+=$item2->qb;
                                             $eb+=$item2->eb;
                                             $total+=$item2->quantity;
                                          @endphp
                                          <tr>
                                             <td>
                                                @foreach ($farms as $farm)
                                                   @if($item2->id_farm == $farm->id)
                                                      {{ strtoupper(Str::limit(str_replace('SAG-', '', $farm->name), '20')) }}
                                                   @endif
                                                @endforeach
                                             </td>
                                             <td class="text-center">
                                                @foreach ($clients as $client)
                                                   @if($item2->id_client == $client->id)
                                                      {{ strtoupper(Str::limit(str_replace('SAG-', '', $client->name), '8')) }}
                                                   @endif
                                                @endforeach
                                             </td>
                                             <td class="text-center">
                                                @if($item2->piso == 1)
                                                <span class="badge badge-warning">SI</span>
                                                @endif
                                             </td>
                                             <td class="text-center">{{ $item2->hb }}</td>
                                             <td class="text-center">{{ $item2->qb }}</td>
                                             <td class="text-center">{{ $item2->eb }}</td>
                                             <td class="text-center">{{ $item2->quantity }}</td>
                                             <td class="text-center" width="10px">
                                                @can('haveaccess', 'palletitems.edit')
                                                <button type="button" onclick="mifuncion2(this)" value="{{ $item2->id }}" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editPalletItem{{ $item2->id }}">
                                                   <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                @endcan
                                             </td>
                                             <td class="text-center" width="10px">
                                                @can('haveaccess', 'palletitems.destroy')
                                                {!! Form::open(['route' => ['palletitems.destroy', $item2->id], 'method' => 'DELETE', 'onclick' => 'return confirm("¿Seguro de eliminar item de paleta?")']) !!}
                                                   <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Eliminar item de paleta"><i class="fas fa-trash-alt"></i></button>
                                                {!! Form::close() !!}
                                                @endcan
                                             </td>
                                          </tr>
                                          <div class="modal fade" id="editPalletItem{{ $item2->id }}" tabindex="-1" aria-labelledby="editPalletItemLabel" aria-hidden="true">
                                             <div class="modal-dialog ">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h5 class="modal-title" id="editPalletItemLabel">Editar Pallet Items</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">&times;</span>
                                                      </button>
                                                   </div>
                                                   <div class="modal-body">
                                                      @include('custom.message') 
                                                      {{ Form::model($item2, ['route' => ['palletitems.update', $item2->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                                                         <div class="modal-body">
                                                            @include('palletitems.partials.formEdit')
                                                         </div>
                                                         <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                                                               <i class="fas fa-sync"></i> Actualizar
                                                            </button>
                                                         </div>
                                                      {{ Form::close() }}
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       @endif
                                    @endforeach
                                 </tbody>
                                 <tfoot>
                                    <tr>
                                       <th colspan="3" class="text-center">Totales</th>
                                       <th class="text-center">{{ $hb }}</th>
                                       <th class="text-center">{{ $qb }}</th>
                                       <th class="text-center">{{ $eb }}</th>
                                       <th class="text-center">{{ $total }}</th>
                                    </tr>
                                </tfoot>
                              </table>
                           </div>
                           @if(($counter - 1) == $item->counter)
                           @can('haveaccess', 'pallets.edit')
                              <button type="button" class="btn btn-xs btn-warning pull-right" data-toggle="modal" data-target="#editPallet" data-toggle="tooltip" data-placement="top" title="Editar nuevas paletas"><i class="fas fa-edit"></i> Editar</button>
                           @endcan
                           @can('haveaccess', 'pallets.destroy')
                                 {!! Form::open(['route' => ['pallets.destroy', $item->id], 'method' => 'DELETE']) !!}
                                    {!! Form::button('<i class="fas fa-trash-alt"></i> ' . 'Eliminar', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar paleta', 'class' => 'btn btn-xs btn-danger pull-right', 'onclick' => 'return confirm("¿Seguro de eliminar finca?")']) !!}
                                 {!! Form::close() !!}
                           @endcan
                                 
                                 <!-- Modal Edit Pallet -->
                                 <div class="modal fade" id="editPallet" tabindex="-1" role="dialog" aria-labelledby="editPalletLabel">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                             <div class="modal-header">
                                                <h5 class="modal-title" id="agregarItemLabel">Contenedor {{ $load->shipment }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                          <div class="modal-body">
                                                @include('custom.message')
                                                {{ Form::model($item, ['route' => ['pallets.update', $item->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                                                   <div class="modal-body">
                                                      @include('pallets.partials.formEdit')
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                                                      <button type="submit" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                                                         <i class="fas fa-sync"></i> Actualizar
                                                      </button>
                                                   </div>
                                                {{ Form::close() }}
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- /Modal Edit Pallet -->
                              
                           @endif
                        </div>
                     </div>

                     <!-- Modal Pallets Items -->
                     <div class="modal fade" id="addPalletItem_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="addPalletItemLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="agregarItemLabel">Paleta {{ $item->number }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                <div class="modal-body">
                                    @include('custom.message')
                     
                                    {{ Form::open(['route' => 'palletitems.store', 'class' => 'form-horizontal']) }}
                                        {!! Form::hidden('id_user', \Auth::user()->id) !!}
                                        {!! Form::hidden('update_user', \Auth::user()->id) !!}
                                        {!! Form::hidden('id_load', $load->id) !!}
                                       <input type="hidden" name="id_pallet" id="id_pallet" value="{{ $item->id }}" class="grupo">

                                        @include('palletitems.partials.form')
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-xs btn-primary"><i class="fas fa-plus-circle"></i> Agregar</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                     </div>
                    
                    <!-- End Modal Pallets Items -->
                  @endforeach
               
               
             
             <button class="btn btn-default  " type="button">
               HB <span class="badge">{{ $total_hb }}</span>
            </button>
            <button class="btn btn-primary" type="button">
               QB <span class="badge">{{ $total_qb }}</span>
            </button>
            <button class="btn btn-info" type="button">
               EB <span class="badge">{{ $total_eb }}</span>
            </button>
            <button class="btn btn-success" type="button">
               Total <span class="badge">{{ $total_container }}</span>
            </button>
            </div>
            <div class="col-sm">
             <div class="card text-white bg-dark">
               <div class="card-header">
                 Resumen de la carga - #{{ $load->shipment }}
                 <a href="{{ route('palletitems.pdf', $load) }}" target="_blank" class="btn btn-xs btn-outline-success pull-right"><i class="far fa-file-pdf"></i> Cierre PDF</a>
                 <a href="{{ route('closing.excel', $load) }}" target="_blank" class="btn btn-xs btn-outline-primary pull-right"><i class="far fa-file-excel"></i> Cierre Excel</a>
               </div>
               <div class="card-body">
                  <!-- tabla de coordinaciones -->
                  <div class="table-responsive">
                     <table class="table table-sm">
                         @php
                             $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $totalPcsr = 0; $totalHbr = 0; $totalQbr = 0;
                             $totalEbr = 0; $totalFullsr = 0; $totalDevr = 0; $totalMissingr = 0; $totalPieces = 0;
                         @endphp
                         @foreach($resumenCargaAll as $client)
                         <thead>
                             <tr>
                                 <th colspan="15" class="sin-border"></th>
                             </tr>
                         </thead>
                         <thead>
                             <tr>
                                 <th class="text-center medium-letter" colspan="5">{{ $client['name'] }}</th>
                             </tr>
                         </thead>
                         <thead>
                             <tr class="gris">
                               <th class="text-center">Fincas</th>
                               <th class="text-center">PCS</th>
                               <th class="text-center">HB</th>
                               <th class="text-center">QB</th>
                               <th class="text-center">EB</th>
                             </tr>
                         </thead>
                         <tbody>
                             @php
                                 $tPieces = 0; $tHb = 0; $tQb = 0; $tEb = 0; 
                             @endphp
                             @foreach($itemsCarga as $key => $item)
                             @if($client['id'] == $item['id_client'])
                             @php
                                 $tPieces+= $item['quantity'];
                                 $tHb+= $item['hb'];
                                 $tQb+= $item['qb'];
                                 $tEb+= $item['eb'];
                             @endphp
                             <tr>
                                 <td class="farms">{{ $item['farms'] }}</td>
                                 <td class="text-center">{{ $item['quantity'] }}</td>
                                 <td class="text-center">{{ $item['hb'] }}</td>
                                 <td class="text-center">{{ $item['qb'] }}</td>
                                 <td class="text-center">{{ $item['eb'] }}</td>
                             </tr>
                             
                             @endif
                             @endforeach
                             @php
                                  $totalHb+= $tHb;
                                  $totalQb+= $tQb;
                                  $totalEb+= $tEb;
                               @endphp
                            <tr class="gris">
                               <th class="text-center text-right">Total:</th>
                               <th class="text-center">{{ $tPieces }}</th>
                               <th class="text-center">{{ $tHb }}</th>
                               <th class="text-center">{{ $tQb }}</th>
                               <th class="text-center">{{ $tEb }}</th>
                            </tr>
                         </tbody>
                         <tfoot>
                         @endforeach
                         @php
                             $totalPieces+= $totalHb + $totalQb + $totalEb;
                         @endphp
                             <tr>
                                 <th colspan="8" class="sin-border"></th>
                             </tr>
                             <tr class="gris">
                                 <th class="text-center">Total Global:</th>
                                 <th class="text-center">{{ $totalPieces }}</th>
                                 <th class="text-center">{{ $totalHb }}</th>
                                 <th class="text-center">{{ $totalQb }}</th>
                                 <th class="text-center">{{ $totalEb }}</th>
                             </tr>
                         </tfoot>
                     </table>
                   </div>
                   <!-- fin tabla de coordinaciones -->
               </div>
             </div>
            </div>
         
      </div>
   </div>
</section>
<!-- Modal Create Pallets -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="agregarItemLabel">Contenedor {{ $load->shipment }}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
           <div class="modal-body">
               @include('custom.message')

               {{ Form::open(['route' => 'pallets.store', 'class' => 'form-horizontal']) }}
                  <div class="modal-body">
                     @include('pallets.partials.form')
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
<!-- /Modal Create Pallets -->


@endsection

@section('scripts')
<script>

function mifuncion(elemento) {
    var id_pallet = elemento.getAttribute('value');
    $(document).ready(function(){
        //alert(id_pallet);
        $(".grupo").keyup(function()
        {
            var hb = $('#hb_'+id_pallet).val();
            var qb = $('#qb_'+id_pallet).val();
            var eb = $('#eb_'+id_pallet).val();
            var total = parseFloat(hb) + parseFloat(qb) + parseFloat(eb);
            $('#total_'+id_pallet).val(parseFloat(total));
            console.log(total);
        });

        $('#farmsList_'+id_pallet).select2({
            theme: 'bootstrap4',
        });
        $('#clientsList_'+id_pallet).select2({
            theme: 'bootstrap4',
        });
    });
}

function mifuncion2(elemento) {
    var id_pallet = elemento.getAttribute('value');
    $(document).ready(function(){
        //alert(id_pallet);
        $(".grupo").keyup(function()
        {
            var hb = $('#edit_hb_'+id_pallet).val();
            var qb = $('#edit_qb_'+id_pallet).val();
            var eb = $('#edit_eb_'+id_pallet).val();
            var total = parseFloat(hb) + parseFloat(qb) + parseFloat(eb);
            $('#edit_total_'+id_pallet).val(parseFloat(total));
            console.log(total);
        });
        $('#edit_farmsList_'+id_pallet).select2({
            theme: 'bootstrap4',
        });
        $('#edit_clientsList_'+id_pallet).select2({
            theme: 'bootstrap4',
        });
        
    });
    
}
</script>

@endsection