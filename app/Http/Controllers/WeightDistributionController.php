<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flight;
use App\Distribution;
use App\Client;
use App\Farm;
use App\Variety;
use App\Marketer;
use App\Packing;
use App\WeightDistribution;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Company;
use App\Http\Requests\weightDistributionRequest;


class WeightDistributionController extends Controller
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
        // Coordinaciones
        $distributions = Distribution::select('*')
            ->where('id_flight', '=', $code)
            ->with('variety')
            ->with('marketer')
            ->with('weight')
            //->join('weight_distributions', 'weight_distributions.id_distribution', '=', 'distributions.id')
            ->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        //dd($distributions);
        $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $clientsList = Client::select('id', 'name')->orderBy('name', 'ASC')->get();
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
        // Variedades
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');
        // Comercializadores
        $marketers = Marketer::orderBy('name', 'ASC')->pluck('name', 'id');
        // Pakings
        $packings = Packing::orderBy('description', 'ASC')->pluck('description', 'id');
        // weight Distribution
        $weightDistribution = WeightDistribution::where('id_flight', '=', $flight->id)->with('packing')->get();
        foreach($distributions as $dist)
        {
            //dd($dist->weight[0]['report_w']);
        }
        $dis = $distributions->toArray();
        //dd($dis[0]['weight'][0]['large']);
        //dd($dis);
        return view('weightdistribution.index', compact('flight', 'distributions', 'clients', 'clientsDistribution', 'farms', 'varieties', 'marketers', 'packings', 'weightDistribution', 'farmsList', 'clientsList'));
    }

    public function weightDistributionExcel($codeDist)
    {
        $flight = Flight::find($codeDist);

        $company = Company::get();

        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsDistr = Distribution::where('id_flight', '=', $codeDist)
            ->join('clients', 'distributions.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsDistribution = collect(array_unique($clientsDistr->toArray(), SORT_REGULAR));
        // Coordinaciones
        $distributions = Distribution::select('*')
            ->where('id_flight', '=', $codeDist)
            ->with('variety')
            ->with('marketer')
            ->with('weight')
            //->join('weight_distributions', 'weight_distributions.id_distribution', '=', 'distributions.id')
            ->join('farms', 'distributions.id_farm', '=', 'farms.id')
            ->select('farms.name', 'distributions.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        $distri = $distributions->toArray();
        // weight Distribution
        $weightDistribution = WeightDistribution::where('id_flight', '=', $flight->id)->with('packing')->get();
        //dd($weightDistribution);

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

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(22);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(65);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(55);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(50);

        $letra = 'A';
        for($letra; $letra <= 'P'; $letra++)
        {
            $spreadsheet->getActiveSheet()->getStyle($letra . '1:' . $letra . '150')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');
        }

        // Titulo
        $sheet->getStyle('G2')->getFont()->setSize(24);
        $sheet->getStyle('G2')->getFont()->setBold(true);
        $sheet->setCellValue('G2', 'FRESH FLOWER CARGO, S.A.');
        $sheet->setCellValue('G3', 'Av. Naciones Unidas E10-44 E10 R del Salvador Piso 8 Ofc. 804 - Iñaquito');
        $sheet->setCellValue('G4', 'Teléfono:  +593 02 297-0637');
        $sheet->setCellValue('G5', 'coordinacion1@freshflowercargo.com');
        $sheet->setCellValue('G6', 'Quito - Ecuador');


        // TITULO CABECERA
        $sheet->getStyle('A9:L9')->getFont()->setBold(true);
        $sheet->mergeCells('A9:L9');
        $sheet->getStyle('A9:L9')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A9:L9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A9:L9')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A9:L9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('0070C0');
        $spreadsheet->getActiveSheet()->getStyle('A9:L9')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A9:L9')->getFont()->setSize(20);
        $sheet->setCellValue('A9', 'PROYECCIÓN DE PESO ' . $flight->awb);
        // Cabecera
        $sheet->getStyle('A10:L10')->getFont()->setBold(true);
        $sheet->getStyle('A10:L10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A10:L10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A10:L10')->applyFromArray($styleArray);
        $sheet->setCellValue('A10', 'HAWB');
        $sheet->setCellValue('B10', 'REPORTED WEIGHT');
        $sheet->setCellValue('C10', 'PROMEDIO');
        $sheet->setCellValue('D10', 'LARGO');
        $sheet->setCellValue('E10', 'ANCHO');
        $sheet->setCellValue('F10', 'ALTO');
        $sheet->setCellValue('G10', 'RESUMEN DE CLIENTES');
        $sheet->setCellValue('H10', 'HB');
        $sheet->setCellValue('I10', 'QB');
        $sheet->setCellValue('J10', 'EB');
        $sheet->setCellValue('K10', 'FBX');
        $sheet->setCellValue('L10', 'OBSERVACIONES');

        // CLIENTES
        $i = 11;
        foreach($clientsDistribution as $client)
        {
            $arrSubTotal = array();
            $fila = $i + 1;
            $sheet->getStyle('A' . $i . ':L' . $i)->getFont()->setBold(true);
            $sheet->mergeCells('A' . $i . ':L' . $i);
            $sheet->getStyle('A' . $i . ':L' . $i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $i . ':L' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
            $sheet->getStyle('A' . $i . ':L' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $i . ':L' . $i)->getFont()->setSize(18);
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->getFont()->getColor()->setRGB('002060');
            $sheet->setCellValue('A' . $i, $client['name']);
            $j = $i + 1;
            foreach($distri as $key => $dist)
            {
                if($client['id'] == $dist['id_client'])
                {
                    //dd($dist['weight']['0']['large']);
                    $sheet->getStyle('A' . $j . ':L' . $j)->applyFromArray($styleArray);
                    $sheet->getStyle('A' . $j . ':L' . $j)->getFont()->setSize(12);
                    $sheet->getStyle('A' . $j . ':F' . $j)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('A' . $j . ':F' . $j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('H' . $j . ':L' . $j)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('H' . $j . ':L' . $j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValue('A' . $j, $dist['hawb']);
                    
                    
                    foreach($weightDistribution as $weight)
                    {
                        if($weight->id_distribution == $dist['id'])
                        {
                            $spreadsheet->getActiveSheet()->getStyle('B' . $j)->getNumberFormat()->setFormatCode('#,##0.00');
                            $spreadsheet->getActiveSheet()->getStyle('C' . $j)->getNumberFormat()->setFormatCode('#,##0.00');
                            $spreadsheet->getActiveSheet()->getStyle('D' . $j)->getNumberFormat()->setFormatCode('#,##0.00');
                            $spreadsheet->getActiveSheet()->getStyle('E' . $j)->getNumberFormat()->setFormatCode('#,##0.00');
                            $spreadsheet->getActiveSheet()->getStyle('F' . $j)->getNumberFormat()->setFormatCode('#,##0.00');

                            $sheet->setCellValue('B' . $j, $weight->report_w);
                            $sheet->setCellValue('C' . $j, $weight->average);
                            $sheet->setCellValue('D' . $j, $weight->large);
                            $sheet->setCellValue('E' . $j, $weight->width);
                            $sheet->setCellValue('F' . $j, $weight->high);
                        }
                    }
                    //$sheet->setCellValue('B' . $j, $dist[0]['weight'][0]['large']);
                    /*$sheet->setCellValue('C' . $j, $dist->weight[0]->average);
                    $sheet->setCellValue('D' . $j, $dist->weight[0]->large);
                    $sheet->setCellValue('E' . $j, $dist->weight[0]->width);
                    $sheet->setCellValue('F' . $j, $dist->weight[0]->high);*/   
                    $sheet->setCellValue('G' . $j, $dist['name']);
                    $sheet->setCellValue('H' . $j, $dist['hb_r']);
                    $sheet->setCellValue('I' . $j, $dist['qb_r']);
                    $sheet->setCellValue('J' . $j, $dist['eb_r']);
                    $spreadsheet->getActiveSheet()->getStyle('K' . $j)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->setCellValue('K' . $j, $dist['fulls_r']);
                    foreach($weightDistribution as $weight)
                    {
                        
                        if($weight->id_distribution == $dist['id'])
                        {
                            //dd($weight->packing->description);
                            $spreadsheet->getActiveSheet()->getStyle('L' . $j)->getFont()->getColor()->setRGB('FF0000');
                            $sheet->setCellValue('L' . $j, $weight->packing->description);
                        }
                    }
                    
                    //dd($dist);
                    $j++;
                }
            }
            //dd($fila);
            $i = $j;
            $spreadsheet->getActiveSheet()->getStyle('B' . $i . ':C' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $spreadsheet->getActiveSheet()->getStyle('H' . $i . ':K' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            
            $spreadsheet->getActiveSheet()->getStyle('B' . $i)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('C' . $i)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('K' . $i)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->getStyle('B' . $i . ':C' . $i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . $i . ':C' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $i . ':K' . $i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('H' . $i . ':K' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $i . ':L' . $i)->getFont()->setSize(12);
            $sheet->getStyle('B' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('C' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('H' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('I' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('J' . $i)->applyFromArray($styleArray);
            $sheet->getStyle('K' . $i)->applyFromArray($styleArray);
            $arrSubTotal[] = $i;

            $sheet->setCellValue('B' . $i, '=SUM(B' . $fila . ':B' . ($i-1) . ')');
            $sheet->setCellValue('C' . $i, '=SUM(C' . $fila . ':C' . ($i-1) . ')');
            $sheet->setCellValue('H' . $i, '=SUM(H' . $fila . ':H' . ($i-1) . ')');
            $sheet->setCellValue('I' . $i, '=SUM(I' . $fila . ':I' . ($i-1) . ')');
            $sheet->setCellValue('J' . $i, '=SUM(J' . $fila . ':J' . ($i-1) . ')');
            $sheet->setCellValue('K' . $i, '=SUM(K' . $fila . ':K' . ($i-1) . ')');
            $i++;
            $sheet->setCellValue('A' . $i, ''); // OJO PUEDE IR AL FINAL
            $i++;

            foreach($arrSubTotal as $t)
            {
                //print_r($t . '-');
                $arrSubTotal2[] = $t;
            }
            
        }
        // TOTALES
        $numCellTotal = $i + 1;
        $spreadsheet->getActiveSheet()->getRowDimension($numCellTotal)->setRowHeight(30);
        $sheet->getStyle('A' . $numCellTotal . ':B' . $numCellTotal)->getFont()->setBold(true);
        $sheet->getStyle('A' . $numCellTotal)->getFont()->setSize(20);
        $sheet->getStyle('H' . $numCellTotal . ':K' . $numCellTotal)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B' . $numCellTotal)->getFont()->getColor()->setRGB('FFFFFF');
        $spreadsheet->getActiveSheet()->getStyle('H' . $numCellTotal . ':K' . $numCellTotal)->getFont()->getColor()->setRGB('FFFFFF');
        $spreadsheet->getActiveSheet()->getStyle('B' . $numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('0070C0');
        $spreadsheet->getActiveSheet()->getStyle('H' . $numCellTotal . ':K' . $numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('0070C0');
        $spreadsheet->getActiveSheet()->getStyle('B' . $numCellTotal)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('K' . $numCellTotal)->getNumberFormat()->setFormatCode('#,##0.000');
        $sheet->getStyle('A' . $numCellTotal . ':B' . $numCellTotal)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $numCellTotal . ':B' . $numCellTotal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('H' . $numCellTotal . ':K' . $numCellTotal)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('H' . $numCellTotal . ':K' . $numCellTotal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . $numCellTotal . ':K' . $numCellTotal)->getFont()->setSize(14);
        $sheet->getStyle('B' . $numCellTotal)->applyFromArray($styleArray);
        $sheet->getStyle('H' . $numCellTotal . ':K' . $numCellTotal)->applyFromArray($styleArray);
        $sheet->setCellValue('A' . $numCellTotal, 'KG');

        
        $g = 'B';
        $cadena = '';
        foreach($arrSubTotal2 as $tot)
        {
            $cadena .= '+' . $g . $tot;
        }
        $sheet->setCellValue($g . $numCellTotal, '=' . $cadena);

        //$numCellTotal = $i + 1;
        $f = 'H';
        for($f; $f <= 'K'; $f++)
        {
            $cadena = '';
            //$cadena2 .= $f;
            foreach($arrSubTotal2 as $tot)
            {
                $cadena .= '+' . $f . $tot;
            }
            $sheet->setCellValue($f . $numCellTotal, '=' . $cadena);
        }

        $sheet->setCellValue('A' . ($numCellTotal + 4), 'ELABORADO POR');

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath('images/logo-ffc.png'); // put your path and image here
        $drawing->setCoordinates('A2');
        $drawing->setOffsetX(50);
        $drawing->setRotation(0);
        //$drawing->getShadow()->setVisible(true);
        //$drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());


        


        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PROYECCIÓN DE PESO ' . $flight->awb . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
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
    public function store(weightDistributionRequest $request)
    {
        $distribution = Distribution::find($request->id_distribution);
        $average = $request->report_w / $distribution->fulls;
        $request['average'] = $request->report_w / $distribution->fulls;

        //dd($request->all());
        $weightDistribution = WeightDistribution::create($request->all());

        return redirect()->route('weight-distribution.index', $distribution->id_flight)
            ->with('status_success', 'Peso agregada con éxito');
        //dd($average);
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
    public function update(weightDistributionRequest $request, $id)
    {
        $weightDistribution = WeightDistribution::find($id);

        $distribution = Distribution::find($request->id_distribution);
        $average = $request->report_w / $distribution->fulls;
        $request['average'] = $request->report_w / $distribution->fulls;

        $weightDistribution->update($request->all());

        return redirect()->route('weight-distribution.index', $distribution->id_flight)
            ->with('status_success', 'Peso editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weightDistribution = WeightDistribution::where('id_distribution', '=', $id)->first();
        $distribution = Distribution::find($weightDistribution->id_distribution);
        $weightDistribution->delete();
        

        return redirect()->route('weight-distribution.index', $distribution->id_flight)
            ->with('status_success', 'Peso eliminado con éxito');
    }
}
