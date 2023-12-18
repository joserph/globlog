<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISF 10+2 form SAG - {{ $load->bl }}</title>
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
        .border-arriba{
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid white;
            border-left: 1px solid black;
        }
        .border-arriba-ama{
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid yellow;
            border-left: 1px solid black;
        }
        .border-arriba-abajo{
            border-top: 1px solid white;
            border-right: 1px solid black;
            border-bottom: 1px solid white;
            border-left: 1px solid black;
        }
        .border-arriba-abajo-ama{
            border-top: 1px solid yellow;
            border-right: 1px solid black;
            border-bottom: 1px solid yellow;
            border-left: 1px solid black;
        }
        .border-izq-der{
            border-top: 1px solid black;
            border-right: 1px solid white;
            border-bottom: 1px solid black;
            border-left: 1px solid white;
        }
        .border-abajo{
            border-top: 1px solid white;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            border-left: 1px solid black;
        }
        .border-abajo-bla{
            border-top: 1px solid black;
            border-right: 1px solid white;
            border-bottom: 1px solid white;
            border-left: 1px solid white;
        }
        .border-bla{
            border-top: 1px solid white;
            border-right: 1px solid white;
            border-bottom: 1px solid white;
            border-left: 1px solid white;
        }
        .border-abajo-neg{
            border-top: 1px solid white;
            border-right: 1px solid white;
            border-bottom: 1px solid black;
            border-left: 1px solid white;
        }
        .box-size{
            width: 40px;
        }
        .gris{
            background-color: #d1cfcf;
        }
        .alto{
            height: 30px;
        }
        .medio{
            height: 20px;
        }
        .amarillo_claro{
            background-color: rgb(248, 234, 155)
        }
        .amarillo{
            background-color: yellow
        }
        .piel{
            background-color: rgb(245, 203, 149)
        }
        .azul_agua{
            background-color: rgb(207, 248, 253)
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="2" class="large-letter amarillo_claro">Importer Or Shipper Letter of Instruction For ISF 10 + 2</th>
        </tr>
        <tr>
            <th colspan="2" class="large-letter border-izq-der"></th>
        </tr>
        <tr>
            <th class="medium-letter text-center piel">**** Part A for Origin ***</th>
            <th class="medium-letter text-center azul_agua">**** Part B for Destination ***</th>
        </tr>
        <tr>
            <td colspan="2" class="large-letter border-izq-der"></td>
        </tr>
        <tr>
            <td class="medium-letter text-left piel">(1) Seller Name and Complete Address</td>
            <td class="medium-letter text-left azul_agua">(6) Buyer Name and Complete Address</td>
        </tr>
        <tr>
            <td class="medium-letter text-left" rowspan="5"></td>
            <td class="medium-letter text-left border-arriba">{{ $my_company->name }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($my_company->address) }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($my_company->city)  }}, {{ strtoupper($my_company->state)  }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left alto" rowspan="2"></td>
        </tr>
        <tr></tr>
        <tr>
            <td class="medium-letter text-left piel">(2) Manufacturer  Name and Complete Address</td>
            <td class="medium-letter text-left azul_agua">(7) Importer Of Record Number (EIN, SSN.)</td>
        </tr>
        <tr>
            <td class="medium-letter text-left" rowspan="5"></td>
            <td class="medium-letter text-left border-arriba">84-4098314</td>
        </tr>
        <tr>
            <th class="large-letter alto" rowspan="4"></th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td class="medium-letter text-left piel">(3) Container Stuffing Location (Name and Complete Address)</td>
            <td class="medium-letter text-left azul_agua">(8) Ship To Party  Name and Complete Address</td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo border-arriba"></td>
            <td class="medium-letter text-left border-arriba">{{ $my_company->name }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ $logistic_company->name }}</td>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($my_company->address)  }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($logistic_company->address) }}</td>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($my_company->city)  }}, {{ strtoupper($my_company->state)  }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($logistic_company->city) }} - {{ strtoupper($logistic_company->country) }}</td>
            <td class="medium-letter text-left" rowspan="2"></td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo border-abajo"></td>
        </tr>
        <tr>
            <td class="medium-letter text-left piel">(4) Consolidator Name and Complete Address</td>
            <td class="medium-letter text-left azul_agua">(9) Consignee Number (EIN, SSN.)</td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo border-arriba"></td>
            <td class="medium-letter text-left border-arriba">84-4098314</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ $logistic_company->name }}</td>
            <td class="medium-letter text-left" rowspan="5"></td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($logistic_company->address) }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left border-arriba-abajo">{{ strtoupper($logistic_company->city) }} - {{ strtoupper($logistic_company->country) }}</td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo" rowspan="2"></td>
        </tr>
        <tr></tr>
        <tr>
            <td class="medium-letter text-left piel">(5) AMS House Bill Of Lading Number</td>
            <td class="medium-letter text-left azul_agua">(10) Country of Origin </td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo border-arriba-ama">SCAC Code:</td>
            <td class="medium-letter text-left azul_agua">Please include invoices with this form***</td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo border-arriba-abajo-ama">AMS House Bill #:</td>
            <td class="medium-letter text-left border-arriba"></td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo border-arriba-abajo-ama">AMS Master Bill #: {{ $load->bl }}</td>
            <td class="medium-letter text-left border-arriba-abajo">ECUADOR</td>
        </tr>
        <tr>
            <td class="medium-letter text-left amarillo" rowspan="4"></td>
            <td class="medium-letter text-left alto" rowspan="4"></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th class="medium-letter azul_agua" colspan="2">(11) Description of Articles & Commodity HTS to Ten Digit  ** Please provide invoice (s) to Complete ***</th>
        </tr>
        <tr>
            <th class="medium-letter border-arriba" colspan="2"></th>
        </tr>
        <tr>
            <th class="medium-letter text-left border-arriba-abajo" colspan="2">Multiple</th>
        </tr>
        <tr>
            <td class="medium-letter text-left alto" rowspan="11" colspan="2"></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th class="large-letter border-abajo-bla" colspan="2"></th>
        </tr>
        <tr>
            <th class="medium-letter text-left border-bla" colspan="2">Information provided by:</th>
        </tr>
        <tr>
            <th class="large-letter border-bla" colspan="2"></th>
        </tr>
        <tr>
            <td class="medium-letter text-left border-abajo-neg">Name:</td>
            <td class="medium-letter text-left border-abajo-neg">Date:</td>
        </tr>
        <tr>
            <th class="large-letter border-abajo-bla" colspan="2"></th>
        </tr>
        <tr>
            <th class="medium-letter text-left border-abajo-neg" colspan="2">Company:</th>
        </tr>
    </table>
    
</body>
</html>