@extends('layouts.principal')
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
    .text-center{
        text-align: center;
    }
    .text-right{
        text-align: right;
    }
    .text-left{
        text-align: left;
    }
    table {
        border-collapse: collapse;
    }

    table{
        width: 100%;
    }
    .small-letter{
        font-size: 10px;
        font-weight: normal;
    }
    .medium-letter{
        font-size: 11px;
    }
    .large-letter{
        font-size: 14px;
    }
    .farms{
        width: 300px;
    }
    
    table.sinb{
        margin: 0 auto;
        width: 60%;
    }
    table.sinb, th{
        border: 1px solid black;
        height: 15px;
    }
    table.sinb, td{
        border: 1px solid black;
        height: 13px;
    }
    .text-white{
        color: #fff;
    }
    .sin-border{
        border-top: 1px solid white;
        border-right: 1px solid white;
        border-bottom: 1px solid black;
        border-left: 1px solid white;
    }
    .box-size{
        width: 40px;
    }
    .hawb{
        width: 75px;
    }
    .pcs-bxs{
        width: 40px;
    }
    .gris{
        background-color: #d1cfcf;
    }
</style>
@section('content')
<section class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
          <div class="col-sm-6">
             <h1>Crear Carga
                
             </h1>
          </div>
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('load.index') }}">Cargas</a></li>
                <li class="breadcrumb-item active">Crear Carga</li>
             </ol>
          </div>
       </div>
    </div><!-- /.container-fluid -->
 </section>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Factura Master -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">TOTAL DE PIEZAS ENVIADAS</th>
                            </tr>
                        </thead>
                    </table>
                    <table>
                        @php
                            $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0;
                        @endphp
                        @foreach($clients as  $key => $client)
                        
                        <thead>
                            <tr>
                                <th class="text-center" colspan="8">{{ $client['name'] }}</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th class="text-center">Exporter</th>
                                <th class="text-center">Variety</th>
                                <th class="text-center">HAWB</th>
                                <th class="text-center">PCS</th>
                                <th class="text-center">BXS</th>
                                <th class="text-center">HALF</th>
                                <th class="text-center">QUART</th>
                                <th class="text-center">OCT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0;
                            @endphp
                            @foreach($invoiceItems as $item)
                            @if($client['id'] == $item->id_client)
                            @php
                                $tPieces+= $item->pieces;
                                $tFulls+= $item->fulls;
                                $tHb+= $item->hb;
                                $tQb+= $item->qb;
                                $tEb+= $item->eb;
                            @endphp
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->variety->name }}</td>
                                <td class="text-center">{{ $item->hawb }}</td>
                                <td class="text-center">{{ $item->pieces }}</td>
                                <td class="text-center">{{ number_format($item->fulls, 3, '.','') }}</td>
                                <td class="text-center">{{ $item->hb }}</td>
                                <td class="text-center">{{ $item->qb }}</td>
                                <td class="text-center">{{ $item->eb }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        @php
                            $totalFulls+= $tFulls;
                            $totalHb+= $tHb;
                            $totalQb+= $tQb;
                            $totalEb+= $tEb;
                        @endphp
                        <tfoot>
                        @endforeach
                            <tr>
                                <th colspan="8"></th>
                            </tr>
                            <tr class="table-secondary">
                                <th colspan="3">Total Global:</th>
                                <th class="text-center">{{ $totalPieces }}</th>
                                <th class="text-center">{{ number_format($totalFulls, 3, '.','') }}</th>
                                <th class="text-center">{{ $totalHb }}</th>
                                <th class="text-center">{{ $totalQb }}</th>
                                <th class="text-center">{{ $totalEb }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
           </div>
        </div>
        <hr>
        
        <h1>Formulario para crear plano</h1>


        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#agregarItem">
            <i class="fas fa-plus-circle"></i> Crear Item
        </button>

        <div class="modal fade" id="agregarItem" tabindex="-1" aria-labelledby="agregarItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="agregarItemLabel">Agregar item de la factura</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form method="POST" v-on:submit.prevent="createInvoiceItem">
                     <div class="modal-body">
                        
                        
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-outline-primary" id="createMasterInvoice" data-toggle="tooltip" data-placement="top" title="Crear Empresa">
                           <i class="fas fa-plus-circle"></i> Crear
                     </button>
                     </div>
                  </form>
               </div>
            </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
