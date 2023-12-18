@extends('layouts.principal')

@section('title') Pesos Aéreos | Sistema de Carguera v1.1 @stop
@section('css')
    
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Pesos Aéreos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('flight.index') }}">Vuelos</a></li>
               <li class="breadcrumb-item"><a href="{{ route('flight.show', $flight->id) }}">AWB {{ $flight->awb }}</a></li>
               <li class="breadcrumb-item active">Pesos Aéreos</li>
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
                  PROYECCION DE PESO {{ $flight->awb }}
                  <a href="{{ route('weight-distribution.excel', $flight->id) }}" target="_blank" class="btn btn-xs btn-outline-success float-right"><i class="fas fa-file-excel"></i> PROYECCIÓN DE PESO</a>
               </div>
               
               <div class="card-body">
                  <!-- tabla de coordinaciones -->
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered border-primary">
                        @php
                            $totalHbr = 0; 
                            $totalQbr = 0;
                            $totalEbr = 0; 
                            $totalFullsr = 0; 
                            $totalRepotWeight = 0;
                        @endphp
                        @foreach($clientsDistribution as $client)
                        <thead>
                            <tr>
                                <th colspan="13" class="sin-border"></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th class="text-center medium-letter table-success" colspan="13">{{ $client['name'] }}</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="gris">
                              <th class="text-center" style="width: 115px">HAWB</th>
                              <th class="text-center">Reported Weight</th>
                              <th class="text-center">Promedio</th>
                              <th class="text-center">Largo</th>
                              <th class="text-center">Ancho</th>
                              <th class="text-center">Alto</th>
                              <th class="text-center">Resumen de Clientes</th>
                              <th class="text-center">HB</th>
                              <th class="text-center">QB</th>
                              <th class="text-center">EB</th>
                              <th class="text-center">Fulls</th>
                              <th class="text-center">Observaciones</th>
                              <th class="text-center" colspan="2" style="width: 80px">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                 $tHbr = 0; 
                                 $tQbr = 0; 
                                 $tEbr = 0; 
                                 $tFullsR = 0; 
                                 $subRepotWeight = 0;
                                 $subAverage = 0;
                            @endphp
                            
                            @foreach($distributions as $item)
                            @if($client['id'] == $item['id_client'])
                            @php
                                 $tHbr+= $item['hb_r'];
                                 $tQbr+= $item['qb_r'];
                                 $tEbr+= $item['eb_r'];
                                 $tFullsR+= $item['fulls_r'];
                            @endphp
                            <tr>
                                <td class="text-center">{{ $item['hawb'] }}</td>
                                <td class="text-center">
                                 @foreach($weightDistribution as $weight)
                                    @if($weight->id_distribution == $item['id'])
                                       @php $subRepotWeight+= $weight->report_w; @endphp
                                       {{ number_format($weight->report_w, 2, '.','') }}
                                    @endif
                                 @endforeach
                                </td>
                                <td class="text-center">
                                 @foreach($weightDistribution as $weight)
                                    @if($weight->id_distribution == $item['id'])
                                       @php $subAverage+= $weight->average; @endphp
                                       {{ number_format($weight->average, 2, '.','') }}
                                    @endif
                                 @endforeach
                                </td>
                                
                                <td class="text-center">
                                 @foreach($weightDistribution as $weight)
                                    @if($weight->id_distribution == $item['id'])
                                       {{ number_format($weight->large, 2, '.','') }}
                                    @endif
                                 @endforeach
                                </td>
                                <td class="text-center">
                                 @foreach($weightDistribution as $weight)
                                    @if($weight->id_distribution == $item['id'])
                                       {{ number_format($weight->width, 2, '.','') }}
                                    @endif
                                 @endforeach
                                </td>
                                <td class="text-center">
                                 @foreach($weightDistribution as $weight)
                                    @if($weight->id_distribution == $item['id'])
                                       {{ number_format($weight->high, 2, '.','') }}
                                    @endif
                                 @endforeach
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['hb_r'] }}</td>
                                <td class="text-center">{{ $item['qb_r'] }}</td>
                                <td class="text-center">{{ $item['eb_r'] }}</td>
                                <td class="text-center">{{ number_format($item['fulls_r'], 3, '.','') }}</td>
                                <td class="text-center">
                                    @foreach($weightDistribution as $weight)
                                       @if($weight->id_distribution == $item['id'])
                                          {{ $weight->packing->description }}
                                       @endif
                                    @endforeach
                                </td>
                                
                                <td class="text-center">
                                 @if ($item['weight'] == '[]')
                                    @can('haveaccess', 'weight-distribution.create')
                                       <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#createItem{{ $item['id'] }}">
                                          <i class="fas fa-plus-circle"></i>
                                       </button>
                                    @endcan
                                 @else
                                    @can('haveaccess', 'weight-distribution.edit')
                                       <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editItem{{ $item['id'] }}">
                                          <i class="fas fa-edit"></i>
                                       </button>
                                    @endcan
                                    {{-- @can('haveaccess', 'weight-distribution.delete')
                                       {{ Form::open(['route' => ['weight-distribution.destroy', $item['id']], 'method' => 'DELETE']) }}
                                          {{ Form::button('<i class="fas fa-trash-alt"></i> ' . '', ['type' => 'submit', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Eliminar peso', 'class' => 'btn btn-sm btn-outline-danger', 'onclick' => 'return confirm("¿Seguro de eliminar el peso?")']) }}
                                       {{ Form::close() }}
                                    @endcan --}}
                                 @endif

                                    
                               </td>
                            </tr>
                            <div class="modal fade" id="createItem{{ $item['id'] }}" tabindex="-1" aria-labelledby="createItemLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="createItemLabel">Agregar Peso</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       @include('custom.message') 
                                       {{ Form::open(['route' => 'weight-distribution.store', 'class' => 'form-horizontal submit-create-weight']) }}
                                            <div class="modal-body">
                                            @include('weightdistribution.partials.form')
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-outline-primary submit-create-weight-button" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                                                <i class="fas fa-plus-circle"></i> Crear
                                            </button>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade" id="editItem{{ $item['id'] }}" tabindex="-1" aria-labelledby="editItemLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="editItemLabel">Editar Peso</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       @include('custom.message') 
                                       @foreach($weightDistribution as $weight)
                                          @if($weight->id_distribution == $item['id'])
                                             {{ Form::model($weight, ['route' => ['weight-distribution.update', $weight->id], 'class' => 'form-horizontal submit-edit-weight', 'method' => 'PUT']) }}
                                                <div class="modal-body">
                                                   @include('weightdistribution.partials.formEdit')
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                                                   <button type="submit" class="btn btn-outline-warning submit-edit-weight-button" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                                                      <i class="fas fa-sync"></i> Actualizar
                                                   </button>
                                                </div>
                                             {{ Form::close() }}
                                          @endif
                                       @endforeach
                                    </div>
                                 </div>
                              </div>
                           </div>
                            @endif
                            @endforeach
                            
                            @php
                                 $totalHbr+= $tHbr;
                                 $totalQbr+= $tQbr;
                                 $totalEbr+= $tEbr;
                                 $totalFullsr+= $tFullsR;
                                 $totalRepotWeight+= $subRepotWeight;
                              @endphp
                           <tr class="gris">
                              <th class="text-center"></th>
                              <th class="text-center">{{ number_format($subRepotWeight, 2, '.','') }}</th>
                              <th class="text-center">{{ number_format($subAverage, 2, '.','') }}</th>
                              <th class="text-center" colspan="4"></th>
                              <th class="text-center">{{ $tHbr }}</th>
                              <th class="text-center">{{ $tQbr }}</th>
                              <th class="text-center">{{ $tEbr }}</th>
                              <th class="text-center">{{ number_format($tFullsR, 3, '.','') }}</th>
                              <th class="text-center" colspan="2"></th>
                           </tr>
                        </tbody>
                        <tfoot>
                        @endforeach
                        
                            <tr>
                                <th colspan="8" class="sin-border"></th>
                            </tr>
                            <tr class="gris">
                              <th class="text-center">KG</th>
                              <th class="text-center">{{ number_format($totalRepotWeight, 2, '.','') }}</th>
                              <th class="text-center" colspan="5"></th>
                              <th class="text-center">{{ $totalHbr }}</th>
                              <th class="text-center">{{ $totalQbr }}</th>
                              <th class="text-center">{{ $totalEbr }}</th>
                              <th class="text-center">{{ number_format($totalFullsr, 3, '.','') }}</th>
                              <th class="text-center" colspan="2"></th>
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
   <script src="{{ asset('assets/js/custom.js') }}"></script>
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
