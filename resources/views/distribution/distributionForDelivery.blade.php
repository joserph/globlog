<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DISTRIBUCIÓN PARA DELIVERY - {{ $flight->awb }}</title>
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
         font-size: 9px;
         font-weight: normal;
      }
      .medium-letter{
         font-size: 10px;
         font-weight: normal;
      }
      .large-letter{
         font-size: 15px;
         font-weight: normal;
      }
      .farms{
         width: 280px;
      }
      table, th, td{
         border: 1px solid black;
      }

      table, tr, th{
         border: 1px solid black;
      }
      .sin-border{
         border-top: 1px solid white;
         border-right: 1px solid white;
         border-bottom: 1px solid black;
         border-left: 1px solid white;
      }
      .hawb{
         width: 70px;
      }
      .coordinado{
         background-color: rgb(217, 244, 255);
      }
      .recibido{
         background-color: rgb(191, 255, 231);
      }
      .faltante{
         background-color: rgb(255, 255, 175);
      }
      .text-rojo{
         color: red;
      }
      .variety{
         width: 70px;
      }
      .pcs-num{
         width: 30px;
      }
      .missing{
         width: 55px;
      }
      .blue{
         background-color: #00b0f0;
      }
      .yellow{
         background-color: #ffff00;
      }
      .green{
         background-color: #00b050;
      }
      .green-l{
         background-color: #e2efda;
      }
      .peach{
         background-color: #fff2cc;
      }
      

      header {
         position: fixed;
         /*top: 0cm;
         left: 0cm;
         right: 0cm;
         height: 2cm;
         background-color: #F93855;
         color: white;
         text-align: center;
         line-height: 30px;*/
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
      .imgc{
         position: fixed;
         margin: 20px, 20px, 20px, 20px;
      }
      .info{
         position: fixed;
         margin-left: 800px;
         margin-top: 10px;
         color: #000;
      }
      .awb1{
         width: 70px;
         padding: 0;
         margin: 0;
      }
      .sin-border-full{
         border-top: 1px solid white;
         border-right: 1px solid white;
         border-bottom: 1px solid white;
         border-left: 1px solid white;
      }
      .titu{
         margin-top: 20px;
         margin-left: 40px;
         margin-right: 30px;
      }
      main{
         margin-top: -45px;
      }
      
   </style>
</head>
<body>
   <header>
      <table class="sin-border-full titu">
         <tr>
             <th class="sin-border-full text-center">DISTRIBUCIÓN DE CARGA {{ $flight->awb }}</th>
         </tr>
      </table>
      <!--<h3 class="text-center large-letter">DISTRIBUCIÓN DE CARGA {{ $flight->awb }}</h3>-->
   </header>
   <main>
      <table class="table">
         <tbody>
            @php
               $totalPcs = 0; $totalFull = 0;
            @endphp
            @foreach($clientsDistribution as $client)
            @php
               $subTotal = 0; $subtotalClient = 0; $subTotalFullClient = 0; $subTotalFull = 0;
            @endphp
               <!-- Code para totales en clientes -->
               @foreach($coordinations as $key => $item)
                  @if($client['id'] == $item->id_client)
                     @php
                        $subtotalClient += $item->hb_r + $item->qb_r + $item->eb_r;
                        $subTotalFullClient += $item->fulls_r;
                     @endphp
                  @endif
               @endforeach
               <tr>
                  <th colspan="6" class="large-letter" @foreach ($colors as $item) @if ($client['id'] == $item->id_type) style="background:{{ $item->color }}; color: #fff;" @endif @endforeach>{{ $client['name'] }}: {{ $subtotalClient }} PCS / {{ number_format($subTotalFullClient, 3, '.','') }} FBX</th>
               </tr>
               @foreach($coordinations as $key => $item)
                  
                  @if($client['id'] == $item->id_client)
                     @php
                        $subTotal += $item->hb_r + $item->qb_r + $item->eb_r;
                        $subTotalFull += $item->fulls_r;
                     @endphp
                     <tr>
                        <td class="hawb medium-letter text-center">{{ $item->hawb }}</td>
                        <td class="farms medium-letter">{{ Str::limit($item->farm->name, 47) }}</td>
                        <td class="variety medium-letter text-center">{{ $item->variety->name }}</td>
                        <td class="pcs-num medium-letter text-center">
                           @if ($item->hb_r > 0)
                              {{ $item->hb_r }} HB
                           @endif 
                        </td>
                        <td class="pcs-num medium-letter text-center">
                           @if ($item->qb_r > 0)
                              {{ $item->qb_r }} QB
                           @endif 
                        </td>
                        <td class="pcs-num medium-letter text-center">
                           @if ($item->eb_r > 0)
                              {{ $item->eb_r }} EB
                           @endif 
                        </td>
                     </tr>
                  @endif
               @endforeach
               <tr>
                  <th colspan="2"></th>
                  <th class="medium-letter">TOTAL</th>
                  <th colspan="3" class="medium-letter"><strong>{{ $subTotal }} PCS</strong></th>
               </tr>
               <tr>
                  <th colspan="6" class="sin-border-full"></th>
              </tr>
              <tr>
                  <th colspan="6" class="sin-border"></th>
               </tr>
               @php
                  $totalPcs += $subTotal;
                  $totalFull += $subTotalFull;
               @endphp
            @endforeach
            <tr>
               <th colspan="6" class="sin-border-full">TOTAL CARGA: {{ $totalPcs }} PCS ( {{ number_format($totalFull, 3, '.','') }} FBX )</th>
           </tr>
         </tbody>
      </table>
   </main>
</body>
</html>