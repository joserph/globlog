@extends('layouts.principal')

@section('title') Factura | Sistema de Carguera v1.1 @stop

@section('content')


<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Facturas</a></li>
               <li class="breadcrumb-item active">Factura {{ $invoice->num_invoice }}</li>
            </ol>
         </div>
      </div>
   </div><!-- /.container-fluid -->
</section>

  <!-- Main content -->
<section id="invoiceitem" class="content">
   <div class="container-fluid">
   @include('custom.message') 
      <div class="invoice p-3 mb-3">
         <div class="row">
            <div class="col-12">
               <h4>
                  <i class="fas fa-globe"></i> Factura
                  <small class="float-right">Fecha: {{ date('m-d-Y', strtotime($invoice->date)) }}</small>
               </h4>
            </div>
         </div>
         
         <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
               From
               <address>
               <strong>{{ $my_company->name }}</strong><br>
               {{ $my_company->address }}<br>
               {{ $my_company->city}}, {{ $my_company->state }} {{ $my_company->country }}<br>
               Telefono: {{ $my_company->phone }}<br>
               </address>
            </div>
            
            <div class="col-sm-4 invoice-col">
               Bill To
               <address>
               <strong>{{ $client->name }}</strong><br>
               {{ $client->address }}<br>
               {{ $client->city }}, {{ $client->state }} {{ $client->country }}<br>
               Telefono: {{ $client->phone }}<br>
               Email: {{ $client->email }}
               </address>
            </div>
         
            <div class="col-sm-4 invoice-col">
               <b>Invoice: {{ $invoice->num_invoice }}</b><br>
               <br>
               <b>{{ $type_load }}:</b> {{ $load }}<br>
               <b>Type:</b> {{ Str::of($invoice->type)->upper() }}<br>
               <b>Terms:</b> {{ Str::of($invoice->terms)->upper() }}<br>
               <b>Obervations:</b> {{ $invoice->observation }}
            </div>
         </div>
         
         <div>
            <div class="row">
                <!-- Button trigger modal -->
                <div class="container">
                     <button type="button" onclick="mifuncion()" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createInvoice" >
                        <i class="fas fa-plus-circle"></i> Crear Item
                     </button>
                     <a href="{{ url('itemsforinvoices') }}" class="btn btn-outline-info float-right btn-sm"><i class="fas fa-share"></i> Ir a Items para Facturas</a>
                     <button type="button" class="btn btn-outline-warning btn-sm float-right" data-toggle="modal" data-target="#editInvoiceHeader" >
                        <i class="fas fa-edit"></i> Editar Cabecera
                     </button>
                </div>
                <hr>
                    <div class="col-12 table-responsive">
                       <table class="table table-sm table-striped">
                          <thead>
                             <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Pieces</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th colspan="2" class="text-center">Aciones</th>
                             </tr>
                          </thead>
                          @php
                              $total_pieces = 0;
                              $total_quantity = 0;
                              $total_amount = 0;
                          @endphp
                          <tbody>
                            @foreach ($items as $key => $item)
                            @php
                              $total_pieces += $item->pieces;
                              $total_quantity += $item->quantity;
                              $total_amount += $item->amount;
                            @endphp
                            <tr>
                                 <td>{{ ($key + 1) }}</td>
                                 <td>{{ $item->description->name }}</td>
                                 <td>{{ number_format($item->pieces, 2, '.','') }}</td>
                                 <td>{{ number_format($item->quantity, 3, '.','') }}</td>
                                 <td>{{ number_format($item->rate, 3, '.','') }}</td>
                                 <td>${{ number_format($item->amount, 3, '.','') }}</td>
                                 <td class="text-center" width="10px">
                                    @can('haveaccess', 'itemsininvoices.edit')
                                    <button type="button" onclick="mifuncion2(this)" value="{{ $item->id }}" class="btn btn-sm btn-outline-warning pull-right" data-toggle="modal" data-target="#editItem{{ $item->id }}" data-toggle="tooltip" data-placement="top" title="Editar nuevas paletas"><i class="fas fa-edit"></i></button>
                                    @endcan
                                 </td>
                                 <td class="text-center" width="10px">
                                    @can('haveaccess', 'itemsininvoices.destroy')
                                    {!! Form::open(['route' => ['itemsininvoices.destroy', $item->id], 'method' => 'DELETE', 'onclick' => 'return confirm("¿Seguro de eliminar item de factura?")']) !!}
                                       <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Eliminar item de factura"><i class="fas fa-trash-alt"></i></button>
                                    {!! Form::close() !!}
                                    @endcan
                                    <!-- Modal Edit Pallet -->
                                    <div class="modal fade" id="editItem{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editItemLabel">
                                       <div class="modal-dialog modal-xl" role="document">
                                          <div class="modal-content">
                                                <div class="modal-header">
                                                   <h5 class="modal-title" id="agregarItemLabel">Contenedor</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                   </button>
                                                </div>
                                             <div class="modal-body">
                                                   
                                                   {{ Form::model($item, ['route' => ['itemsininvoices.update', $item->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
                                                      <div class="modal-body">
                                                         @include('invoices.partials.form2')
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
                                 </td>
                            </tr>
                            
                            @endforeach
                             
                             
                          </tbody>
                          <tfoot>
                           <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                           </tr>
                           <tr>
                              <th></th>
                              <th><strong>Grand Total:</strong></th>
                              <th>{{ number_format($total_pieces, 2, '.','') }}</th>
                              <th>{{ number_format($total_quantity, 2, '.','') }}</th>
                              <th></th>
                              <th>${{ number_format($total_amount, 2, '.','') }}</th>
                           </tr>
                          </tfoot>
                       </table>
                    </div>
                 </div>
                 
                 {{-- <div class="row">
                 
                    <div class="col-6">
                       <p class="lead">Payment Methods:</p>
                       <img src="../../dist/img/credit/visa.png" alt="Visa">
                       <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                       <img src="../../dist/img/credit/american-express.png" alt="American Express">
                       <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
                       <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                       Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                       plugg
                       dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                       </p>
                    </div>
                 
                    <div class="col-6">
                       <p class="lead">Amount Due 2/22/2014</p>
                       <div class="table-responsive">
                          <table class="table">
                             <tbody><tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>$250.30</td>
                                </tr>
                                <tr>
                                <th>Tax (9.3%)</th>
                                <td>$10.34</td>
                                </tr>
                                <tr>
                                <th>Shipping:</th>
                                <td>$5.80</td>
                                </tr>
                                <tr>
                                <th>Total:</th>
                                <td>$265.24</td>
                                </tr>
                             </tbody>
                          </table>
                       </div>
                    </div>
                 </div> --}}
                 
                 
                 <div class="row no-print">
                    <div class="col-12">
                       
                       <a href="{{ route('invoice.pdf', $invoice->id) }}" target="_blank" class="btn btn-xs btn-outline-success btn-sm float-right"><i class="fas fa-download"></i> Descargar PDF</a>
                    </div>
                 </div>
        </div>
      </div>
   </div>
</section>


<!-- Modal create header invoice -->
<div class="modal fade" id="createInvoice" tabindex="-1" aria-labelledby="createInvoiceLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="createInvoiceLabel">Crear Factura</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         {{ Form::open(['route' => 'itemsininvoices.store', 'class' => 'form-horizontal']) }}
            <div class="modal-body">
               
               @include('invoices.partials.form')
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
               <button class="btn btn-outline-primary" id="createCompany" data-toggle="tooltip" data-placement="top" title="Crear Item">
                  <i class="fas fa-plus-circle"></i> Crear
               </button>
            </div>
         {{ Form::close() }}
      </div>
   </div>
   </div>
</div>

<!-- Modal Edit header invoice -->
<div class="modal fade" id="editInvoiceHeader" tabindex="-1" aria-labelledby="editInvoiceHeaderLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="editInvoiceHeaderLabel">Editar Cabecera de Factura</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         {{ Form::model($invoice, ['route' => ['invoices.update', $invoice->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
            <div class="modal-body">
               @include('invoices.partials.formHeader2')
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
               <button class="btn btn-outline-warning" id="createCompany" data-toggle="tooltip" data-placement="top" title="Crear Item">
                  <i class="fas fa-sync"></i> Actualizar
               </button>
            </div>
         {{ Form::close() }}
      </div>
   </div>
   </div>
</div>

<script>

function mifuncion() {
   // var id_pallet = elemento.getAttribute('value');
   $(document).ready(function(){
       //alert(id_pallet);
       $(".grupo").keyup(function()
       {
           var quantity = $('#quantity').val();
           var rate = $('#rate').val();
           var amount = (parseFloat(quantity).toFixed(3) * parseFloat(rate).toFixed(3));
           $('#amount').val(parseFloat(amount).toFixed(3));
           //console.log(amount);
       });

   });
}

function mifuncion2(elemento) {
    var id_item = elemento.getAttribute('value');
    $(document).ready(function(){
        //alert(id_item);
        $(".grupo").keyup(function()
        {
            var pieces = $('#pieces_'+id_item).val();
            var quantity = $('#quantity_'+id_item).val();
            var rate = $('#rate_'+id_item).val();
            var amount = (parseFloat(quantity).toFixed(3) * parseFloat(rate).toFixed(3));
            $('#amount_'+id_item).val(parseFloat(amount).toFixed(3));
        });
        
        
    });
    
}

</script>



@endsection
