<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flight;
use App\Company;
use App\Distribution;
use App\Farm;
use App\Client;
use App\Variety;
use App\Http\Requests\AddDistributionRequest;
use Barryvdh\DomPDF\Facade as PDF;
use App\Color;
use App\Marketer;
use App\Http\Requests\UpdateDistributionRequest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Arr;
use App\Hawb;
use Auth;

class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        // Vuelo actual
        $flight = Flight::find($code);
        // Empresa
        $company = Company::first();
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsDistr = Distribution::where('id_flight', '=', $code)
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsDistr->toArray(), SORT_REGULAR));
        // Fincas
        $farms = Farm::orderBy('name', 'ASC')->pluck('name', 'id');
        $farmsList = Farm::select('id', 'name', 'tradename')->orderBy('name', 'ASC')->get();
        // Clientes
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
        // Variedades
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');
        // Comercializadores
        $marketers = Marketer::orderBy('name', 'ASC')->pluck('name', 'id');
        // Coordinaciones
        $distributions = Distribution::select('*')
            ->where('id_flight', '=', $code)
            ->with('variety')
            ->WITH('marketer')
            ->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        // Colores
        $colors = Color::where('load_type', 'aereo')->get();
        // HAWB Propia
        $hawb = Hawb::select('hawb')->get()->last();
        // Verifico que Sea guia propia
        // if($flight->type_awb == 'own')
        // {
        //     // Formateamos la guia
        //     $new_hawb = (intval($hawb->hawb) + 1);
        //     $hawb_zero = str_pad($new_hawb, 8, "0", STR_PAD_LEFT);
        //     $uno = substr($hawb_zero, 0, 4);
        //     $dos = substr($hawb_zero, 4, 8);
        //     $hawb_format = 'FFC-' . $uno . '-' . $dos;
        // }else{
        //     $hawb_format = null;
        // }
        //
        return view('distribution.index', compact('flight', 'company', 'clientsDistribution', 'farms', 'clients', 'varieties', 'distributions', 'marketers', 'colors', 'farmsList', 'clientsList'));
    }

    public function distributionExcel($code)
    {
        $flight = Flight::find($code);
        //dd($flight);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(43);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(40);
        $spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(30);

        $letra = 'A';
        for($letra; $letra <= 'T'; $letra++)
        {
            $spreadsheet->getActiveSheet()->getStyle($letra . '1:' . $letra . '150')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');
        }


        $sheet->getStyle('B7:P7')->getFont()->setBold(true);
        $sheet->getStyle('B8:P8')->getFont()->setBold(true);
        $sheet->getStyle('B8:P8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B8:P8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Titulo
        $sheet->getStyle('B2:P2')->getFont()->setBold(true);
        $sheet->mergeCells('B2:P2');
        $sheet->getStyle('B2:P2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:P2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:P2')->getFont()->setSize(24);
        $sheet->setCellValue('B2', 'COORDINACIONES AÉREAS');
        // Guia
        $sheet->mergeCells('L3:M3');
        $sheet->getStyle('L3:M3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L3:M3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('L3', 'AWB');

        $sheet->getStyle('N3:O3')->getFont()->setBold(true);
        $sheet->mergeCells('N3:O3');
        $sheet->getStyle('N3:O3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('N3:O3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('N3', str_replace('AWB', '', $flight->awb) );
        // Fecha Salida
        $sheet->mergeCells('L4:M4');
        $sheet->getStyle('L4:M4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L4:M4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('L4', 'FECHA SALIDA');

        $sheet->getStyle('N4:O4')->getFont()->setBold(true);
        $sheet->mergeCells('N4:O4');
        $sheet->getStyle('N4:O4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('N4:O4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('N4', date('d/m/Y', strtotime($flight->date)) );
        // Fecha Llegada
        $sheet->mergeCells('L5:M5');
        $sheet->getStyle('L5:M5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L5:M5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('L5', 'FECHA LLEGADA');

        $sheet->getStyle('N5:O5')->getFont()->setBold(true);
        $sheet->mergeCells('N5:O5');
        $sheet->getStyle('N5:O5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('N5:O5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('N5', date('d/m/Y', strtotime($flight->arrival_date)) );
        // Head coordinado
        $sheet->mergeCells('E7:I7');
        $sheet->getStyle('E7:I7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E7:I7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('E7:I7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('FFFF00');
        $sheet->getStyle('E7:I7')->applyFromArray($styleArray);
        $sheet->setCellValue('E7', 'COORDINADO');
        // Head RECIBIDO
        $sheet->mergeCells('J7:N7');
        $sheet->getStyle('J7:N7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('J7:N7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('J7:N7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('00B050');
        $sheet->getStyle('J7:N7')->applyFromArray($styleArray);
        $sheet->setCellValue('J7', 'RECIBIDO');
        // HEAD
        $sheet->setCellValue('B8', 'HAWB');
        $sheet->setCellValue('C8', 'FINCAS');
        $sheet->setCellValue('D8', 'VARIEDADES');
        $spreadsheet->getActiveSheet()->getStyle('B8:D8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('00B0F0');
        $sheet->getStyle('B8:D8')->applyFromArray($styleArray);

        $sheet->setCellValue('E8', 'HB');
        $sheet->setCellValue('F8', 'QB');
        $sheet->setCellValue('G8', 'EB');
        $sheet->setCellValue('H8', 'TOTAL PCS');
        $sheet->setCellValue('I8', 'FBX');
        $spreadsheet->getActiveSheet()->getStyle('E8:I8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('FFFF00');
        $sheet->getStyle('E8:I8')->applyFromArray($styleArray);

        $sheet->setCellValue('J8', 'HB');
        $sheet->setCellValue('K8', 'QB');
        $sheet->setCellValue('L8', 'EB');
        $sheet->setCellValue('M8', 'TOTAL PCS');
        $sheet->setCellValue('N8', 'FBX');
        $spreadsheet->getActiveSheet()->getStyle('J8:N8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('00B050');
        $sheet->getStyle('J8:N8')->applyFromArray($styleArray);

        $sheet->setCellValue('O8', 'DIFERENCIA');
        $sheet->setCellValue('P8', 'OBSERVACIONES');
        $spreadsheet->getActiveSheet()->getStyle('O8:P8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('00B0F0');
        $sheet->getStyle('O8:P8')->applyFromArray($styleArray);

        // CLIENTES
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsDistr = Distribution::where('id_flight', '=', $code)
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsDistr->toArray(), SORT_REGULAR));
        // colors
        //$colors = Color::where('type', '=', 'client')->get();
        $colors = Color::where('type', '=', 'client')->where('load_type', 'aereo')->get();
        // Coordinaciones
        $coordinations = Distribution::select('*')
            ->where('id_flight', '=', $code)
            ->with('variety')
            ->with('farm')
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.name', 'distributions.*')
            ->orderBy('clients.name', 'ASC')
            /*->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')*/
            ->get();
        
        $fila = 9;
        $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $totalPcsr = 0; $totalHbr = 0; $totalQbr = 0;
        $totalEbr = 0; $totalFullsr = 0; $totalDevr = 0; $totalMissingr = 0;
        foreach($clientsDistribution as $key => $client)
        {
            foreach($colors as $color)
            {
                if($color->id_type == $client['id'])
                {
                    
                    $colorFila = str_replace('#', '', $color->color);
                    $spreadsheet->getActiveSheet()->getStyle('B'. $fila .':P' .$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($colorFila);
                    $spreadsheet->getActiveSheet()->getStyle('B'. $fila)
                        ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                }
            }
            // Totales variable
            $count = 0; $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0; $totalPieces = 0; $tPcsR = 0;
            $tHbr = 0; $tQbr = 0; $tEbr = 0; $tFullsR = 0; $tDevR = 0; $tMissingR = 0;

            $sheet->mergeCells('B'. $fila .':P' .$fila);
            $sheet->getStyle('B'. $fila .':P' .$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B'. $fila .':P' .$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'. $fila .':P' .$fila)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);
            $sheet->getStyle('B'. $fila .':P' .$fila)->getFont()->setSize(18);
            $sheet->setCellValue('B' . $fila, $client['name']);
            $sheet->getStyle('B'. $fila .':P' .$fila)->getFont()->setBold(true);
            
            $filaDos = $fila + 1;
            $arrSubTotal = array();
            $indice = 0;
            foreach($coordinations as $key => $coord)
            {
                if($coord->id_client == $client['id'])
                {
                    $tPieces+= $coord->pieces;
                    $tFulls+= $coord->fulls;
                    $tHb+= $coord->hb;
                    $tQb+= $coord->qb;
                    $tEb+= $coord->eb;
                    $tPcsR+= $coord->pieces_r;
                    $tHbr+= $coord->hb_r;
                    $tQbr+= $coord->qb_r;
                    $tEbr+= $coord->eb_r;
                    $tFullsR+= $coord->fulls_r;
                    $tDevR+= $coord->returns;
                    $tMissingR+= $coord->missing;

                    $sheet->getStyle('B'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('B'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('D'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('D'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('P'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('P'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $spreadsheet->getActiveSheet()->getRowDimension($filaDos)->setRowHeight(20);
                    /*$spreadsheet->getActiveSheet()->getStyle('P'. $filaDos)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FF0000');*/
                    $spreadsheet->getActiveSheet()->getStyle('P'. $filaDos)
                        ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                    
                    $sheet->getStyle('E'. $filaDos .':O' .$filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('E'. $filaDos .':O' .$filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $spreadsheet->getActiveSheet()->getStyle('I' . $filaDos)->getNumberFormat()->setFormatCode('#,##0.000');
                    $spreadsheet->getActiveSheet()->getStyle('N' . $filaDos)->getNumberFormat()->setFormatCode('#,##0.000');
                    


                    $sheet->setCellValue('B' . $filaDos, $coord->hawb);
                    
                    $sheet->setCellValue('C' . $filaDos, $coord->farm->name);
                    
                    $sheet->setCellValue('D' . $filaDos, $coord->variety->name);

                    $sheet->setCellValue('E' . $filaDos, $coord->hb);
                    
                    $sheet->setCellValue('F' . $filaDos, $coord->qb);
                    
                    $sheet->setCellValue('G' . $filaDos, $coord->eb);

                    //$sheet->setCellValue('H' . $filaDos, $coord->pieces);
                    $sheet->setCellValue('H' . $filaDos, '=SUM(E' . $filaDos . ':G' . $filaDos . ')');
                    
                    $sheet->setCellValue('I' . $filaDos, '=+(E' . $filaDos . '*0.5)+(F' . $filaDos . '*0.25)+(G' . $filaDos . '*0.125)');
                    
                    $sheet->setCellValue('J' . $filaDos, $coord->hb_r);

                    $sheet->setCellValue('K' . $filaDos, $coord->qb_r);
                    
                    $sheet->setCellValue('L' . $filaDos, $coord->eb_r);
                    
                    $sheet->setCellValue('M' . $filaDos, '=SUM(J' . $filaDos . ':L' . $filaDos . ')');

                    $sheet->setCellValue('N' . $filaDos, '=+(J' . $filaDos . '*0.5)+(K' . $filaDos . '*0.25)+(L' . $filaDos . '*0.125)');
                    
                    $sheet->setCellValue('O' . $filaDos, '=+H' . $filaDos . '-M' . $filaDos);
                    
                    if($coord->id_marketer)
                    {
                        $observation = 'COMPRA DE ' . $coord->marketer->name . ' ' . $coord->observation;
                    }else{
                        $observation = $coord->observation;
                    }
                    $sheet->setCellValue('P' . $filaDos, $observation);
                    $sheet->getStyle('B'. $filaDos .':P' .$filaDos)->applyFromArray($styleArray);
                    //dd($filaDos);
                    $filaDos++;
                    
                }
                //
                
            }
            
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

            // Imprimimos SubTotales
            $numCell = $filaDos;
            
            $sheet->mergeCells('B'. $numCell .':D' .$numCell);
            $sheet->getStyle('B'. $numCell .':D' .$numCell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B'. $numCell .':D' .$numCell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'. $numCell .':O' .$numCell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('E'. $numCell .':O' .$numCell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            /*$spreadsheet->getActiveSheet()->getStyle('B'. $numCell .':D' .$numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');*/
            $spreadsheet->getActiveSheet()->getStyle('E'. $numCell .':I' .$numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E2EFDA');
            $spreadsheet->getActiveSheet()->getStyle('J'. $numCell .':N' .$numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFF2CC');
            $sheet->getStyle('B'. $numCell .':P' .$numCell)->getFont()->setBold(true);
            $sheet->getStyle('B'. $numCell .':D' .$numCell)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getRowDimension($numCell)->setRowHeight(20);
            //$spreadsheet->getActiveSheet()->getStyle('I' . $numCell)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Shared\StringHelper::setDecimalSeparator(','));
            //$spreadsheet->getActiveSheet()->getStyle('I' . $numCell)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $spreadsheet->getActiveSheet()->getStyle('I' . $numCell)->getNumberFormat()->setFormatCode('#,##0.000');
            $spreadsheet->getActiveSheet()->getStyle('N' . $numCell)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->setCellValue('B' . $numCell, 'SUB-TOTAL');
            
            //$subtotalVal = ["$indice" => $numCell];
            //array_push($arrSubTotal, $numCell);
            $arrSubTotal[] = $numCell;
            //print_r($arrSubTotal);
            
            //$sheet->setCellValue('C' . $numCell, 'SUB-TOTAL');

            $sheet->setCellValue('D' . $numCell, '');

            $sheet->setCellValue('E' . $numCell, '=SUM(E' . ($fila + 1) . ':E' . ($numCell - 1) . ')');

            $sheet->setCellValue('F' . $numCell, '=SUM(F' . ($fila + 1) . ':F' . ($numCell - 1) . ')');

            $sheet->setCellValue('G' . $numCell, '=SUM(G' . ($fila + 1) . ':G' . ($numCell - 1) . ')');

            $sheet->setCellValue('H' . $numCell, '=SUM(H' . ($fila + 1) . ':H' . ($numCell - 1) . ')');

            $sheet->setCellValue('I' . $numCell, '=SUM(I' . ($fila + 1) . ':I' . ($numCell - 1) . ')');

            $sheet->setCellValue('J' . $numCell, '=SUM(J' . ($fila + 1) . ':J' . ($numCell - 1) . ')');

            $sheet->setCellValue('K' . $numCell, '=SUM(K' . ($fila + 1) . ':K' . ($numCell - 1) . ')');

            $sheet->setCellValue('L' . $numCell, '=SUM(L' . ($fila + 1) . ':L' . ($numCell - 1) . ')');

            $sheet->setCellValue('M' . $numCell, '=SUM(M' . ($fila + 1) . ':M' . ($numCell - 1) . ')');

            $sheet->setCellValue('N' . $numCell, '=SUM(N' . ($fila + 1) . ':N' . ($numCell - 1) . ')');

            $sheet->setCellValue('O' . $numCell, '=SUM(O' . ($fila + 1) . ':O' . ($numCell - 1) . ')');

            $sheet->setCellValue('P' . $numCell, '');
            
            $sheet->getStyle('B'. $numCell .':P' .$numCell)->applyFromArray($styleArray);

            $totalPieces+= $totalHb + $totalQb + $totalEb;

            // Espacio en blanco
            $space = $numCell + 1;
            //
            /*$spreadsheet->getActiveSheet()->getStyle('B'. $space .':P' .$space)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');*/
            $sheet->setCellValue('B' . $space, '');
            $fila = $space + 1;

            // Arreglo para guardar los Subtotales
            
            foreach($arrSubTotal as $t)
            {
                //print_r($t . '-');
                $arrSubTotal2[] = $t;
            }
            //
            
        }
        
        //dd($arrSubTotal2);

        /*$cadena = '';
        foreach($arrSubTotal2 as $tot)
        {
            $cadena .= '+B' . $tot;
        }*/
        //dd($cadena);

        /*$spreadsheet->getActiveSheet()->getStyle('B'. $fila .':P' .$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');*/
        $numCellTotal = $fila + 1;
        /*$spreadsheet->getActiveSheet()->getStyle('B'. $numCellTotal .':P' .$numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');*/
        $sheet->mergeCells('B'. $numCellTotal .':D' .$numCellTotal);
        $sheet->getStyle('B'. $numCellTotal .':D' .$numCellTotal)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B'. $numCellTotal .':D' .$numCellTotal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E'. $numCellTotal .':O' .$numCellTotal)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E'. $numCellTotal .':O' .$numCellTotal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B'. $numCellTotal .':D' .$numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('00B0F0');
        $spreadsheet->getActiveSheet()->getStyle('E'. $numCellTotal .':I' .$numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00');
        $spreadsheet->getActiveSheet()->getStyle('J'. $numCellTotal .':N' .$numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('00B050');
        $spreadsheet->getActiveSheet()->getStyle('O'. $numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('00B0F0');
        $spreadsheet->getActiveSheet()->getRowDimension($numCellTotal)->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getStyle('I' . $numCellTotal)->getNumberFormat()->setFormatCode('#,##0.000');
        $spreadsheet->getActiveSheet()->getStyle('N' . $numCellTotal)->getNumberFormat()->setFormatCode('#,##0.000');
        $sheet->getStyle('B'. $numCellTotal .':P' .$numCellTotal)->getFont()->setBold(true);
        $sheet->getStyle('B'. $numCellTotal .':O' .$numCellTotal)->applyFromArray($styleArray);

        $sheet->setCellValue('B' . $numCellTotal, 'TOTAL');

        // SUMAR TODOS LOS SUBTOTALES DESDE LA CELDA E HASTA LA O.
        
        $i = 'E';
        for($i; $i <= 'O'; $i++)
        {
            $cadena = '';
            //$cadena2 .= $i;
            foreach($arrSubTotal2 as $tot)
            {
                $cadena .= '+' . $i . $tot;
            }
            $sheet->setCellValue($i . $numCellTotal, '=' . $cadena);
        }
        //dd($cadena2);

        /*$sheet->setCellValue('E' . $numCellTotal, '=' . $cadena);

        $sheet->setCellValue('F' . $numCellTotal, $totalQb);

        $sheet->setCellValue('G' . $numCellTotal, $totalEb);

        $sheet->setCellValue('H' . $numCellTotal, $totalPieces);

        $sheet->setCellValue('I' . $numCellTotal, $totalFulls);

        $sheet->setCellValue('J' . $numCellTotal, $totalHbr);

        $sheet->setCellValue('K' . $numCellTotal, $totalQbr);

        $sheet->setCellValue('L' . $numCellTotal, $totalEbr);

        $sheet->setCellValue('M' . $numCellTotal, $totalPcsr);

        $sheet->setCellValue('N' . $numCellTotal, $totalFullsr);
        
        $sheet->setCellValue('O' . $numCellTotal, $totalMissingr);*/

        


        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath('images/logo-ffc.png'); // put your path and image here
        $drawing->setCoordinates('B2');
        $drawing->setOffsetX(50);
        $drawing->setRotation(0);
        //$drawing->getShadow()->setVisible(true);
        //$drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());






        $writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="CONF Y DISTR ' . $flight->awb . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function distributionPdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        // Vuelo actual
        $flight = Flight::find($code);

        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsDistr = Distribution::where('id_flight', '=', $code)
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsDistr->toArray(), SORT_REGULAR));
        // Coordinaciones
        $coordinations = Distribution::select('*')
            ->where('id_flight', '=', $code)
            ->with('variety')
            ->with('farm')
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.name', 'distributions.*')
            ->orderBy('clients.name', 'ASC')
            /*->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')*/
            ->get();
        
        //$colors = Color::where('type', '=', 'client')->get();
        $colors = Color::where('type', '=', 'client')->where('load_type', 'aereo')->get();
        //dd($colors);

        $distributionPdf = PDF::loadView('distribution.distributionPdf', compact(
            'flight', 'clientsDistribution', 'coordinations', 'colors'
        ))->setPaper('A4', 'landscape');
        //dd($farmsItemsLoad);
        return $distributionPdf->stream();
    }

    public function distributionUncoordinatedPdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        // Vuelo actual
        $flight = Flight::find($code);

        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsDistr = Distribution::where('id_flight', '=', $code)
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsDistr->toArray(), SORT_REGULAR));
        // Coordinaciones
        $coordinations = Distribution::select('*')
            ->where('id_flight', '=', $code)
            ->with('variety')
            ->with('farm')
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.name', 'distributions.*')
            ->orderBy('clients.name', 'ASC')
            /*->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')*/
            ->get();
        //dd($coordinations);
        //$colors = Color::where('type', '=', 'client')->get();
        $colors = Color::where('type', '=', 'client')->where('load_type', 'aereo')->get();

        $distributionPdf = PDF::loadView('distribution.distributionUncoordinatedPdf', compact(
            'flight', 'clientsDistribution', 'coordinations', 'colors'
        ))->setPaper('A4', 'landscape');
        //dd($farmsItemsLoad);
        return $distributionPdf->stream();
    }

    public function distributionForDeliveryPdf()
    {
         // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        // Vuelo actual
        $flight = Flight::find($code);

        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsDistr = Distribution::where('id_flight', '=', $code)
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsDistr->toArray(), SORT_REGULAR));
        // Coordinaciones
        $coordinations = Distribution::select('*')
            ->where('id_flight', '=', $code)
            ->with('variety')
            ->with('farm')
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.name', 'distributions.*')
            ->orderBy('clients.name', 'ASC')
            /*->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')*/
            ->get();
        //dd($coordinations);
        //$colors = Color::where('type', '=', 'client')->get();
        $colors = Color::where('type', '=', 'client')->where('load_type', 'aereo')->get();

        $distributionPdf = PDF::loadView('distribution.distributionForDelivery', compact(
            'flight', 'clientsDistribution', 'coordinations', 'colors'
        ))->setPaper('A4');
        //dd($farmsItemsLoad);
        return $distributionPdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddDistributionRequest $request)
    {
        // calculo de fulls
        $request['fulls'] = ($request['hb'] * 0.5) + ($request['qb'] * 0.25) + ($request['eb'] * 0.125);
        $request['fulls_r'] = ($request['hb_r'] * 0.5) + ($request['qb_r'] * 0.25) + ($request['eb_r'] * 0.125);
        // calculo de piezas
        $request['pieces'] = $request['hb'] + $request['qb'] + $request['eb'];
        $request['pieces_r'] = $request['hb_r'] + $request['qb_r'] + $request['eb_r'];
        // Faltantes 
        $request['missing'] = $request['pieces'] - $request['pieces_r'];
        // Duplicate AWB
        if($request['duplicate'] == 'on')
        {
            $request['duplicate'] = 'yes';
        }else{
            $request['duplicate'] = 'no';
        }
        // Guardamos laguia hija en caso de ser Vuelo propio
        $flight = Flight::find($request['id_flight']);
        $hawb_last = Hawb::select('hawb')->get()->last();
        if($flight->type_awb == 'own')
        {
            $new_hawb = (intval($hawb_last->hawb) + 1);
            $hawb_zero = str_pad($new_hawb, 8, "0", STR_PAD_LEFT);
            $uno = substr($hawb_zero, 0, 4);
            $dos = substr($hawb_zero, 4, 8);
            $hawb_format = 'FFC-' . $uno . '-' . $dos;
            $hawb = Hawb::create([
                'hawb'          => $new_hawb,
                'hawb_format'   => $hawb_format,
                'id_user'       => Auth::user()->id,
                'update_user'   => Auth::user()->id,
            ]);
            $request['id_hawb'] = $hawb->id;
            $request['hawb'] = $hawb_format;
        }
        //dd($request);
        $distrubution = Distribution::create($request->all());

        return redirect()->route('distribution.index', $distrubution->id_flight)
            ->with('status_success', 'Coordinación guardada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistributionRequest $request, $id)
    {
        //dd($request->all());
        $distribution = Distribution::find($id);
        // calculo de fulls
        $request['fulls'] = ($request['hb'] * 0.5) + ($request['qb'] * 0.25) + ($request['eb'] * 0.125);
        $request['fulls_r'] = ($request['hb_r'] * 0.5) + ($request['qb_r'] * 0.25) + ($request['eb_r'] * 0.125);
        // calculo de piezas
        $request['pieces'] = $request['hb'] + $request['qb'] + $request['eb'];
        $request['pieces_r'] = $request['hb_r'] + $request['qb_r'] + $request['eb_r'];
        // Faltantes 
        $request['missing'] = $request['pieces'] - $request['pieces_r'];
        // Duplicate AWB
        if($request['duplicate'] == 'on')
        {
            $request['duplicate'] = 'yes';
        }else{
            $request['duplicate'] = 'no';
        }

        $flight = Flight::find($request['id_flight']);
        $hawb_last = Hawb::find($request['id_hawb']);
        if($flight->type_awb == 'own'){
            $request['hawb'] = $hawb_last->hawb_format;
        }

        $distribution->update($request->all());
        $flight = Flight::where('id', '=', $distribution->id_flight)->first();

        return redirect()->route('distribution.index', $flight->id)
            ->with('status_success', 'Item de coordinación editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $distribution = Distribution::find($id);
        $distribution->delete();
        $flight = Flight::where('id', '=', $distribution->id_flight)->first();

        return redirect()->route('distribution.index', $flight->id)
            ->with('status_success', 'Coordinación eliminada con éxito');
    }
}
