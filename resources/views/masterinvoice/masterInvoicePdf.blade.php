<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COMERCIAL INVOICE {{ $invoiceheaders->bl }}</title>
    <style>
        /*body{
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
        
        */
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
            padding-right: 5px;
        }
        .text-left{
            text-align: left;
            padding-left: 5px;
        }
         table {
            border-collapse: collapse;
            width: 100%;
            page-break-before: auto;
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
        .client{
            width: 80px;
        }
        .gender{
            width: 55px;
        }
        .c-width{
            width: 80px;
        }
        .firma{
            height: 25px;
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
         
         h1{
            font-size: 29px;
            padding: 5px 0 -7px 0;
            margin-top: -70px;
        }
        table, th{
            border: 1px solid black;
            height: 20px;
         }
         table, td{
            border: 1px solid black;
            height: 12px;
         }
         
        .tHeader th{
            height: 15px;
            font-size: 12px;
            text-align: center;
            padding-top: 5px;
        }
        .tHeader td{
            height: 39px;
            font-size: 9px;
            padding-top: 5px;
        }
        .tHeader2 td{
            height: 15px;
            font-size: 9px;
            padding-top: 5px;
        }
        .tHeader3 th{
            height: 15px;
            font-size: 9px;
            padding-top: 5px;
            font-weight: bold;
        }
        main{
            /*margin-top: 80px; */
            /*position: fixed;*/
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
        header table{
           margin-top: 5px;
        }
        main table{
           margin-top: 20px;
        }
        .tHeaderPrin{
           margin-top: 20px;
        }
        table.sinb{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
        <h1 class="text-center">MASTER INVOICE</h1>
        <table class="tHeaderPrin">
            <tr class="tHeader">
                <th class="text-center medium-letter">Grower Name & Address / Nombre y Dirección de Cultivo</th>
                <th class="text-center medium-letter">Foreign Purchaser / Comprador Extranjero</th>
            </tr>
            <tr class="tHeader">
                <td class="small-letter">
                    {{ strtoupper($load->logistic_company->name) }} RUC: {{ $load->logistic_company->ruc }} <br>
                    {{ strtoupper($load->logistic_company->address) }} <br>
                    TLF: {{ $load->logistic_company->phone }} <br>
                    {{ strtoupper($load->logistic_company->city) }} - {{ strtoupper($load->logistic_company->country) }} 
                </td>
                <td class="small-letter">
                    {{ strtoupper($company->name) }} <br>
                    {{ strtoupper($company->address) }} <br>
                    TLF: {{ $company->phone }} <br>
                    {{ strtoupper($company->city) }} - {{ strtoupper($company->country) }} 
                </td>
            </tr>
        </table>
        
         <table class="tHeaderPrin">
            <thead>
                  <tr class="tHeader">
                     <th class="text-center medium-letter">Farm</th>
                     <th class="text-center medium-letter">Date / Fecha</th>
                     <th colspan="2" class="text-center medium-letter">Country INVOICE N°</th>
                     <th class="text-center medium-letter">B/L N°</th>
                     <th class="text-center medium-letter">Carrier</th>
                  </tr>
            </thead>
            <tbody>
                  <tr class="tHeader2">
                     <td class="small-letter text-center">VF</td>
                     <td class="small-letter text-center">{{ date('d-m-Y', strtotime($invoiceheaders->date)) }}</td>
                     <td class="small-letter text-center">GYE</td>
                     <td class="small-letter text-center">{{ $invoiceheaders->invoice }}</td>
                     <td class="small-letter text-center">{{ $invoiceheaders->bl }}</td>
                     <td class="small-letter text-center">{{ $invoiceheaders->carrier }}</td>
                  </tr>
            </tbody>
         </table>
    
    
    
    <main>
        <table class="table">
      
         <tr class="tHeader3">
             <th class="text-center small-letter">Fulls</th>
             <th class="text-center small-letter">Pcs</th>
             <th class="text-center small-letter">Bunch per box</th>
             <th class="text-center farms small-letter">Flower Provider</th>
             <th class="text-center small-letter client">Client</th>
             <th class="text-center small-letter gender">Genus</th>
             <th class="text-center small-letter gender">Species</th>
             <th class="text-center small-letter c-width">Hawb</th>
             <th class="text-center small-letter">Total Stems</th>
             <th class="text-center small-letter">Price</th>
             <th class="text-center small-letter">Total Bunch</th>
             <th class="text-center small-letter">Total USD</th>
         </tr>
     
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
    
    <table class="sinb">
      <tbody>
          <tr>
              <td class="small-letter text-center">Name and title of person preparing invoice</td>
              <td class="small-letter text-center">Freight forwarder / Agencia de carga</td>
          </tr>
          <tr>
              <td class="small-letter text-center"></td>
              <td class="small-letter text-center">{{ strtoupper($lc_active->name) }}</td>
          </tr>
      </tbody>
      <tbody>
          <tr>
              <td class="firma"></td>
              <td class="firma"></td>
          </tr>
      </tbody>
      <tfoot>
          <tr>
              <th class="small-letter text-center">SIGNATURE</th>
              <th class="small-letter text-center">NANDINA</th>
          </tr>
      </tfoot>
  </table>

    </main>

    
    
    
   
</body>
</html>