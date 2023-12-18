<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONFIRMACIÓN DE DESPACHO {{ $load->bl }}</title>
    <style>
        @page {
           margin: 0cm 0cm;
           font-size: 1em;
        }
        body {
           font-family: Arial, Helvetica, sans-serif;
           margin: 3cm 1cm 1cm;
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
           width: 100%;
           page-break-before: auto;
        }
        .small-letter{
           font-size: 8px;
           font-weight: normal;
        }
        .medium-letter{
           font-size: 10px;
        }
        .large-letter{
           font-size: 13px;
        }
        .farms{
           width: 220px;
        }
        .farms2{
           width: 300px;
        }
        table, th{
           border: 1px solid black;
           height: 14px;
        }
        table, td{
           border: 1px solid black;
           height: 12px;
        }
        .text-white{
           color: #fff;
        }
        .sin-border{
           border-top: 1px solid black;
           border-right: 1px solid white;
           border-bottom: 1px solid black;
           border-left: 1px solid white;
           height: 3px;
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
        .pcs-bxs2{
           width: 40px;
        }
        .gris{
           background-color: #d1cfcf;
        }
        header {
           position: fixed;
           top: 1cm;
           left: 1cm;
           right: 1cm;
           height: 2cm;
           text-align: center;
           line-height: 3px;
        }

        footer {
           position: fixed;
           bottom: 0cm;
           left: 0cm;
           right: 0cm;
           height: 2cm;
           background-color: #F93855;
           color: white;
           text-align: center;
           line-height: 35px;
        }
        .headTitulo{
            padding: 5px 0 -7px 0;
        }
        .headTitulo2 {
         padding: 5px 0 -7px 0;
        }
        .headDetalle{
           padding: 2px 0 0 3px;
        }
        .text-red{
         color: red;
        }
   </style>
</head>
<body>
   <header>
      <table>
         <tr>
            <th colspan="5" class="large-letter headTitulo">CONFIRMACIÓN DE DESPACHO</th>
         </tr>
         <tr>
            <th class="medium-letter text-left pcs-bxs headDetalle">Date:</th>
            <th colspan="2" class="small-letter text-left farms2 headDetalle">{{ date('l, d F - Y', strtotime($load->date)) }}</th>
            <th class="medium-letter text-left pcs-bxs2 headDetalle">Pcs:</th>
            <th class="small-letter text-left headDetalle">{{ $totalPieces }}</th>
         </tr>
         <tr>
            <th class="medium-letter text-left headDetalle">Client:</th>
            <th colspan="2" class="small-letter text-left headDetalle">{{ $company->name }}</th>
            <th class="medium-letter text-left headDetalle">Carrier:</th>
            <th class="small-letter text-left headDetalle">MARITIMO</th>
         </tr>
         <tr>
            <th class="medium-letter text-left headDetalle">Awb:</th>
            <th class="small-letter text-left headDetalle">{{ $load->bl }}</th>
            <th colspan="2" class="medium-letter text-center headDetalle text-red">
               @isset($load->floor)
                  @if ($load->floor == 'si')
                     @if ($load->num_pallets > 1)
                        <span>{{ $load->num_pallets }} PALLETS AL PISO</span>
                     @else
                        <span>{{ $load->num_pallets }} PALLET AL PISO</span>
                     @endif
                  @else
                     <span>NO HAY PALLETS AL PISO</span>
                  @endif
               @endisset
            </th>
            <th class="medium-letter text-center headDetalle text-red">
               @isset($load->id_qa)
                  <span>CONTROL DE CALIDAD: {{ Str::upper($load->qacompany->name) }}</span>
               @endisset

            </th>
         </tr>
      </table>

   </header>
   <main>
      <table class="table">
         @php
            $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0;
         @endphp
         <tr>
            <th colspan="9" class="sin-border"></th>
         </tr>
         @foreach($clients as  $key => $client)
            <tr>
               <th class="text-center medium-letter">AWB</th>
               <th class="text-center medium-letter" colspan="8">{{ $client['name'] }}</th>
            </tr>
            <tr class="gris">
               <th class="text-center medium-letter">Exporter</th>
               <th class="text-center medium-letter hawb">Variety</th>
               <th class="text-center medium-letter hawb">HAWB</th>
               <th class="text-center medium-letter pcs-bxs">PCS</th>
               <th class="text-center medium-letter pcs-bxs">BXS</th>
               <th class="text-center medium-letter box-size">HALF</th>
               <th class="text-center medium-letter box-size">QUART</th>
               <th class="text-center medium-letter box-size">OCT</th>
               <th class="text-center medium-letter">Note</th>
            </tr>
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
                        <td class="small-letter farms">{{ $item->name }}</td>
                        <td class="small-letter text-center">{{ $item->variety->name }}</td>
                        <td class="small-letter text-center">{{ $item->hawb }}</td>
                        <td class="small-letter text-center">{{ $item->pieces }}</td>
                        <td class="small-letter text-center">{{ number_format($item->fulls, 3, '.','') }}</td>
                        <td class="small-letter text-center">{{ $item->hb }}</td>
                        <td class="small-letter text-center">{{ $item->qb }}</td>
                        <td class="small-letter text-center">{{ $item->eb }}</td>
                        <td class="small-letter text-center text-red">
                           @foreach ($coordinationObserver as $coordOb)
                              @if ($coordOb->hawb == $item->hawb)
                                 @isset($coordOb->marketer->name)
                                    {{ $coordOb->marketer->name }}
                                 @endisset
                                 @isset($coordOb->observation)
                                    ({{ $coordOb->observation }})
                                 @endisset
                              @endif
                           @endforeach
                        </td>
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
               <tr class="gris">
                  <th class="small-letter text-right" colspan="3">Total:</th>
                  <th class="small-letter">{{ $tPieces }}</th>
                  <th class="small-letter">{{ number_format($tFulls, 3, '.','') }}</th>
                  <th class="small-letter">{{ $tHb }}</th>
                  <th class="small-letter">{{ $tQb }}</th>
                  <th class="small-letter">{{ $tEb }}</th>
                  <th class="small-letter"></th>
               </tr>
               <tr>
                  <th colspan="9" class="sin-border"></th>
               </tr>
         @endforeach
               
               <tr class="gris">
                  <th colspan="3">Total Global:</th>
                  <th class="small-letter">{{ $totalPieces }}</th>
                  <th class="small-letter">{{ number_format($totalFulls, 3, '.','') }}</th>
                  <th class="small-letter">{{ $totalHb }}</th>
                  <th class="small-letter">{{ $totalQb }}</th>
                  <th class="small-letter">{{ $totalEb }}</th>
                  <th class="small-letter"></th>
               </tr>
            </tfoot>
        </table>
    </main>



</body>
</html>