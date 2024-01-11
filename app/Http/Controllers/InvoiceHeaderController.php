<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\InvoiceHeader;
use App\LogisticCompany;
use App\Company;
use App\Http\Requests\InvoiceHeaderRequest;
use App\Http\Requests\UpdateInvoiceHeaderRequest;
use App\Farm;
use App\Client;
use App\Variety;
use Barryvdh\DomPDF\Facade as PDF;
use App\MasterInvoiceItem;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportsMasterInvoice;
use App\Coordination;
use App\PalletItem;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceHeaderController extends Controller
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
        $load = Load::with('logistic_company')->find($code);
        //dd($load);
        // Cabecera de la factura
        $invoiceheaders = InvoiceHeader::orderBy('id', 'DESC')->where('id_load', '=', $code)->with('user')->with('userupdate')->first();
        //
        // Empresas de Logistica "Activa"
        $lc_active = LogisticCompany::where('active', '=', 'yes')->first();
        // Verificamos si la factura tiene items
        $invoiceItems = MasterInvoiceItem::where('id_load', '=', $code)->first();
        //
        // Mi empresa
        $company = Company::first();

        // Buscamos las fincas coordinadas
        $farmCoord = Coordination::where('id_load', $code)->select('id_farm')->get()->toArray();
        //dd($farmCoord);
        // Buscamos los clientes coordinados
        $clientCoord = Coordination::where('id_load', $code)->select('id_client')->get()->toArray();

        if($invoiceheaders && $invoiceheaders->coordination == 'yes')
        {
            // Fincas
            $farms = Farm::whereIn('id', $farmCoord)->orderBy('name', 'ASC')->pluck('name', 'id');
            // Clientes
            $clients = Client::whereIn('id', $clientCoord)->orderBy('name', 'ASC')->pluck('name', 'id');
        }else{
            // Fincas
            $farms = Farm::orderBy('name', 'ASC')->pluck('name', 'id');
            // Clientes
            $clients = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        }
        
        // Variedades
        $varieties = Variety::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('masterinvoice.index', compact('load', 
            'invoiceheaders', 
            'lc_active', 
            'company',
            'farms',
            'clients',
            'varieties',
            'invoiceItems'));
    }

    public function farmsInvoicePdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        // Cabecera de la factura
        $invoiceheaders = InvoiceHeader::orderBy('id', 'DESC')->where('id_load', '=', $code)->first();

        // Mi empresa
        $company = Company::first();

        // Empresas de Logistica "Activa"
        $lc_active = LogisticCompany::where('active', '=', 'yes')->first();

        $invoiceItemsAll = MasterInvoiceItem::where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client_confirm')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->select('master_invoice_items.*', 'farms.name', 'farms.address', 'farms.phone', 'farms.city')
            ->orderBy('farms.name', 'ASC')
            ->get();

        $invoiceItems = InvoiceHeader::groupEqualsMasterInvoice($invoiceItemsAll, $code);
        //dd($invoiceItems);

        $farmsInvoicePdf = PDF::loadView('masterinvoice.farmsInvoicePdf', compact(
            'invoiceItems',
            'invoiceheaders',
            'company',
            'lc_active'
        ));

        return $farmsInvoicePdf->stream();
    }

    public function masterInvoicePdf()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        // Cabecera de la factura
        $invoiceheaders = InvoiceHeader::orderBy('id', 'DESC')->where('id_load', '=', $code)->first();

        // Empresas de Logistica "Activa"
        $lc_active = LogisticCompany::where('active', '=', 'yes')->first();

        // Mi empresa
        $company = Company::first();

        $invoiceItemsAll = MasterInvoiceItem::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->with('client_confirm')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        //dd($invoiceItemsAll);
        $invoiceItems = InvoiceHeader::groupEqualsMasterInvoice($invoiceItemsAll, $code);
        //dd($invoiceItems);
        $masterInvoicePdf = PDF::loadView('masterinvoice.masterInvoicePdf', compact(
            'load',
            'invoiceheaders',
            'lc_active',
            'company',
            'invoiceItems'
        ));

        return $masterInvoicePdf->stream();
    }
    
    public function masterInvoiceExcel($id)
    {
        // Empresas de Logistica "Activa"
        $lc_active = LogisticCompany::where('active', '=', 'yes')->first();
        // Mi empresa
        $company = Company::first();
        // Cabecera de la factura
        $invoiceheaders = InvoiceHeader::orderBy('id', 'DESC')->where('id_load', '=', $id)->first();
        $invoiceItemsAll = MasterInvoiceItem::select('*')
            ->where('id_load', '=', $id)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->with('client_confirm')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        //dd($invoiceItemsAll);
        $invoiceItems = InvoiceHeader::groupEqualsMasterInvoice($invoiceItemsAll, $id);
        //dd($invoiceItems);
        InvoiceHeader::excel_master($invoiceheaders, $lc_active, $company, $invoiceItems);
        
    }

    public function shiptmentConfirmationUseInternalExcel(){
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        // Total pieces
        $totalPieces = MasterInvoiceItem::where('id_load', '=', $code)->sum('pieces');
        // Mi empresa
        $company = Company::first();
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsInInvoice = MasterInvoiceItem::where('id_load', '=', $code)
            ->join('clients', 'master_invoice_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();

        // Eliminamos los clientes duplicados
        $clients = collect(array_unique($clientsInInvoice->toArray(), SORT_REGULAR));
        // Buscamos todos los items con id_load actual
        $invoiceItems = MasterInvoiceItem::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->orderBy('farms.name', 'ASC')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //Page margins
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.75);
        $sheet->getPageMargins()->setLeft(0.75);
        $sheet->getPageMargins()->setBottom(1);

        //Use fit to page for the horizontal direction
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        $styleArrayBorderThin = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(14);

        // CABECERA
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1:J1')->applyFromArray($styleArrayBorderThin);
        $sheet->getStyle('A1')->getFont()->setSize(18);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A1', 'CONFIRMACIÓN DE DESPACHO');

        $sheet->setCellValue('A2', 'Date:');
        $sheet->getStyle('A2:J2')->applyFromArray($styleArrayBorderThin);
        $sheet->getStyle('A2')->getFont()->setSize(11);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->mergeCells('B2:C2');
        $sheet->setCellValue('B2', date('l, d F - Y', strtotime($load->date)));
        $sheet->setCellValue('D2', 'Pcs:');
        $sheet->mergeCells('E2:J2');
        $sheet->setCellValue('E2', $totalPieces);

        $sheet->setCellValue('A3', 'Client:');
        $sheet->getStyle('A3:J3')->applyFromArray($styleArrayBorderThin);
        $sheet->getStyle('A3')->getFont()->setSize(11);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->mergeCells('B3:C3');
        $sheet->setCellValue('B3', $company->name);
        $sheet->setCellValue('D3', 'Carrier:');
        $sheet->mergeCells('E3:J3');
        $sheet->setCellValue('E3', 'MARITIMO');

        $sheet->setCellValue('A4', 'Awb:');
        $sheet->getStyle('A4:J4')->applyFromArray($styleArrayBorderThin);
        $sheet->getStyle('A4')->getFont()->setSize(11);
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->mergeCells('B4:J4');
        $sheet->setCellValue('B4', $load->bl);

        // CLIENTES Y FINCAS
        //@foreach($clients as  $key => $client)
        $count = 6;
        $totalFulls = 0; $totalHb = 0; $totalQb = 0; $totalEb = 0; $test = [];
        foreach($clients as $key => $client){
            $sheet->mergeCells('A' . $count . ':B' . $count);
            $sheet->getStyle('A' . $count . ':J' . $count)->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setSize(11);
            $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setBold(true);
            $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A' . $count, 'AWB');
            $sheet->mergeCells('C' . $count . ':J' . $count);
            $sheet->setCellValue('C' . $count, $client['name']);
            $count++;
            $sheet->mergeCells('A' . $count . ':B' . $count);
            $sheet->getStyle('A' . $count . ':J' . $count)->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setSize(11);
            $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setBold(true);
            $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A' . $count, 'Exporter');
            $sheet->mergeCells('C' . $count . ':D' . $count);
            $sheet->setCellValue('C' . $count, 'Variety');
            $sheet->setCellValue('E' . $count, 'HAWB');
            $sheet->setCellValue('F' . $count, 'PCS');
            $ini = $count;
            $sheet->setCellValue('G' . $count, 'BXS');
            $sheet->setCellValue('H' . $count, 'HALF');
            $sheet->setCellValue('I' . $count, 'QUART');
            $sheet->setCellValue('J' . $count, 'OCT');
            $count++;
            // FINCAS
            $tPieces = 0; $tFulls = 0; $tHb = 0; $tQb = 0; $tEb = 0;
            foreach($invoiceItems as $item){
                if($client['id'] == $item->id_client){
                    $tPieces+= $item->pieces;
                    $tFulls+= $item->fulls;
                    $tHb+= $item->hb;
                    $tQb+= $item->qb;
                    $tEb+= $item->eb;

                    $sheet->mergeCells('A' . $count . ':B' . $count);
                    $sheet->getStyle('A' . $count . ':J' . $count)->applyFromArray($styleArrayBorderThin);
                    $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setSize(11);
                    //$sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setBold(true);
                    $sheet->getStyle('C' . $count . ':J' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('C' . $count . ':J' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->setCellValue('A' . $count, $item->name);
                    $sheet->mergeCells('C' . $count . ':D' . $count);
                    $sheet->setCellValue('C' . $count, $item->variety->name);
                    $sheet->setCellValue('E' . $count, $item->hawb);
                    $sheet->setCellValue('F' . $count, '=SUM(H' . $count . ':J' . $count . ')');
                    $sheet->setCellValue('G' . $count, '=(H' . $count . '*0.5)+(I' . $count . '*0.25)+(J' . $count . '*0.125)');
                    $spreadsheet->getActiveSheet()->getStyle('G' . $count)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->setCellValue('H' . $count, $item->hb);
                    $sheet->setCellValue('I' . $count, $item->qb);
                    $sheet->setCellValue('J' . $count, $item->eb);
                    $count++;
                }
            }
            $totalFulls+= $tFulls;
            $totalHb+= $tHb;
            $totalQb+= $tQb;
            $totalEb+= $tEb;

            $sheet->mergeCells('A' . $count . ':E' . $count);
            $sheet->getStyle('A' . $count . ':J' . $count)->applyFromArray($styleArrayBorderThin);
            $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setSize(11);
            $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setBold(true);
            $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A' . $count, 'Total:');
            //$test = $test . '+F' .$count;
            $arrTotal[] = $count;
            $sheet->setCellValue('F' . $count, '=SUM(F' . ($ini + 1) . ':F' . ($count - 1) . ')');
            $sheet->setCellValue('G' . $count, '=SUM(G' . ($ini + 1) . ':G' . ($count - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('G' . $count)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->setCellValue('H' . $count, '=SUM(H' . ($ini + 1) . ':H' . ($count - 1) . ')');
            $sheet->setCellValue('I' . $count, '=SUM(I' . ($ini + 1) . ':I' . ($count - 1) . ')');
            $sheet->setCellValue('J' . $count, '=SUM(J' . ($ini + 1) . ':J' . ($count - 1) . ')');
            $count++;
            $sheet->mergeCells('A' . $count . ':J' . $count);
            $sheet->setCellValue('A' . $count,'');
            $count++;
        }
        //dd($arrTotal);
        // TOTAL
        $sheet->mergeCells('A' . $count . ':E' . $count);
        $sheet->getStyle('A' . $count . ':J' . $count)->applyFromArray($styleArrayBorderThin);
        $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setSize(11);
        $sheet->getStyle('A' . $count . ':J' . $count)->getFont()->setBold(true);
        $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $count . ':J' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('G' . $count)->getNumberFormat()->setFormatCode('#,##0.000');
        $sheet->setCellValue('A' . $count, 'Total Global:');
        // SUMAR TODOS LOS SUBTOTALES DESDE LA CELDA F HASTA LA J.
        $i = 'F';
        for($i; $i <= 'J'; $i++)
        {
            $cadena = '';
            //$cadena2 .= $i;
            foreach($arrTotal as $tot)
            {
                $cadena .= '+' . $i . $tot;
            }
            $sheet->setCellValue($i . $count, '=' . $cadena);
        }
        /*
        $sheet->setCellValue('F' . $count, '');
        $sheet->setCellValue('G' . $count, number_format($totalFulls, 3, '.',''));
        $sheet->setCellValue('H' . $count, $totalHb);
        $sheet->setCellValue('I' . $count, $totalQb);
        $sheet->setCellValue('J' . $count, $totalEb);*/

        $writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="CONFIRMACIÓN DE DESPACHO ' . $load->bl . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function shiptmentConfirmation()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::find($code);

        // Mi empresa
        $company = Company::first();
        
        // Buscamos todos los items con id_load actual
        $invoiceItemsAll = MasterInvoiceItem::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        
        // Buscamos los duplicados
        foreach($invoiceItemsAll as $item)
        {
            // Buscamos los valores duplicados
            $dupliHawb = MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->count('hawb');
            // Validamos si hay valores duplicados, para agrupar
            if($dupliHawb > 1)
            {
                $client_confim_id = ['client_confim_id' => $item->client_confim_id];
                $hb = ['hb' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('hb')];
                $qb = ['qb' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('qb')];
                $eb = ['eb' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('eb')];
                $fulls = ['fulls' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('fulls')];
                $pieces = ['pieces' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('pieces')];
                $name = ['name' => $item->name];
                $variety = ['variety' => $item->variety->name];
                $scientific = ['scientific_name' => $item->variety->scientific_name];
                $hawb = ['hawb' => $item->hawb];
                $stems = ['stems' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('stems')];
                $bunches = ['bunches' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('bunches')];
                $price = ['price' => $item->price];
                $total = ['total' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('total')];
            }else{
                $client_confim_id = ['client_confim_id' => $item->client_confim_id];
                $hb = ['hb' => $item->hb];
                $qb = ['qb' => $item->qb];
                $eb = ['eb' => $item->eb];
                $fulls = ['fulls' => $item->fulls];
                $pieces = ['pieces' => $item->pieces];
                $name = ['name' => $item->name];
                $variety = ['variety' => $item->variety->name];
                $scientific = ['scientific_name' => $item->variety->scientific_name];
                $hawb = ['hawb' => $item->hawb];
                $stems = ['stems' => $item->stems];
                $bunches = ['bunches' => $item->bunches];
                $price = ['price' => $item->price];
                $total = ['total' => $item->total];
            }
            
            $invoiceItemsArray[] = Arr::collapse([$client_confim_id, $hb, $qb, $eb, $fulls, $pieces, $name, $variety, $scientific, $hawb, $stems, $bunches, $price, $total]);
            
        }
        // Eliminamos los clientes duplicados
        $invoiceItems = collect(array_unique($invoiceItemsArray, SORT_REGULAR));

        
        // Buscamos los clientes (client_confim_id) que esten en esta carga, por el id_load
        $clientsInInvoice = MasterInvoiceItem::where('id_load', '=', $code)
            ->join('clients', 'master_invoice_items.client_confim_id', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();

        // Eliminamos los clientes duplicados
        $clients = collect(array_unique($clientsInInvoice->toArray(), SORT_REGULAR));

        // Total pieces
        $totalPieces = MasterInvoiceItem::where('id_load', '=', $code)->sum('pieces');
        //dd($invoiceItems);

        $shiptmentConfirmationPdf = PDF::loadView('masterinvoice.shiptmentConfirmationPdf', compact(
            'invoiceItems',
            'clients',
            'load',
            'company',
            'totalPieces'
        ));

        return $shiptmentConfirmationPdf->stream();
        
    }

    public function shiptmentConfirmationInternalUse()
    {
        // Busco el ID de la carga por medio de la URL
        $url = $_SERVER["REQUEST_URI"];
        $arr = explode("?", $url);
        $code = $arr[1];
        $load = Load::with('qacompany')->find($code);
        
        // Mi empresa
        $company = Company::first();

        // Buscamos todos los items con id_load actual
        $invoiceItems = MasterInvoiceItem::select('*')
            ->where('id_load', '=', $code)
            ->with('variety')
            ->with('invoiceh')
            ->with('client')
            ->join('farms', 'master_invoice_items.id_farm', '=', 'farms.id')
            ->orderBy('farms.name', 'ASC')
            ->get();
        $coordinationObserver = Coordination::where('id_load', $code)->with('marketer')->get();
        //dd($coordinationObserver);
        // Buscamos los clientes que esten en esta carga, por el id_load
        $clientsInInvoice = MasterInvoiceItem::where('id_load', '=', $code)
            ->join('clients', 'master_invoice_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();

        // Eliminamos los clientes duplicados
        $clients = collect(array_unique($clientsInInvoice->toArray(), SORT_REGULAR));

        // Total pieces
        $totalPieces = MasterInvoiceItem::where('id_load', '=', $code)->sum('pieces');
        //dd($invoiceItems);

        $shiptmentConfirmationPdf = PDF::loadView('masterinvoice.shiptmentConfirmationInternalUsePdf', compact(
            'invoiceItems',
            'clients',
            'load',
            'company',
            'totalPieces',
            'coordinationObserver'
        ));

        return $shiptmentConfirmationPdf->stream();
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
    public function store(InvoiceHeaderRequest $request)
    {
        $invoiceHeader = InvoiceHeader::create($request->all());
        //dd($invoiceHeader);
        $load = Load::where('id', '=', $invoiceHeader->id_load)->first();

        /* Create items of master Invoice */
        // array of Pallets
        //$code = 1;
        $resumenCarga = PalletItem::where('id_load', '=', $load->id)
            ->join('clients', 'pallet_items.id_client', '=', 'clients.id')
            ->select('clients.id', 'clients.name')
            ->orderBy('clients.name', 'ASC')
            ->get();
        // Eliminamos los clientes duplicados
        $clients = collect(array_unique($resumenCarga->toArray(), SORT_REGULAR));
        // Items de carga
        $itemsCargaAll = PalletItem::select('*')
            ->where('id_load', '=', $load->id)
            ->join('farms', 'pallet_items.id_farm', '=', 'farms.id')
            ->select('farms.name', 'pallet_items.*')
            ->orderBy('farms.name', 'ASC')
            ->get();
        
        $itemsFarms = PalletItem::groupEqualsItemsCargas($itemsCargaAll, $load->id);
        //dd($itemsFarms);
        foreach($clients as $client)
        {
            foreach($itemsFarms as $item)
            {
                if($client['id'] == $item['id_client'])
                {
                    $coordHawb = Coordination::where('id_load', $load->id)
                        ->where('id_client', $item['id_client'])
                        ->where('id_farm', $item['id_farm'])
                        ->first();
                    if(isset($coordHawb))
                    {
                        $coordHawb->hawb = $coordHawb->hawb;
                    }else{
                        $coordHawb->hawb = 0;
                    }
                    // calculo de Fulles
                    $fulls = ($item['hb'] * 0.5) + ($item['qb'] * 0.25) + ($item['eb'] * 0.125);
                    
                    $masterInvoiceHeader = MasterInvoiceItem::create([
                        'id_invoiceh'       => $invoiceHeader->id,
                        'id_client'         => $client['id'],
                        'id_farm'           => $item['id_farm'],
                        'id_load'           => $invoiceHeader->id_load,
                        'variety_id'        => $coordHawb->variety_id,
                        'hawb'              => $coordHawb->hawb, //Aqui me quede
                        'pieces'            => $item['quantity'],
                        'hb'                => $item['hb'],
                        'qb'                => $item['qb'],
                        'eb'                => $item['eb'],
                        'stems'             => 25,
                        'price'             => 0.01,
                        'bunches'           => 1,
                        'fulls'             => $fulls,    
                        'total'             => (10 * 0.01),
                        'id_user'           => $invoiceHeader->id_user,
                        'update_user'       => $invoiceHeader->update_user,
                        'stems_p_bunches'   => 25,
                        'fa_cl_de'          => $item['id_farm'] . '-' . $item['id_client'] . '-' . $coordHawb->variety_id,
                        'client_confim_id'  => $item['id_client']
                    ]);
                    
                }
            }
        }
        // Actualizamos los totales en la table Invoice Header
        $fulls = MasterInvoiceItem::select('fulls')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('fulls');
        $bunches = MasterInvoiceItem::select('bunches')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('bunches');
        $pieces = MasterInvoiceItem::select('pieces')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('pieces');
        $stems = MasterInvoiceItem::select('stems')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('stems');
        $total_t = MasterInvoiceItem::select('total')->where('id_load', '=', $masterInvoiceHeader->id_load)->sum('total');
        $invoiceHeader = InvoiceHeader::find($masterInvoiceHeader->id_invoiceh);
        $invoiceHeader->update([
            'total_fulls'   => $fulls,
            'total_bunches' => $bunches,
            'total_pieces'  => $pieces,
            'total_stems'   => $stems,
            'total'         => $total_t
        ]);

        //dd($itemsCarga);

        return redirect()->route('masterinvoices.index', $load->id)
            ->with('status_success', 'Factura creada con éxito');
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
        $invoiceHeader = InvoiceHeader::find($id);
        //dd($request);
        
        if($request->id)
        {
            $data = request()->validate([
                'id_load'               => 'required',
                'bl'                    => 'required',
                'id_company'            => 'required',
                'id_logistics_company'  => 'required',
                'date'                  => 'required',
                'invoice'               => 'required|unique:invoice_headers,invoice,' . $invoiceHeader->id,
            ]);

            $invoiceHeader->update($request->all());

            $load = Load::where('id', '=', $invoiceHeader->id_load)->first();

            return redirect()->route('masterinvoices.index', $load->id)
                ->with('status_success', 'Factura editada con éxito');
        }else{
            
            $invoiceHeader->update([
                'coordination' => $request->coordination
            ]);
            $invoiceHeader->save();

            $load = Load::where('id', '=', $invoiceHeader->id_load)->first();

            return redirect()->route('masterinvoices.index', $load->id)
                ->with('status_success', 'Cabecera de Factura editada con éxito');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoiceHeader = InvoiceHeader::find($id);
        $load = Load::where('id', '=', $invoiceHeader->id_load)->first();
        $invoiceHeader->delete();

        return redirect()->route('masterinvoices.index', $load->id)
                ->with('status_success', 'Cabecera de Factura eliminada con éxito');
    }
}
