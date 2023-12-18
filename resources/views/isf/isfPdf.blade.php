<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISF - {{ $load->bl }} - {{ date('m-d-Y', strtotime($load->date)) }}</title>
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
</head>
<body>
    <table>
        <tr>
            <th colspan="6" class="large-letter">ISF - {{ $load->bl }} - {{ date('m/d/Y', strtotime($load->date)) }}</th>
        </tr>
        <tr>
            <th class="medium-letter text-center">Farms</th>
            <th class="medium-letter text-center">Address</th>
            <th class="medium-letter text-center">Phones</th>
            <th class="medium-letter text-center">City</th>
            <th class="medium-letter text-center">State</th>
            <th class="medium-letter text-center">Country</th>
        </tr>
        @foreach ($farmsItemsLoad as $item)
            <tr>
                <td class="medium-letter text-left">{{ $item->name }}</td>
                <td class="medium-letter text-left">{{ $item->address }}</td>
                <td class="medium-letter text-center">{{ $item->phone }}</td>
                <td class="medium-letter text-center">{{ $item->city }}</td>
                <td class="medium-letter text-center">{{ $item->state }}</td>
                <td class="medium-letter text-center">{{ $item->country }}</td>
            </tr>
        @endforeach
        
    </table>
    
</body>
</html>