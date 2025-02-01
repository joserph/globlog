<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PalletItem;
use App\Farm;
use App\Pallet;
use App\Load;
use App\SketchPercent;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Color;
use App\Client;
use App\LogisticCompany;
use App\Company;
use App\MasterInvoiceItem;
use App\Coordination;

class PalletItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //dd($request->all());
        if($request->piso == 'value')
        {
            $request->piso = 1;
        }else{
            $request->piso = 0;
        }
        $palletitem = PalletItem::create([
            'id_user' => $request->id_user,
            'update_user' => $request->update_user,
            'id_load' => $request->id_load,
            'id_pallet' => $request->id_pallet,
            'id_farm' => $request->id_farm,
            'id_client' => $request->id_client,
            'hb' => $request->hb,
            'qb' => $request->qb,
            'eb' => $request->eb,
            'quantity' => $request->quantity,
            'piso' => $request->piso
        ]);
        $farm = Farm::select('name')->where('id', '=', $palletitem->id_farm)->first();
        $palletitem->farms = $farm->name;
        $palletitem->save();

        $pallet = Pallet::where('id', '=', $palletitem->id_pallet)->get();
        $load = Load::where('id', '=', $pallet[0]->id_load)->get();

        // Total paleta
        // Actualizar total de la paleta
        PalletItem::updateTotalPallet($palletitem->id_pallet);

        return redirect()->route('pallets.index', $load[0]->id)
            ->with('info', 'Item Guardado con exito');
    }

    public function reportsClientExcel($codeLoad)
    {
        $resumenCarga = PalletItem::where('id_load', '=', $codeLoad)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clientsLoad = collect(array_unique($resumenCarga->toArray(), SORT_REGULAR));

        $load = Load::find($codeLoad);

        // Empresa de logistica
        $logistic = LogisticCompany::find($load->id_logistic_company);
        
        $company = Company::first();
        // dd($company);
        $palletItem = PalletItem::where('id_load', '=', $codeLoad)->with('client')->with('farm')->orderBy('farms', 'ASC')->get();
        $pallets = Pallet::where('id_load', '=', $codeLoad)->get();
        //dd($load);
        //$itemsFarms = PalletItem::groupEqualsItemsCargas($palletItem, $codeLoad);

        //$invoiceItems = MasterInvoiceItem::where('id_load', '=', $codeLoad)->with('farm')->first();
        $itemsFarms = MasterInvoiceItem::where('id_load', '=', $codeLoad)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->select('master_invoice_items.*', 'farms.name')
            ->orderBy('farms.name', 'ASC')
            ->get();

        // dd($palletItem);
        $spreadsheet = new Spreadsheet();
        $val = 0;
        
        foreach($clientsLoad as $client)
        {
            $pcs_t = 0;
            
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($val);
            $sheet = $spreadsheet->getActiveSheet();

            //Page margins
            $sheet->getPageMargins()->setTop(0.5);
            $sheet->getPageMargins()->setRight(0.75);
            $sheet->getPageMargins()->setLeft(0.75);
            $sheet->getPageMargins()->setBottom(1);

            //Use fit to page for the horizontal direction
            $sheet->getPageSetup()->setFitToWidth(1);
            $sheet->getPageSetup()->setFitToHeight(0);

            $sheet->setTitle(str_replace('/', '', $client['name']) );
            $styleArrayBorderThick = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            $styleArrayBorderThin = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            $styleArrayAllBorderMedium = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            $styleArrayBorderThin2 = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];

            // Formatos celdas
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(14);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(5);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(8);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(5);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(17);

            // Titulo
            $sheet->mergeCells('A1:J1');
            $sheet->getStyle('A1:J1')->applyFromArray($styleArrayBorderThick);
            $sheet->getStyle('A1')->getFont()->setSize(18);
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1:J1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A1', $client['name']);
            // Cabecera Shipper
            $spreadsheet->getActiveSheet()->getStyle('A2:J2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('A2:E2');
            $sheet->getStyle('A2:E2')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('A2', 'SHIPPER');
            $sheet->mergeCells('F2:J2');
            $sheet->getStyle('F2:J2')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('F2', 'BL N°');
            $sheet->getStyle('F2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            //Shipper
            //dd($logistic);
            $spreadsheet->getActiveSheet()->getStyle('A3:E6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            $sheet->getStyle('A3:E6')->applyFromArray($styleArrayBorderThick);
            $sheet->mergeCells('A3:E3');
            $sheet->setCellValue('A3', $logistic->name);
            $sheet->mergeCells('A4:E4');
            $sheet->setCellValue('A4', 'RUC: ' . $logistic->ruc);
            $sheet->mergeCells('A5:E5');
            $sheet->setCellValue('A5', 'DIRECCIÓN: ' . $logistic->address);
            $sheet->mergeCells('A6:E6');
            $sheet->setCellValue('A6', 'TELÉFONO: ' . $logistic->phone);
            // BL N°
            $sheet->mergeCells('F3:J4');
            $sheet->getStyle('F3:J6')->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('F3:J6')->applyFromArray($styleArrayBorderThick);
            $sheet->getStyle('F3:J6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F3:J6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F3')->getFont()->setSize(16);
            $sheet->setCellValue('F3', $load->bl);
            $spreadsheet->getActiveSheet()->getStyle('F5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('F5:I5');
            $sheet->setCellValue('F5', 'PIEZAS');
            
            $spreadsheet->getActiveSheet()->getStyle('F6:H6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('F6:I6');
            
            $sheet->setCellValue('F6', 'FULLES');
            
            // CABECERA CONSIGNE
            $spreadsheet->getActiveSheet()->getStyle('A7:I7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('A7:E7');
            $sheet->getStyle('A7:E7')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('A7', 'CONSIGNE');
            $sheet->mergeCells('F7:J7');
            $sheet->getStyle('F7:J7')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('F7', 'PLACE OF RECEPT BY PRE CARRIER');
            // CONSIGNE
            $sheet->mergeCells('A8:E8');
            $spreadsheet->getActiveSheet()->getStyle('A8:E11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            $sheet->getStyle('A8:E11')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('A8', $company->name);
            $sheet->mergeCells('A9:E9');
            $sheet->setCellValue('A9', 'DIRECCIÓN: ' . strtoupper($company->address));
            $sheet->mergeCells('A10:E10');
            $sheet->setCellValue('A10', strtoupper($company->city) . ' ' . strtoupper($company->state) . ' - ' . strtoupper($company->country));
            $sheet->mergeCells('A11:E11');
            $sheet->setCellValue('A11', 'TELÉFONO: ' . $company->phone);
            //PLACE OF RECEPT BY PRE CARRIER 
            $sheet->mergeCells('F8:J8');
            $sheet->getStyle('F8:J11')->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('F8:J11')->applyFromArray($styleArrayBorderThick);
            $sheet->getStyle('F8:J11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('F8', 'TABABELA');
            $spreadsheet->getActiveSheet()->getStyle('F9:J9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('F9:J9');
            $sheet->setCellValue('F9', 'EXPORT CARRIER');
            $sheet->mergeCells('F10:J11');
            $sheet->setCellValue('F10', $load->carrier);
            // CABECERA MARCACIÓN
            $spreadsheet->getActiveSheet()->getStyle('A12:I12')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('A12:E12');
            $sheet->getStyle('A12:E12')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('A12', 'MARCACIÓN');
            $sheet->mergeCells('F12:J12');
            $sheet->getStyle('F12:J12')->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('F12', 'PORT OF LOADING');
            // MARCACIÓN
            $spreadsheet->getActiveSheet()->getStyle('A13:E13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->mergeCells('A13:B13');
            $sheet->getStyle('A13:E13')->applyFromArray($styleArrayBorderThick);
            $sheet->getStyle('A13:E13')->getFont()->setSize(14);
            $sheet->getStyle('A13:E13')->getFont()->setBold(true);
            $sheet->setCellValue('A13', $client['name']);
            $sheet->mergeCells('C13:E13');
            $sheet->setCellValue('C13', 'RESUMEN DE ENTREGA');
            $sheet->mergeCells('F13:J13');
            $sheet->setCellValue('F13', 'GUAYAQUIL');
            $sheet->getStyle('F13:J17')->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('F13:J17')->applyFromArray($styleArrayBorderThick);
            // TIPOS DE PALETAS
            $spreadsheet->getActiveSheet()->getStyle('A14:E17')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            $spreadsheet->getActiveSheet()->getStyle('B14:E17')
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $sheet->getStyle('B14:E17')->getFont()->setBold(true);
            $sheet->getStyle('A14:A17')->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('A14:E17')->applyFromArray($styleArrayBorderThick);
            
            $sheet->setCellValue('A14', 'PALLETS NORMAL * 21 PCS');
            $sheet->setCellValue('A15', 'PALLETS NORMAL * 18 PCS');
            $sheet->setCellValue('A16', 'PALLETS MIXTAS *17 PCS');
            $sheet->setCellValue('A17', 'PALLETS GRANDES *15 PCS');
            // CANTIDAD DE PIEAZAS
            $sheet->mergeCells('B14:E14');
            $sheet->setCellValue('B14', '');
            $sheet->mergeCells('B15:E15');
            $sheet->setCellValue('B15', '');
            $sheet->mergeCells('B16:E16');
            $sheet->setCellValue('B16', '');
            $sheet->mergeCells('B17:E17');
            $sheet->setCellValue('B17', '');
            // FOREING PORT OF DISCHARGE 	
            $spreadsheet->getActiveSheet()->getStyle('F14:J14')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');	
            $sheet->mergeCells('F14:J14');
            $sheet->setCellValue('F14', 'FOREING PORT OF DISCHARGE');
            $sheet->mergeCells('F15:J15');
            $sheet->setCellValue('F15', 'SAN DIEGO, CA - UNITED STATES');
            $spreadsheet->getActiveSheet()->getStyle('F16:J16')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');	
            $sheet->mergeCells('F16:J16');
            $sheet->setCellValue('F16', 'FOR TRANSSHIPMENT TO DESTINO');
            $sheet->mergeCells('F17:J17');
            $sheet->setCellValue('F17', strtoupper($company->city) . ', ' . strtoupper($company->state) . ' - UNITED STATES');
            // CABECERA DESCRIPCION
            $sheet->mergeCells('A18:J18');
            $sheet->getStyle('A18:J18')->applyFromArray($styleArrayBorderThick);
            $sheet->getStyle('A18')->getFont()->setSize(14);
            $sheet->getStyle('A18')->getFont()->setBold(true);
            $sheet->getStyle('A18:J18')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A18:J18')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A18', 'DESCRIPCIÓN DE LAS CAJAS ENVIADAS');
            // CABECERA DETALLE FINCA
            $sheet->getStyle('A19:J19')->applyFromArray($styleArrayAllBorderMedium);
            $spreadsheet->getActiveSheet()->getStyle('A19:J19')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->getStyle('A19:J19')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A19:J19')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A19:J19')->getFont()->setBold(true);
            $sheet->mergeCells('A19:B19');
            $sheet->setCellValue('A19', 'FINCA');
            $sheet->setCellValue('C19', 'HAWB');
            $sheet->setCellValue('D19', 'DETALLE');
            $sheet->setCellValue('E19', 'PCS');
            $sheet->setCellValue('F19', 'FBX');
            $sheet->setCellValue('G19', 'HB');
            $sheet->setCellValue('H19', 'QB');
            $sheet->setCellValue('I19', 'EB');
            $sheet->setCellValue('J19', 'TEMPERATURA');
            // LOOP DE FINCAS
            $fila = 20;
            //dd($itemsFarms);
            foreach($itemsFarms as $item)
            {
                //dd($item->hawb);
                if($client['id'] == $item->id_client)
                {
                    $sheet->mergeCells('A' . $fila . ':B' . $fila);
                    $sheet->setCellValue('A' . $fila, $item->name);
                    $sheet->setCellValue('C' . $fila, $item->hawb);
                    $sheet->getStyle('C' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('C' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValue('D' . $fila, strtoupper($item->variety->name));
                    $sheet->setCellValue('E' . $fila, '=G' . $fila . '+H' . $fila . '+I' . $fila);
                    $sheet->getStyle('E' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('E' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValue('F' . $fila, '=(G' . $fila . '*0.5)+(H' . $fila . '*0.25)+(I' . $fila . '*0.125)');
                    $spreadsheet->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->setCellValue('G' . $fila, $item->hb);
                    $sheet->setCellValue('H' . $fila, $item->qb);
                    $sheet->setCellValue('I' . $fila, $item->eb);
                    $sheet->setCellValue('J' . $fila, '1.0°C');
                    $fila++;
                }
            }
            $sheet->getStyle('A20:J' . $fila)->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('A20:J' . $fila)->applyFromArray($styleArrayBorderThick);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayAllBorderMedium);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('A' . $fila . ':D' . $fila);
            $sheet->setCellValue('A' . $fila, '');
            $spreadsheet->getActiveSheet()->getStyle('E' . $fila . ':I' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->setCellValue('E' . $fila, '=SUM(E20:E' . ($fila - 1) . ')');
            $sheet->setCellValue('F' . $fila, '=SUM(F20:F' . ($fila - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->setCellValue('G' . $fila, '=SUM(G20:G' . ($fila - 1) . ')');
            $sheet->setCellValue('H' . $fila, '=SUM(H20:H' . ($fila - 1) . ')');
            $sheet->setCellValue('I' . $fila, '=SUM(I20:I' . ($fila - 1) . ')');
            $sheet->setCellValue('J' . $fila, '');
            $sheet->setCellValue('J5', '=+E' . $fila);/*** COLOCAR VALOR CALCULADO PIEZAS  ***/ 
            $sheet->setCellValue('J6', '=+F' . $fila); /*** COLOCAR VALOR CALCULADO FULLES  ***/ 
            $spreadsheet->getActiveSheet()->getStyle('J6')->getNumberFormat()->setFormatCode('#,##0.000');
            // CABECERA OBSERVACIONES
            $fila++;
            $sheet->mergeCells('A' . $fila . ':J' . $fila);
            $spreadsheet->getActiveSheet()->getStyle('A' . $fila . ':I' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayBorderThick);
            $sheet->setCellValue('A' . $fila, 'OBSERVACIONES');
            // DETALLES DE DESPACHO
            $fila++;
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->mergeCells('A' . $fila . ':C' . $fila);
            $sheet->setCellValue('A' . $fila, 'DETALLES DE DESPACHO POR PALETS:');
            $sheet->setCellValue('D' . $fila, 'PCS');
            $pcs_t = $fila;
            $sheet->setCellValue('E' . $fila, 'HB');
            $sheet->setCellValue('F' . $fila, 'QB');
            $sheet->setCellValue('G' . $fila, 'EB');
            $sheet->mergeCells('H' . $fila . ':J' . $fila);
            $sheet->setCellValue('H' . $fila, 'OBSERVACIONES');
            // LOOP DE PALETAS
            $fila++;
            //dd($pallets);
            
            foreach($pallets as $pallet)
            {
                //$pallet_counter = $pallet->counter;
                $acumu = 0;
                $acum_hb = 0;
                $acum_qb = 0;
                $acum_eb = 0;
                foreach($palletItem as $itemP)
                {
                    if($itemP->id_client == $client['id'])
                    {
                        if($itemP->id_pallet == $pallet->id)
                        {
                            $acumu += $itemP->quantity;
                            $acum_hb += $itemP->hb;
                            $acum_qb += $itemP->qb;
                            $acum_eb += $itemP->eb;
                        }
                    }
                }
                if($acumu != 0)
                {
                    //$sheet->mergeCells('A' . $fila . ':B' . $fila);
                    $sheet->getStyle('A' . ($fila) . ':B' . ($fila))->applyFromArray($styleArrayBorderThin2);
                    if(strpos($pallet->number, 'USDA'))
                    {
                        $sheet->setCellValue('C' . $fila, 'U.S.D.A.');
                    }else{
                        $sheet->setCellValue('C' . $fila, 'PALLET #' . $pallet->counter);
                    }
                    
                    $sheet->setCellValue('D' . $fila, '=SUM(E' . $fila . ':G' . $fila . ')');
                    $sheet->setCellValue('E' . $fila, $acum_hb);
                    $sheet->setCellValue('F' . $fila, $acum_qb);
                    $sheet->setCellValue('G' . $fila, $acum_eb);
                    $sheet->mergeCells('H' . $fila . ':J' . $fila);
                    if($acum_hb > 18)
                    {
                        $sheet->setCellValue('H' . $fila, 'PALLETS NORMAL * 21 PCS');
                    }else{
                        $sheet->setCellValue('H' . $fila, 'PALLETS NORMAL * 18 PCS');
                    }
                    
                    $fila++;
                }
            }
            //$sheet->getStyle('A' . ($pcs_t + 1) . ':B' . ($fila - 1))->applyFromArray($styleArrayBorderThin2);
            $spreadsheet->getActiveSheet()->getStyle('A' . ($pcs_t + 1) . ':B' . ($fila - 1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            $sheet->getStyle('C' . ($pcs_t + 1) . ':J' . ($fila - 1))->applyFromArray($styleArrayBorderThin);
            
            $sheet->getStyle('D' . ($pcs_t + 1) . ':J' . ($fila - 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('D' . ($pcs_t + 1) . ':J' . ($fila - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B' . ($pcs_t + 1) . ':B' . ($fila - 1))
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $sheet->getStyle('B' . ($pcs_t + 1) . ':B' . ($fila - 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B' . ($pcs_t + 1) . ':B' . ($fila - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('B' . ($pcs_t + 1) . ':B' . ($fila - 1))->getFont()->setBold(true);
            // TOTALES
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayBorderThin);
            $sheet->mergeCells('A' . $fila . ':C' . $fila);
            $sheet->setCellValue('A' . $fila, 'TOTAL PIEZAS');
            $sheet->getStyle('A' . ($pcs_t) . ':J' . ($fila + 1))->applyFromArray($styleArrayBorderThick);
            $spreadsheet->getActiveSheet()->getStyle('D' . $fila . ':G' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->setCellValue('D' . $fila, '=SUM(D' . ($pcs_t + 1) . ':D' . ($fila - 1) . ')');
            $sheet->setCellValue('E' . $fila, '=SUM(E' . ($pcs_t + 1) . ':E' . ($fila - 1) . ')');
            $sheet->setCellValue('F' . $fila, '=SUM(F' . ($pcs_t + 1) . ':F' . ($fila - 1) . ')');
            $sheet->setCellValue('G' . $fila, '=SUM(G' . ($pcs_t + 1) . ':G' . ($fila - 1) . ')');
            $sheet->mergeCells('H' . $fila . ':J' . $fila);
            $fila++;
            // ESPACIO PIE
            $sheet->mergeCells('A' . $fila . ':J' . $fila);
            $spreadsheet->getActiveSheet()->getStyle('A' . $fila . ':J' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayAllBorderMedium);
            $fila++;
            // PIE SALIDA Y DEVOLUCIONES
            $aux_fila = $fila;
            $spreadsheet->getActiveSheet()->getStyle('A' . $fila . ':J' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->setCellValue('A' . $fila, 'SALIDA UIO');
            $sheet->setCellValue('B' . $fila, $load->date);
            $sheet->mergeCells('D' . $fila . ':J' . $fila);
            $spreadsheet->getActiveSheet()->getStyle('D' . $fila . ':J' . $fila)
                ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            $sheet->getStyle('D' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->setCellValue('D' . $fila, 'DEVOLUCIONES');
            $fila++;
            $spreadsheet->getActiveSheet()->getStyle('A' . $fila . ':J' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->setCellValue('A' . $fila, 'LLEGADA LAX');
            $sheet->setCellValue('B' . $fila, $load->arrival_date);
            $sheet->mergeCells('D' . $fila . ':J' . $fila);
            $sheet->getStyle('D' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->setCellValue('D' . $fila, 'NO HAY DEVOLUCIONES');
            $fila++;
            $spreadsheet->getActiveSheet()->getStyle('A' . $fila . ':J' . $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CFCDCD');
            $sheet->getStyle('A' . $aux_fila . ':J' . $fila)->applyFromArray($styleArrayBorderThick);

            $fila++;
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->setCellValue('A' . $fila, 'REALIZADO POR:');
            // SALTO DE PAGINA
            $spreadsheet->getActiveSheet()->setBreak('J' . $fila, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW); /* new */
            // RESPALDO FOTOGRAFICO
            $fila++;
            $sheet->mergeCells('A' . $fila . ':J' . $fila);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayAllBorderMedium);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setSize(16);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A' . $fila, 'RESPALDO FOTOGRÁFICO');
            // USDA
            $fila++;
            $sheet->getStyle('A' . $fila . ':J' . $fila)->applyFromArray($styleArrayAllBorderMedium);
            $sheet->mergeCells('A' . $fila . ':B' . $fila);
            $sheet->getStyle('A' . $fila . ':B' . $fila)->getFont()->setSize(14);
            $sheet->getStyle('A' . $fila . ':B' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('A' . $fila . ':B' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $fila . ':B' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A' . $fila, 'U.S.D.A.');
            $sheet->getStyle('A' . $fila . ':B' . ($fila + 25))->applyFromArray($styleArrayBorderThick);
            $spreadsheet->getActiveSheet()->getStyle('A' . $fila . ':B' . ($fila + 25))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            // REGISTRO DE TEMPERATURA 1,0ºC
            $sheet->mergeCells('C' . $fila . ':F' . $fila);
            $sheet->getStyle('C' . $fila . ':F' . $fila)->getFont()->setSize(14);
            $sheet->getStyle('C' . $fila . ':F' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('C' . $fila . ':F' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('C' . $fila . ':F' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('C' . $fila, 'REGISTRO DE TEMPERATURA');
            $sheet->getStyle('C' . $fila . ':F' . ($fila + 11))->applyFromArray($styleArrayBorderThick);
            $spreadsheet->getActiveSheet()->getStyle('C' . $fila . ':F' . ($fila + 11))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            // FILTRO DE ETILENO 
            $sheet->mergeCells('G' . $fila . ':J' . $fila);
            $sheet->getStyle('G' . $fila . ':J' . $fila)->getFont()->setSize(14);
            $sheet->getStyle('G' . $fila . ':J' . $fila)->getFont()->setBold(true);
            $sheet->getStyle('G' . $fila . ':J' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G' . $fila . ':J' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('G' . $fila, 'FILTRO DE ETILENO');
            $sheet->getStyle('G' . $fila . ':J' . ($fila + 11))->applyFromArray($styleArrayBorderThick);
            $spreadsheet->getActiveSheet()->getStyle('G' . $fila . ':J' . ($fila + 11))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');
            // SALTO DE PAGINA
            $sheet->getStyle('A' . $fila . ':J' . ($fila + 55))->applyFromArray($styleArrayBorderThick);
            $spreadsheet->getActiveSheet()->setBreak('J' . ($fila + 55), \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW); /* new */

            $val++;
        }
        //dd($itemsFarms);
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="INFORMES CLIENTES ' . $load->bl . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        
        //dd($clientsLoad);
    }

    public function palletitemsExcel($codeLoad)
    {
        
        $load = Load::find($codeLoad);
        // CLIENTES
        $resumenCarga = PalletItem::where('id_load', '=', $codeLoad)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        $colors = Color::where('type', '=', 'client')->where('load_type', 'maritimo')->get();
        // Eliminamos los clientes duplicados
        $clientsLoad = collect(array_unique($resumenCarga->toArray(), SORT_REGULAR));
        // PALLETS
        $pallets = Pallet::where('id_load', '=', $codeLoad)->orderBy('id', 'ASC')->get();
        //$palletItem = PalletItem::where('id_load', '=', $codeLoad)->with('client')->with('farm')->orderBy('farms', 'ASC')->get();
        $palletItem = PalletItem::where('id_load', '=', $load->id)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('pallet_items.*', 'clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->orderBy('pallet_items.farms', 'ASC')
            ->get();
        // Items de carga
        /*$itemsCargaAll = PalletItem::select('*')
            ->where('id_load', '=', $codeLoad)
            ->join('farms', 'pallet_items.id_farm', '=', 'farms.id')
            ->select('farms.name', 'pallet_items.*')
            ->orderBy('farms.name', 'ASC')
            ->get();*/

        $itemsFarms = PalletItem::groupEqualsItemsCargas($palletItem, $codeLoad);
        //dd($colors);
        // Farms
        //$farms = Farm::all();
        // Clients
        //$clients = Client::all();

        //dd($palletItem);
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
        $style = [
            'alignment' => array(
                'wrapText' => TRUE,
                'textRotation' => '90',
                'readorder' => \PhpOffice\PhpSpreadsheet\Style\Alignment::READORDER_RTL,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
        ];

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(26);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(21);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(21);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(7);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(24);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(45);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(5);

        //$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(200);
        //MARCACIONES
        $sheet->getStyle('A2:B2')->getFont()->setBold(true);
        $sheet->mergeCells('A2:B2');
        $sheet->getStyle('A2:B2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:B2')->getFont()->setSize(11);
        $sheet->getStyle('A2:B2')->applyFromArray($styleArray);
        $sheet->setCellValue('A2', 'MARCACIONES');
        
        // LOOP
        $fila = 3;
        foreach($clientsLoad as $client)
        {
            //$sheet->setCellValue('A' . $fila, $client['name']);
            $sheet->setCellValue('A' . $fila, str_replace('SAG-', '', $client['name']));
            foreach($colors as $color)
            {
                if($color->id_type == $client['id'])
                {
                    
                    $colorFila = str_replace('#', '', $color->color);
                    $spreadsheet->getActiveSheet()->getStyle('B'. $fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($colorFila);
                    $sheet->getStyle('A' . $fila . ':B' . $fila)->applyFromArray($styleArray);
                }
            }

            $fila++;
           
        }
        $blCell = $fila;
        $sheet->mergeCells('A' . $blCell . ':B' . ($blCell+20));
        //$sheet->getStyle('A' . $blCell)->getAlignment()->setTextRotation(0);
        /*$sheet->getStyle('A' . $blCell . ':B' . ($blCell+20))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $blCell . ':B' . ($blCell+20))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);*/
        $sheet->getStyle('A' . $blCell . ':B' . ($blCell+20))->applyFromArray($style);
        $sheet->getStyle('A' . $blCell . ':B' . ($blCell+20))->getFont()->setSize(28);
        $sheet->setCellValue('A' . $blCell, $load->bl);
        
        // PLANO
        $sheet->getStyle('D2:G69')->getFont()->setBold(true);
        $sheet->getStyle('D4:G69')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('E4:E69')
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $spreadsheet->getActiveSheet()->getStyle('G4:G69')
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->mergeCells('D2:E2');
        $sheet->getStyle('D2:G69')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D2:G69')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:G69')->applyFromArray($styleArray);
        $sheet->setCellValue('D2', 'LADO CHOFER');

        //$sheet->getStyle('F2:G2')->getFont()->setBold(true);
        $sheet->mergeCells('F2:G2');
        /*$sheet->getStyle('F2:G2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F2:G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2:G2')->applyFromArray($styleArray);*/
        $sheet->setCellValue('F2', 'LADO CO-PILOTO');

        $sheet->setCellValue('D3', 'PALETA');
        $sheet->setCellValue('E3', 'CLIENTE');
        $sheet->setCellValue('F3', 'PALETA');
        $sheet->setCellValue('G3', 'CLIENTE');

        $i = 'D';
        for($i; $i <= 'G'; $i++)
        {
            
            for($f = 4; $f <= 69; $f+=6)
            {
                //dd('F= ' . $f . 'Letra =' . $i);
                $sheet->mergeCells($i . $f . ':' . $i . ($f + 5));
            }
            //$sheet->setCellValue($i . $numCellTotal, '=' . $cadena);
        }

        // PALLETS
        $sheet->mergeCells('I1:N1');
        $sheet->getStyle('I1:N3')->getFont()->setBold(true);
        $sheet->getStyle('I1:N3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('I1:N3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I1:N3')->applyFromArray($styleArray);

        $sheet->getStyle('I1:N1')->getFont()->setSize(20);
        $spreadsheet->getActiveSheet()->getStyle('I1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('C6E0B4');
        $sheet->setCellValue('I1', $load->bl);

        $sheet->mergeCells('I2:N2');
        $sheet->setCellValue('I2', 'PIEZAS EMBARCADAS');
        $sheet->setCellValue('I3', 'PALETA');
        $sheet->setCellValue('J3', 'FINCA');
        $sheet->setCellValue('K3', 'CLIENTE');
        $sheet->setCellValue('L3', 'HB');
        $sheet->setCellValue('M3', 'QB');
        $sheet->setCellValue('N3', 'EB');
        // LOOP PALETAS Y FINCAS
        /*$k = 'I';
        for($k; $k <= 'N'; $k++)
        {
            $j = 4;
            foreach($pallets as $pallet)
            {
                
                foreach($palletItem as $pItem)
                {
                    if($pallet->id == $pItem->id_pallet)
                    {
                        dd($k . $j);
                        $sheet->setCellValue($k . $j, $pallet->counter);
                        $sheet->setCellValue($k . $j, $pItem->farm->name);
                    }
                }
                
                $j++;
            }
            
        }*/
        $j = 4;
        $count = 0;
        //dd($pallets);
        foreach($pallets as $pallet)
        {
            foreach($palletItem as $pItem)
            {
                $k = 'I';
                if($pallet->id == $pItem->id_pallet)
                {
                    
                    for($k; $k <= 'N'; $k++)
                    {
                        //dd($pallet->counter);
                        if($count != $pallet->counter)
                        {
                            $sheet->getStyle($k . $j)->applyFromArray($styleArray);
                            $sheet->getStyle($k . $j)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                            $sheet->getStyle($k . $j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($k . $j)->getFont()->setBold(true);
                            if(strpos($pallet->number, 'USDA'))
                            {
                                $sheet->setCellValue($k . $j, 'USDA');
                                $spreadsheet->getActiveSheet()->getStyle($k . $j)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setRGB('FFFF00');
                            }else{
                                $sheet->setCellValue($k . $j, $pallet->counter);
                            }
                            
                            
                        }
                        $count = $pallet->counter;
                        $k++;
                        $sheet->getStyle($k . $j)->applyFromArray($styleArray);
                        $sheet->setCellValue($k . $j, $pItem->farm->name);
                        $k++;
                        $sheet->getStyle($k . $j)->applyFromArray($styleArray);
                        $sheet->setCellValue($k . $j, str_replace('SAG-', '', $pItem->client->name));
                        $k++;
                        $sheet->getStyle($k . $j)->applyFromArray($styleArray);
                        if($pItem->hb != 0)
                        {
                            $sheet->setCellValue($k . $j, $pItem->hb);
                        }
                        
                        $k++;
                        $sheet->getStyle($k . $j)->applyFromArray($styleArray);
                        if($pItem->qb != 0)
                        {
                            $sheet->setCellValue($k . $j, $pItem->qb);
                        }
                        
                        $k++;
                        $sheet->getStyle($k . $j)->applyFromArray($styleArray);
                        if($pItem->eb != 0)
                        {
                            $sheet->setCellValue($k . $j, $pItem->eb);
                        }
                        
                    }
                    $j++;
                }
                //$sheet->setCellValue($k . $j, '--');
            }
            $space = $j;
            //
            /*$spreadsheet->getActiveSheet()->getStyle('B'. $space .':P' .$space)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFFFF');*/
            $sheet->setCellValue('I' . $space, '');
            $j = $space + 1;
            
        }

        // TOTAL LOOP PALETAS
        $sheet->getStyle('J' . $j . ':N' . $j)->applyFromArray($styleArray);
        $sheet->getStyle('J' . $j . ':N' . $j)->getFont()->setBold(true);
        $sheet->getStyle('J' . $j . ':N' . $j)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('J' . $j . ':N' . $j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('J' . $j . ':K' . $j);
        $sheet->setCellValue('J' . $j, 'TOTAL');

        
        $sheet->setCellValue('L' . $j, '=SUM(L4:L' . ($j-1) . ')');
        $sheet->setCellValue('M' . $j, '=SUM(M4:M' . ($j-1) . ')');
        $sheet->setCellValue('N' . $j, '=SUM(N4:N' . ($j-1) . ')');
        $j++;
        $sheet->getStyle('L' . $j . ':N' . $j)->applyFromArray($styleArray);
        $sheet->getStyle('L' . $j . ':N' . $j)->getFont()->setBold(true);
        $sheet->getStyle('L' . $j . ':N' . $j)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L' . $j . ':N' . $j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('L' . ($j) . ':N' . ($j));
        $sheet->setCellValue('L' . $j, '=L' . ($j-1) . '+M' . ($j-1) . '+N' . ($j-1));

        
        // RESUMEN DE CLIENTES Y FINCAS
        $sheet->mergeCells('P2:S2');
        $sheet->getStyle('P2:S3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('P2:S3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('P2:S3')->applyFromArray($styleArray);
        $sheet->getStyle('P2:S3')->getFont()->setBold(true);
        $sheet->setCellValue('P2', 'TOTAL DE PIEZAS ENVIADAS');
        $sheet->setCellValue('P3', 'FINCA');
        $sheet->setCellValue('Q3', 'HB');
        $sheet->setCellValue('R3', 'QB');
        $sheet->setCellValue('S3', 'EB');

        $l = 4;
        //dd($itemsFarms);
        foreach($clientsLoad as $resumClient)
        {
            $sheet->mergeCells('P' . $l . ':S' . $l);
            $sheet->getStyle('P' . $l . ':S' . $l)->getFont()->setBold(true);
            $sheet->getStyle('P' . $l . ':S' . $l)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('P' . $l . ':S' . $l)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('P' . $l . ':S' . $l)->applyFromArray($styleArray);
            $sheet->setCellValue('P' . $l, str_replace('SAG-', '', $resumClient['name']));
            $ll = $l + 1;
            
            
            foreach($itemsFarms as $itemFarm)
            {
                if($itemFarm['id_client'] == $resumClient['id'])
                {
                    for($m = 'P'; $m <= 'S'; $m++)
                    {
                        //dd($itemFarm['farms']);
                        $sheet->getStyle($m . $ll)->applyFromArray($styleArray);
                        $sheet->setCellValue($m . $ll, $itemFarm['farms']);
                        $m++;
                        $sheet->getStyle($m . $ll)->applyFromArray($styleArray);
                        if($itemFarm['hb'] != 0)
                        {
                            $sheet->setCellValue($m . $ll, $itemFarm['hb']);
                        }
                        $m++;
                        $sheet->getStyle($m . $ll)->applyFromArray($styleArray);
                        if($itemFarm['qb'] != 0)
                        {
                            $sheet->setCellValue($m . $ll, $itemFarm['qb']);
                        }
                        $m++;
                        $sheet->getStyle($m . $ll)->applyFromArray($styleArray);
                        if($itemFarm['eb'] != 0)
                        {
                            $sheet->setCellValue($m . $ll, $itemFarm['eb']);
                        }
                        $m++;
                        
                    }
                    $ll++;
                }
            }
            $l = $ll;
        }

        // TOTAL HB, QB Y EB
        $sheet->getStyle('Q' . $l . ':S' . ($l+1))->applyFromArray($styleArray);
        $sheet->getStyle('Q' . $l . ':S' . ($l+1))->getFont()->setBold(true);
        $sheet->getStyle('Q' . $l . ':S' . ($l+1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('Q' . $l . ':S' . ($l+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('Q' . $l, '=SUM(Q5:Q' . ($l-1) . ')');
        $sheet->setCellValue('R' . $l, '=SUM(R5:R' . ($l-1) . ')');
        $sheet->setCellValue('S' . $l, '=SUM(S5:S' . ($l-1) . ')');
        $l++;
        $sheet->mergeCells('Q' . ($l) . ':S' . ($l));
        $sheet->setCellValue('Q' . $l, '=Q' . ($l-1) . '+R' . ($l-1) . '+S' . ($l-1));
        
        
        



        $writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PLANO DE CARGA ' . $load->bl . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }


    public function palletitemsPdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        $resumenCarga = PalletItem::where('id_load', '=', $code)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $resumenCargaAll = collect(array_unique($resumenCarga->toArray(), SORT_REGULAR));

        // Items de carga
        $itemsCargaAll = PalletItem::select('*')
            ->where('id_load', '=', $code)
            ->join('farms', 'pallet_items.id_farm', '=', 'farms.id')
            ->select('farms.name', 'pallet_items.*')
            ->orderBy('farms.name', 'ASC')
            ->get();

        $itemsCarga = PalletItem::groupEqualsItemsCargas($itemsCargaAll, $code);

        //dd($itemsCarga);

        $palletitemsPdf = PDF::loadView('palletitems.palletitemsPdf', compact(
            'itemsCarga',
            'load',
            'resumenCargaAll'
        ))->setPaper('A4');

        
        return $palletitemsPdf->stream();
    }

    public function palletExcel($code)
    {
        $load = Load::with('logistic_company')->find($code);

        $resumenCarga = PalletItem::where('id_load', '=', $code)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $resumenCargaAll = collect(array_unique($resumenCarga->toArray(), SORT_REGULAR));
        // Items de carga
        $itemsCargaAll = PalletItem::select('*')
            ->where('id_load', '=', $code)
            ->join('farms', 'pallet_items.id_farm', '=', 'farms.id')
            ->select('farms.name', 'farms.ruc', 'pallet_items.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        
        $itemsCarga = PalletItem::groupEqualsItemsCargas($itemsCargaAll, $code);

        PalletItem::excelP($load, $resumenCargaAll, $itemsCarga);
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
    public function update(Request $request, $id)
    {
        //dd($request);
        $palletItem = PalletItem::find($id);
        //dd($id);
        
        $palletItem->update($request->all());
        $farm = Farm::select('name')->where('id', '=', $palletItem->id_farm)->first();
        $palletItem->farms = $farm->name;
        $palletItem->save();

        $load = Load::where('id', '=', $palletItem->id_load)->get();

        // Actualizar total de la paleta
        PalletItem::updateTotalPallet($palletItem->id_pallet);

        return redirect()->route('pallets.index', $load[0]->id)
            ->with('info', 'Item Actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $palletItem = PalletItem::find($id);
        $palletItem->delete();

        $load = Load::where('id', '=', $palletItem->id_load)->get();

        // Actualizar total de la paleta
        PalletItem::updateTotalPallet($palletItem->id_pallet);

        return redirect()->route('pallets.index', $load[0]->id)
            ->with('info', 'Item eliminado con exito');
    }
}
