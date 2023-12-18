<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MARITIMO {{ $load->bl }}</title>
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
            width: 100%;
            page-break-before:auto;
        }

        .small-letter{
            font-size: 8px;
            font-weight: normal;
        }
        .medium-letter{
            font-size: 9px;
        }
        .large-letter{
            font-size: 10px;
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
        }
        table.sinb, td{
            border: 1px solid black;
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
        .gris2{
            background-color: #f0f0f0;
        }
        .coordinado{
            background-color: rgb(217, 244, 255);
        }
        .recibido{
            background-color: rgb(191, 255, 231);
        }
        .devolucion{
            background-color: rgb(255, 187, 200);
        }
        .faltante{
            background-color: rgb(255, 255, 175);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
    <table>
        <tr>
            <th class="medium-letter">MARITIMO - {{ $load->bl }} - #{{ $load->shipment }}</th>
        </tr>
    </table>
    
    <table>
        @php
            $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $totalPcsr = 0; $totalHbr = 0; $totalQbr = 0;
            $totalEbr = 0; $totalFullsr = 0; $totalDevr = 0; $totalMissingr = 0;
        @endphp
        
        @foreach($resumenCargaAll as $client)
            <thead>
                <tr>
                    <th class="text-center medium-letter" colspan="5">{{ $client['name'] }}</th>
                </tr>
            </thead>
            <thead>
                <tr class="gris2">
                    <th class="text-center hawb medium-letter">Finca</th>
                    <th class="text-center medium-letter pcs-bxs">HB</th>
                    <th class="text-center medium-letter pcs-bxs">QB</th>
                    <th class="text-center medium-letter pcs-bxs">EB</th>
                    <th class="text-center medium-letter pcs-bxs">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0; $totalPieces = 0; $tPcsR = 0;
                    $tHbr = 0; $tQbr = 0; $tEbr = 0; $tFullsR = 0; $tDevR = 0; $tMissingR = 0;
                @endphp
                @foreach($itemsCarga as $item)
                    @if($client['id'] == $item['id_client'])
                        @php
                            $tPieces+= $item['quantity'];
                            $tHb+= $item['hb'];
                            $tQb+= $item['qb'];
                            $tEb+= $item['eb'];
                        @endphp
                        <tr>
                            <td class="farms small-letter">{{ $item['farms'] }}</td>
                            <td class="text-center small-letter">{{ $item['hb'] }}</td>
                            <td class="text-center small-letter">{{ $item['qb'] }}</td>
                            <td class="text-center small-letter">{{ $item['eb'] }}</td>
                            <td class="text-center small-letter">{{ $item['quantity'] }}</td>
                        </tr>
            
                    @endif
                @endforeach
                @php
                    $totalHb+= $tHb;
                    $totalQb+= $tQb;
                    $totalEb+= $tEb;
                @endphp
                <tr class="gris">
                    <th class="text-center text-right medium-letter">Total:</th>
                    <th class="text-center medium-letter">{{ $tHb }}</th>
                    <th class="text-center medium-letter">{{ $tQb }}</th>
                    <th class="text-center medium-letter">{{ $tEb }}</th>
                    <th class="text-center medium-letter">{{ $tPieces }}</th>
                </tr>
            </tbody>
        @endforeach
        <tfoot>
            @php
                $totalPieces+= $totalHb + $totalQb + $totalEb;
            @endphp
            
            <tr>
                <th colspan="5" class="sin-border"></th>
            </tr>
            <tr class="gris">
                <th class="text-center medium-letter">Total Global:</th>
                <th class="text-center medium-letter">{{ $totalHb }}</th>
                <th class="text-center medium-letter">{{ $totalQb }}</th>
                <th class="text-center medium-letter">{{ $totalEb }}</th>
                <th class="text-center medium-letter">{{ $totalPieces }}</th>
            </tr>
        </tfoot>

    </table>

   
</body>
</html>