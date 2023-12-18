<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COORDINACION MARITIMO {{ $load->bl }} - #{{ $load->shipment }}</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-size: 1em;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 2cm 1cm 1cm;
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
            font-size: 8px;
        }
        .large-letter{
            font-size: 9px;
        }
        .farms{
            width: 300px;
        }
        
        table, th, td{
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
        .sin-border2{
            padding: 5px;
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
        header{
            position: fixed;
            top: 10px;
            left: 38px;
            right: 38px;
        }
        main{
            margin: 20px;
            top: 30px;
            left: 38px;
            right: 38px;
        }
    </style>
</head>
<body>
    <header>
        <h3 class="text-center"><ins>COORDINACIÓN MARITIMO - {{ $load->bl }} - #{{ $load->shipment }}</ins></h3>
    </header>
    <main>
        <table class="table">
            @php
                $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $totalPcsr = 0; $totalHbr = 0; $totalQbr = 0;
                $totalEbr = 0; $totalFullsr = 0; $totalDevr = 0; $totalMissingr = 0;
            @endphp
        
            @foreach($clientsCoordination as $client)
                
                <tr>
                    <th class="text-center medium-letter" colspan="15">{{ $client['name'] }}</th>
                </tr>
                
                <tr class="gris2">
                    <th class="text-center hawb medium-letter">Finca</th>
                    <th class="text-center hawb medium-letter">HAWB</th>
                    <th class="text-center medium-letter">Variedad</th>
                    <th class="text-center medium-letter coordinado">PCS</th>
                    <th class="text-center medium-letter coordinado">HB</th>
                    <th class="text-center medium-letter coordinado">QB</th>
                    <th class="text-center medium-letter coordinado">EB</th>
                    <th class="text-center medium-letter coordinado">FULL</th>
                    <th class="text-center medium-letter recibido">PCS</th>
                    <th class="text-center medium-letter recibido">HB</th>
                    <th class="text-center medium-letter recibido">QB</th>
                    <th class="text-center medium-letter recibido">EB</th>
                    <th class="text-center medium-letter recibido">FULL</th>
                    <th class="text-center medium-letter devolucion">Dev</th>
                    <th class="text-center medium-letter faltante">Faltantes</th>
                </tr>
                <tbody>
                    @php
                        $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0; $totalPieces = 0; $tPcsR = 0;
                        $tHbr = 0; $tQbr = 0; $tEbr = 0; $tFullsR = 0; $tDevR = 0; $tMissingR = 0;
                    @endphp
                    @foreach($coordinations as $item)
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
                            <td class="farms small-letter">{{ $item->name }}</td>
                            <td class="text-center small-letter">{{ $item->hawb }}</td>
                            <td class="text-center small-letter">{{ $item->variety->name }}</td>
                            <td class="text-center small-letter">{{ $item->pieces > 0 ? $item->pieces : '' }}</td>
                            <td class="text-center small-letter">{{ $item->hb > 0 ? $item->hb : '' }}</td>
                            <td class="text-center small-letter">{{ $item->qb > 0 ? $item->qb : '' }}</td>
                            <td class="text-center small-letter">{{ $item->eb > 0 ? $item->eb : '' }}</td>
                            <td class="text-center small-letter">{{ number_format($item->fulls, 3, '.','') }}</td>
                            <td class="text-center small-letter">{{ $item->pieces_r > 0 ? $item->pieces_r : '' }}</td>
                            <td class="text-center small-letter">{{ $item->hb_r > 0 ? $item->hb_r : '' }}</td>
                            <td class="text-center small-letter">{{ $item->qb_r > 0 ? $item->qb_r : '' }}</td>
                            <td class="text-center small-letter">{{ $item->eb_r > 0 ? $item->eb_r : '' }}</td>
                            <td class="text-center small-letter">{{ $item->fulls_r > 0 ? number_format($item->fulls_r, 3, '.','') : ''}}</td>
                            <td class="text-center small-letter">{{ $item->returns > 0 ? $item->returns : '' }}</td>
                            <td class="text-center small-letter">{{ $item->missing > 0 ? $item->missing : '' }}</td>
                        </tr>
            
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
                    <th class="text-center text-right medium-letter" colspan="3">Total:</th>
                    <th class="text-center medium-letter coordinado">{{ $tPieces }}</th>
                    <th class="text-center medium-letter coordinado">{{ $tHb }}</th>
                    <th class="text-center medium-letter coordinado">{{ $tQb }}</th>
                    <th class="text-center medium-letter coordinado">{{ $tEb }}</th>
                    <th class="text-center medium-letter coordinado">{{ number_format($tFulls, 3, '.','') }}</th>
                    <th class="text-center medium-letter recibido">{{ $tPcsR }}</th>
                    <th class="text-center medium-letter recibido">{{ $tHbr }}</th>
                    <th class="text-center medium-letter recibido">{{ $tQbr }}</th>
                    <th class="text-center medium-letter recibido">{{ $tEbr }}</th>
                    <th class="text-center medium-letter recibido">{{ number_format($tFullsR, 3, '.','') }}</th>
                    <th class="text-center medium-letter devolucion">{{ $tDevR }}</th>
                    <th class="text-center medium-letter faltante">{{ $tMissingR }}</th>
                </tr>
                @php
                    $totalPieces+= $totalHb + $totalQb + $totalEb;
                @endphp
                <tr>
                    <th colspan="15" class="sin-border2"></th>
                </tr>
            @endforeach
            </tbody>
                
            <tfoot>
                
                
                <tr>
                    <th colspan="15" class="sin-border2"></th>
                </tr>
                <tr class="gris">
                    <th class="text-center medium-letter" colspan="3">Total Global:</th>
                    <th class="text-center medium-letter coordinado">{{ $totalPieces }}</th>
                    <th class="text-center medium-letter coordinado">{{ $totalHb }}</th>
                    <th class="text-center medium-letter coordinado">{{ $totalQb }}</th>
                    <th class="text-center medium-letter coordinado">{{ $totalEb }}</th>
                    <th class="text-center medium-letter coordinado">{{ number_format($totalFulls, 3, '.','') }}</th>
                    <th class="text-center medium-letter recibido">{{ $totalPcsr }}</th>
                    <th class="text-center medium-letter recibido">{{ $totalHbr }}</th>
                    <th class="text-center medium-letter recibido">{{ $totalQbr }}</th>
                    <th class="text-center medium-letter recibido">{{ $totalEbr }}</th>
                    <th class="text-center medium-letter recibido">{{ number_format($totalFullsr, 3, '.','') }}</th>
                    <th class="text-center medium-letter devolucion">{{ $totalDevr }}</th>
                    <th class="text-center medium-letter faltante">{{ $totalMissingr }}</th>
                </tr>
            </tfoot>
        </table>
    </main>

    
</body>
</html>