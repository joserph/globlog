<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FACTURAS FINCAS {{ $invoiceheaders->bl }}</title>
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
        h1{
            font-size: 39px;
        }
        
         .medio{
            width: 120px;
         }
         .espacio{
            width: 10px;
         }
         .completo{
            width: 243px;
         }
         .mitad{
            width: 340px;
         }
         .sin-border1{
            border-top: 1px solid white;
            border-right: 1px solid white;
            border-bottom: 1px solid white;
            border-left: 1px solid white;
        }
        .sin-border2{
            border-top: 1px solid white;
            border-right: 1px solid white;
            border-bottom: 1px solid black;
            border-left: 1px solid white;
        }
        .sin-border3{
            border-top: 1px solid white;
            border-right: 1px solid black;
            border-bottom: 1px solid white;
            border-left: 1px solid white;
        }
        .sin-border4{
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid white;
            border-left: 1px solid black;
        }
         .altura{
            height: 50px;
         }
    </style>
</head>
<body>
   @foreach ($invoiceItems as $item)
      <h1 class="text-center">COMERCIAL INVOICE</h1>
      <table>
         <tr>
            <th>Grower Name & Address</th>
            <th class="espacio sin-border1"> </th>
            <th class="medio sin-border1">Farm Code</th>
            <th class="medio sin-border1">Date</th>
         </tr>
         <tr>
            <td class="sin-border4 medium-letter">{{ $item['name'] }}</td>
            <td class="sin-border1"></td>
            <td class="sin-border1"></td>
            <td class="text-center sin-border1 medium-letter">{{ date('d/m/Y', strtotime($invoiceheaders->date)) }}</td>
         </tr>
         <tr>
            <td class="sin-border4 medium-letter">{{ $item['address_farm'] }} - {{ $item['city_farm'] }}.</td>
            <td class="sin-border1"></td>
            <th class="sin-border1">Country Code</th>
            <th class="sin-border1">Invoice Nº</th>
         </tr>
         <tr>
            <td class="medium-letter">PHONE: {{ $item['phone_farm'] }}</td>
            <td class="sin-border1"></td>
            <td class="sin-border1"></td>
            <td class="sin-border1"></td>
         </tr>
      </table>
      <br>
      <table>
         <tr>
            <th>Marketing Name / Marca De Comercialización</th>
            <th class="espacio sin-border1"> </th>
            <th class="completo sin-border2">B/L N#</th>
         </tr>
         <tr>
            <td class="sin-border4 medium-letter">{{ $item['client'] }}</td>
            <td class="sin-border3"></td>
            <td class="text-center medium-letter">{{ $invoiceheaders->bl }}</td>
         </tr>
         <tr>
            <td class="sin-border4 medium-letter">{{ $item['address_client'] }}. {{ $item['city_client'] }}, {{ $item['state_client'] }} - {{ $item['country_client'] }}.</td>
            <td class="sin-border1"></td>
            <th class="sin-border2">Carrier</td>
         </tr>
         <tr>
            <td class="medium-letter">PHONE: {{ $item['phone_client'] }}</td>
            <td class="sin-border3"></td>
            <td class="text-center medium-letter">{{ $item['carrier'] }}</td>
         </tr>
      </table>
      <br>
      <table>
         <tr>
            <th>Foreign Purchaser Consignee</th>
            <th class="espacio sin-border1"> </th>
            <th class="completo sin-border2">Hawb</th>
         </tr>
         <tr>
            <td class="sin-border4 medium-letter">{{ $company->name }}</td>
            <td class="sin-border3"></td>
            <td class="text-center medium-letter">{{ $item['hawb'] }}</td>
         </tr>
         <tr>
            <td class="sin-border4 medium-letter">{{ $company->address }}. {{ $company->city }}, {{ $company->state }} - {{ $company->country }}.</td>
            <td class="sin-border1"></td>
            <th class="sin-border2">#Refrendo</th>
         </tr>
         <tr>
            <td class="medium-letter">PHONE: {{ $company->phone }}</td>
            <td class="sin-border3"></td>
            <td></td>
         </tr>
      </table>
      <br>
      <table>
         <tr>
            <th>Pcs</th>
            <th>Bxs</th>
            <th>Product Description</th>
            <th>Atpa</th>
            <th>Hts #</th>
            <th>Units</th>
            <th>Stems</th>
            <th>Price</th>
            <th>Price Total</th>
         </tr>
         <tr>
            <td class="text-center medium-letter">{{ $item['pieces'] }}</td>
            <td class="text-center medium-letter">{{ number_format($item['fulls'], 3, '.','') }}</td>
            <td class="medium-letter">{{ $item['variety'] }}</td>
            <td class="text-center medium-letter">-</td>
            <td class="text-center medium-letter">-</td>
            <td class="text-center medium-letter">{{ $item['bunches'] }}</td>
            <td class="text-center medium-letter">{{ number_format($item['stems'], 0, '','.') }}</td>
            <td class="text-center medium-letter">{{ number_format($item['price'], 2, ',','') }}</td>
            <td class="text-center medium-letter">{{ number_format($item['total'], 2, ',','.') }}</td>
         </tr>
         <tr>
            <td class="text-center medium-letter">{{ $item['pieces'] }}</td>
            <td class="text-center medium-letter">{{ number_format($item['fulls'], 3, '.','') }}</td>
            <td class="text-center medium-letter" colspan="3">Total</td>
            <td class="text-center medium-letter">{{ $item['bunches'] }}</td>
            <td class="text-center medium-letter" colspan="2"></td>
            <td class="text-center medium-letter">{{ number_format($item['total'], 2, ',','.') }}</td>
         </tr>
      </table>
      <br>
      <table>
         <tr>
            <th colspan="2">TOTAL</th>
         </tr>
         <tr>
            <th>Product Description</th>
            <th>Stems</th>
         </tr>
         <tr>
            <td class="text-center medium-letter">{{ $item['variety'] }}</td>
            <td class="text-center medium-letter">{{ $item['stems'] }}</td>
         </tr>
      </table>
      <br>
      <table>
         <tr>
            <th class="mitad">Name and title of person preparing invoice</th>
            <th class="espacio sin-border3"> </th>
            <th class="mitad">Freight Forwarder</th>
         </tr>
         <tr>
            <td class="sin-border4"></td>
            <td class="sin-border3"></td>
            <td class="sin-border4 medium-letter">{{ $lc_active->name }}</td>
         </tr>
         <tr>
            <td class="sin-border4"></td>
            <td class="sin-border3"></td>
            <td class="sin-border4 medium-letter">{{ $lc_active->address }}</td>
         </tr>
         <tr>
            <td class="sin-border4"></td>
            <td class="sin-border3"></td>
            <td class="sin-border4 medium-letter"></td>
         </tr>
         <tr>
            <td></td>
            <td class="sin-border3"></td>
            <td class="medium-letter">{{ $lc_active->city }}-{{ $lc_active->country }}</td>
         </tr>
      </table>
      <br>
      <table>
         <tr>
            <th class="mitad altura"> </th>
            <th class="espacio sin-border3"> </th>
            <th class="mitad"> </th>
         </tr>
         <tr>
            <th>Customs Use Only</th>
            <th class="sin-border3"></th>
            <th>Usda Aphis Ppq Use Only</th>
         </tr>
      </table>
      <div style="page-break-after:always;"></div>
   @endforeach
   


</body>
</html>