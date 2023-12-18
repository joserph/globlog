<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COMERCIAL INVOICE {{ $invoiceheaders->bl }}</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
            padding-right: 5px;
        }
        .text-left{
            text-align: left;
            padding-left: 5px;
        }
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            height: 20px;
        }
        table{
            width: 100%;
        }
        .small-letter{
            font-size: 8px;
        }
        .medium-letter{
            font-size: 12px;
        }
        .farms{
            width: 220px;
        }
        
        table.sinb{
            margin: 0 auto;
            width: 60%;
        }
        table.sinb, th, td{
            border: 1px solid black;
            height: 15px;
        }
        .text-white{
            color: #fff;
        }
        .firma{
            height: 40px;
        }
        .c-width{
            width: 80px;
        }
        .gender{
            width: 55px;
        }
        h1{
            font-size: 29px;
        }
        .client{
            width: 80px;
        }
    </style>
</head>
<body>
    <h1>MASTER INVOICE</h1>
    <table>
        <thead>
            <tr>
                <th>Grower Name and Address / Nombre y Dirección de Cultivo</th>
                <th>Foreign Purchaser / Comprador Extranjero</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6">{{ strtoupper($lc_active->name) }}</td>
                <td colspan="6">{{ strtoupper($company->name) }}</td>
            </tr>
            <tr>
                <td colspan="6">RUC: {{ $lc_active->ruc }}</td>
                <td colspan="6">{{ strtoupper($company->address) }}</td>
            </tr>
            <tr>
                <td colspan="6">{{ strtoupper($lc_active->address) }}</td>
                <td colspan="6">TLF: {{ $company->phone }}</td>
            </tr>
            <tr>
                <td colspan="6">TLF: {{ $lc_active->phone }}</td>
                <td colspan="6">{{ strtoupper($company->city) }}</td>
            </tr>
            <tr>
                <td colspan="6">{{ strtoupper($lc_active->city) }}</td>
                <td colspan="6">{{ strtoupper($company->country) }}</td>
            </tr>
            <tr>
                <td colspan="6">{{ strtoupper($lc_active->country) }}</td>
                <td colspan="6"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th colspan="2">Farm</th>
                <th colspan="2">Date / Fecha</th>
                <th colspan="4">Country INVOICE N°</th>
                <th colspan="2">B/L N°</th>
                <th colspan="2">Carrier</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">VF</td>
                <td colspan="2">{{ date('d-m-Y', strtotime($invoiceheaders->date)) }}</td>
                <td colspan="2">GYE</td>
                <td colspan="2">{{ $invoiceheaders->invoice }}</td>
                <td colspan="2">{{ $invoiceheaders->bl }}</td>
                <td colspan="2">{{ $invoiceheaders->carrier }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
      <thead>
         <tr>
             <th>Fulls</th>
             <th>Pcs</th>
             <th>Bunch per box</th>
             <th>Flower Provider</th>
             <th>Client</th>
             <th>Genus</th>
             <th>Species</th>
             <th>Hawb</th>
             <th>Total Stems</th>
             <th>Price</th>
             <th>Total Bunch</th>
             <th>Total USD</th>
         </tr>
     </thead>
     <tbody>
         @php
             $fulls = 0; $pcs = 0; $stems = 0; $total = 0; $bunches = 0; $promBunches = 0;
         @endphp
         @foreach ($invoiceItems as $key => $item)
             @php
                 $fulls+= $item['fulls'];
                 $pcs+= $item['pieces'];
                 $stems+= $item['stems'];
                 $bunches+= $item['bunches'];
                 $total+= $item['total'];
                 // Promedio de bunches por cajas.
                 $promBunches = $item['bunches'] / $item['pieces'];
             @endphp
             <tr>
                 <td class="text-center small-letter">{{ number_format($item['fulls'], 3, '.','') }}</td>
                 <td class="text-center small-letter">{{ $item['pieces'] }}</td>
                 <td class="text-center small-letter">{{ round($promBunches) }}</td>
                 <td class="text-left small-letter">{{ Str::limit($item['name'], '40') }}</td>
                 <td class="text-left small-letter">{{ Str::limit(str_replace('SAG-', '', $item['client']), '12') }}</td>
                 <td class="text-center small-letter">{{ $item['variety'] }}</td>
                 <td class="text-center small-letter">{{ $item['scientific_name'] }}</td>
                 <td class="text-center small-letter">{{ $item['hawb'] }}</td>
                 <td class="text-center small-letter">{{ number_format($item['stems'], 0, '','.') }}</td>
                 <td class="text-center small-letter">{{ number_format($item['price'], 2, ',','') }}</td>
                 <td class="text-center small-letter">{{ $item['bunches'] }}</td>
                 <td class="text-center small-letter">{{ number_format($item['total'], 2, ',','.') }}</td>
             </tr>
         @endforeach
     </tbody>
     <tfoot>
      <tr>
          <th class="text-center small-letter">{{ number_format($fulls, 3, '.','') }}</th>
          <th class="text-center small-letter">{{ $pcs }}</th>
          <th class="text-center"></th>
          <th colspan="5" class="text-right small-letter">TOTAL:</th>
          <th class="text-center small-letter">{{ number_format($stems, 0, '','.') }}</th>
          <th class="text-center small-letter"></th>
          <th class="text-center small-letter">{{ number_format($bunches, 0, ',','.') }}</th>
          <th class="text-center small-letter">{{ number_format($total, 2, ',','.') }}</th>
      </tr>
  </tfoot>
</table>

    
</body>
</html>