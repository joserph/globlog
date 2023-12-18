@extends('layouts.principal')

@section('title') Coordinaciones Aéreas | Sistema de Carguera v1.1 @stop

@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Coordinaciones Aéreas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('flight.index') }}">Vuelos</a></li>
               <li class="breadcrumb-item"><a href="{{ route('flight.show', $flight->id) }}">AWB {{ $flight->awb }}</a></li>
               <li class="breadcrumb-item active">Coordinaciones Aéreas</li>
            </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>


  <!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-12">

            @include('custom.message') 

            <div class="card">
               <div class="card-header">
                  Coordinaciones Vuelo AWB {{ $flight->awb }} @if ($flight->type_awb == 'own')
                  <span class="badge badge-success">PROPIA</span>
                 @else
                 <span class="badge badge-secondary">EXTERNA</span>
                 @endif
               </div>
               <div class="card-body">
                     <div class="row">
                        <div class="col-sm-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">AWB {{ $flight->awb }}</h5>
                              <p class="card-text">{{ date('d/m/Y', strtotime($flight->date)) }}</p>
                              <p class="card-text">{{ $company->name }}</p>
                              @can('haveaccess', 'distribution.create')
                              <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#agregarItem">
                                 <i class="fas fa-plus-circle"></i> Crear Item
                              </button>
                              @endcan
                            </div>
                          </div>
                          <a href="{{ route('distribution.pdf', $flight) }}" target="_blank" class="btn btn-xs btn-outline-success pull-right"><i class="far fa-file-pdf"></i> COMPLETO</a>
                          <a href="{{ route('distributionUncoordinated.pdf', $flight) }}" target="_blank" class="btn btn-xs btn-outline-info pull-right"><i class="far fa-file-pdf"></i> SOLO RECIBIDO</a>
                          <a href="{{ route('distributionForDelivery.pdf', $flight) }}" target="_blank" class="btn btn-xs btn-outline-primary pull-right"><i class="far fa-file-pdf"></i> PARA DELIVERY</a>
                          <a href="{{ route('distribution.excel', $flight) }}" target="_blank" class="btn btn-xs btn-outline-success pull-right"><i class="fas fa-file-excel"></i> CONFIRMACIÓN Y DISTRIBUCIÓN</a>
                          <!--
                          <div class="form-group col-md-12">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                              <input type="checkbox" class="custom-control-input" id="switchCoord">
                              <label class="custom-control-label" for="switchCoord">Transferir coordinación</label>
                              </div>
                           </div>
                           <a href="#" id="ListCoord" class="btn btn-xs btn-outline-success pull-right"><i class="fas fa-exchange-alt"></i></a>

                           <div class="row listaSelect">
                              <div class="card">
                                 <div class="card-body">
                                    <h3>Fincas seleccionadas</h3>
                                    <br>

                                    <ul id="lista" class="list-group"></ul>
                                 </div>
                                 <div class="card-footer">
                                    <a href="{{ route('transfer-coordination', $flight) }}" value="Hola" id="btnTransf" class="btn btn-xs btn-outline-info pull-right"><i class="fas fa-exchange-alt"></i> Transferir</a>
                                 </div>
                              </div>
                           </div>
                        -->
                        </div>
                        <div class="col-sm-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Resumen coordinación</h5>
                              <table class="table table-hover table-sm">
                                 @php
                                     $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $totalPieces = 0;
                                 @endphp
                                 <thead>
                                    <tr class="gris">
                                        <th>Clientes</th>
                                        <th class="text-center">PCS</th>
                                        <th class="text-center">HB</th>
                                        <th class="text-center">QB</th>
                                        <th class="text-center">EB</th>
                                    </tr>
                                </thead>
                                 @foreach($clientsDistribution as  $key => $client)
                                 
                                 <tbody>
                                     @php
                                         $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0;
                                     @endphp
                                     @foreach($distributions as $item)
                                     @if($client['id'] == $item->id_client)
                                       @php
                                          $tPieces+= $item->pieces;
                                          $tFulls+= $item->fulls;
                                          $tHb+= $item->hb;
                                          $tQb+= $item->qb;
                                          $tEb+= $item->eb;
                                       @endphp
                                       
                                       @endif
                                     @endforeach
                                     @php
                                       $totalFulls+= $tFulls;
                                       $totalHb+= $tHb;
                                       $totalQb+= $tQb;
                                       $totalEb+= $tEb;
                                    @endphp
                                    <tr @foreach ($colors as $color)
                                        @if ($color->id_type == $client['id'])
                                        style="background-color: {{ $color->color }}; color: #FFFFFF;"
                                        @endif
                                    @endforeach >
                                       <td><strong>{{ $client['name'] }}</strong></td>
                                       <td class="text-center">{{ $tPieces }}</td>
                                       <td class="text-center">{{ $tHb }}</td>
                                       <td class="text-center">{{ $tQb }}</td>
                                       <td class="text-center">{{ $tEb }}</td>
                                   </tr>
                                 </tbody>
                                 <tfoot>
                                 @endforeach
                                 @php
                                     $totalPieces+= $totalHb + $totalQb + $totalEb;
                                 @endphp
                                     <tr>
                                         <th>Total Global:</th>
                                         <th class="text-center">{{ $totalPieces }}</th>
                                         <th class="text-center">{{ $totalHb }}</th>
                                         <th class="text-center">{{ $totalQb }}</th>
                                         <th class="text-center">{{ $totalEb }}</th>
                                     </tr>
                                 </tfoot>
                             </table>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                  
               </div>
               <div class="card-footer">
                  <!-- tabla de coordinaciones -->
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered border-primary">
                        @php
                            $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $totalPcsr = 0; $totalHbr = 0; $totalQbr = 0;
                            $totalEbr = 0; $totalFullsr = 0; $totalDevr = 0; $totalMissingr = 0;
                        @endphp
                        @foreach($clientsDistribution as $client)
                        <thead>
                            <tr>
                                <th colspan="18" class="sin-border"></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr @foreach ($colors as $color)
                            @if ($color->id_type == $client['id'])
                            style="background-color: {{ $color->color }}; color: #FFFFFF;"
                            @endif
                        @endforeach>
                                <th class="text-center medium-letter">AWB</th>
                                <th class="text-center medium-letter" colspan="17">{{ $client['name'] }}</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="gris">
                              <th class="text-center transfLavel">Transferir</th>
                              <th class="text-center">Finca</th>
                              <th class="text-center">HAWB</th>
                              <th class="text-center">Variedad</th>
                              <th class="text-center table-secondary">PCS</th>
                              <th class="text-center table-secondary">HB</th>
                              <th class="text-center table-secondary">QB</th>
                              <th class="text-center table-secondary">EB</th>
                              <th class="text-center table-secondary">FULL</th>
                              <th class="text-center table-success">PCS</th>
                              <th class="text-center table-success">HB</th>
                              <th class="text-center table-success">QB</th>
                              <th class="text-center table-success">EB</th>
                              <th class="text-center table-success">FULL</th>
                              <th class="text-center table-warning">Dev</th>
                              <th class="text-center">Faltantes</th>
                              <th class="text-center">Observación</th>
                              <th class="text-center" colspan="2">Aciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0; $totalPieces = 0; $tPcsR = 0;
                                 $tHbr = 0; $tQbr = 0; $tEbr = 0; $tFullsR = 0; $tDevR = 0; $tMissingR = 0;
                            @endphp
                            
                            @foreach($distributions as $item)
                            @if($client['id'] == $item->id_client)
                            @php
                                $tPieces+= $item->pieces;
                                $tFulls+= $item->fulls;
                                $tHb+= $item->hb;
                                $tQb+= $item->qb;
                                $tEb+= $item->eb;
                                $tPcsR+= $item->pieces_r;
                                 $tHbr+= $item->hb_r;
                                 $tQbr+= $item->qb_r;
                                 $tEbr+= $item->eb_r;
                                 $tFullsR+= $item->fulls_r;
                                 $tDevR+= $item->returns;
                                 $tMissingR+= $item->missing;
                            @endphp
                            <tr>
                               <!--<td class="text-center"><input type="checkbox" class="transf" name="{{ $item->id }}" value="{{ $item->id }}" placeholder="{{ $item->name }} - {{ $client['name'] }} - {{ $item->pieces }}"></td>-->
                                <td class="farms">{{ $item->name }}</td>
                                <td class="text-center">{{ $item->hawb }}</td>
                                <td class="text-center">{{ $item->variety->name }}</td>
                                <td class="text-center">{{ $item->pieces }}</td>
                                <td class="text-center">{{ $item->hb }}</td>
                                <td class="text-center">{{ $item->qb }}</td>
                                <td class="text-center">{{ $item->eb }}</td>
                                <td class="text-center">{{ number_format($item->fulls, 3, '.','') }}</td>
                                <td class="text-center">{{ $item->pieces_r }}</td>
                                <td class="text-center">{{ $item->hb_r }}</td>
                                <td class="text-center">{{ $item->qb_r }}</td>
                                <td class="text-center">{{ $item->eb_r }}</td>
                                <td class="text-center">{{ number_format($item->fulls_r, 3, '.','') }}</td>
                                <td class="text-center">{{ $item->returns }}</td>
                                <td class="text-center">{{ $item->missing }}</td>
                                <td class="text-center text-danger"><small>
                                    @if($item->id_marketer)
                                       COMPRA DE {{ strtoupper($item->marketer->name) }} 
                                    @endif
                                    @if ($item->observation)
                                       ({{ strtoupper($item->observation) }})
                                    @endif
                                 </small></td>
                                <td class="text-center">
                                    @can('haveaccess', 'distribution.edit')
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editarItem{{ $item->id }}">
                                       <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    @endcan
                                    @can('haveaccess', 'distribution.destroy')
                                    <td width="20px" class="text-center">
                                       {{ Form::open(['route' => ['distribution.destroy', $item->id], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar usuario', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar la coordinación?")']) }}
                                       {{ Form::close() }}
                                    </td>
                                    @endcan
                               </td>
                            </tr>
                            <div class="modal fade" id="editarItem{{ $item->id }}" tabindex="-1" aria-labelledby="editarItemLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="editarItemLabel">Editar item de coordinación</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       @include('custom.message') 
                                       {{ Form::model($item, ['route' => ['distribution.update', $item->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                                          <div class="modal-body">
                                             @include('distribution.partials.formEdit')
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
                            
                            @php
                                 $totalFulls+= $tFulls;
                                 $totalHb+= $tHb;
                                 $totalQb+= $tQb;
                                 $totalEb+= $tEb;
                                 $totalPcsr+= $tPcsR;
                                 $totalHbr+= $tHbr;
                                 $totalQbr+= $tQbr;
                                 $totalEbr+= $tEbr;
                                 $totalFullsr+= $tFullsR;
                                 $totalDevr+= $tDevR;
                                 $totalMissingr+= $tMissingR;
                              @endphp
                           <tr class="gris">
                              <th class="text-center text-right" colspan="3">Total:</th>
                              <th class="text-center">{{ $tPieces }}</th>
                              <th class="text-center">{{ $tHb }}</th>
                              <th class="text-center">{{ $tQb }}</th>
                              <th class="text-center">{{ $tEb }}</th>
                              <th class="text-center">{{ number_format($tFulls, 3, '.','') }}</th>
                              <th class="text-center">{{ $tPcsR }}</th>
                              <th class="text-center">{{ $tHbr }}</th>
                              <th class="text-center">{{ $tQbr }}</th>
                              <th class="text-center">{{ $tEbr }}</th>
                              <th class="text-center">{{ number_format($tFullsR, 3, '.','') }}</th>
                              <th class="text-center">{{ $tDevR }}</th>
                              <th class="text-center">{{ $tMissingR }}</th>
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
                                <th class="text-center" colspan="3">Total Global:</th>
                                <th class="text-center">{{ $totalPieces }}</th>
                                <th class="text-center">{{ $totalHb }}</th>
                                <th class="text-center">{{ $totalQb }}</th>
                                <th class="text-center">{{ $totalEb }}</th>
                                <th class="text-center">{{ number_format($totalFulls, 3, '.','') }}</th>
                                <th class="text-center">{{ $totalPcsr }}</th>
                                <th class="text-center">{{ $totalHbr }}</th>
                                <th class="text-center">{{ $totalQbr }}</th>
                                <th class="text-center">{{ $totalEbr }}</th>
                                <th class="text-center">{{ number_format($totalFullsr, 3, '.','') }}</th>
                                <th class="text-center">{{ $totalDevr }}</th>
                                <th class="text-center">{{ $totalMissingr }}</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                  <!-- fin tabla de coordinaciones -->
               </div>
            </div>
            
         </div>
         
         <div class="modal fade" id="agregarItem" tabindex="-1" aria-labelledby="agregarItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="agregarItemLabel">Agregar item de coordinación</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     @include('custom.message')
                     {{ Form::open(['route' => 'distribution.store', 'class' => 'form-horizontal']) }}
                        <div class="modal-body">
                           @include('distribution.partials.form')
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
   </div>
</section>

@section('scripts')
   <script>
      $('#id_farmEdit').select2({
         theme: 'bootstrap4',
      });

      $('#id_farm').select2({
         theme: 'bootstrap4',
      });
      $('#id_client').select2({
         theme: 'bootstrap4'
      });
      $('#variety_id').select2({
         theme: 'bootstrap4'
      });

      $(document).ready(function()
      {
         $('#transfCoord').hide();
         $('.transfLavel').hide();
         $('.transf').hide();
         $('#btnTransf').hide();
         $('#switchCoord').on('change', function() {
            if ($(this).is(':checked') ) {
               $('#transfCoord').show();
               $('#transfLavel').show();
               $('.transf').show();
            } else {
               $('#transfCoord').hide();
               $('#transfLavel').hide();
               $('.transf').hide();
            }
         });
      });

      // listar fincas selecionadas
      var lista = document.getElementById('lista');
      var checks_farm = document.querySelectorAll('.transf');
      var test = [];

      $('#ListCoord').click(function()
      {
         
         lista.innerHTML = '';
         checks_farm.forEach((e)=>{
            if(e.checked == true)
            {
               var elemento = document.createElement('li');
               elemento.className = 'list-group-item';
               elemento.innerHTML = e.placeholder;
               test.push(e.value)
               lista.appendChild(elemento);
               $('#btnTransf').show();
            }
            
         });
         /*$('#btnTransf').click(function()
         {
            $.ajax({
               url: "transfer-coordination",
               type: "POST",
               data: test,
               success: function(response)
               {
                  if(response)
                  {
                     $('#transfCoord').hide();
                     $('#transfLavel').hide();
                     $('.transf').hide();
                     $('#btnTransf').hide();
                     toastr.success('Transferencia exitosa');
                  }
               }
            });
         });*/
         
         for ( x in test) {
            console.log( test[x] );
         }
      });

      
   </script>

   
@endsection

@endsection
