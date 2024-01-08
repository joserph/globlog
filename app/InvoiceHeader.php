<?php

namespace App;
use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;


class InvoiceHeader extends Model
{
    protected $fillable = [
        'id_company', // Mi empresa
        'id_load', // Carga
        'id_logistics_company', // Empresa de logistica
        'bl', 
        'carrier', 
        'invoice',
        'date',
        'total_bunches',
        'total_fulls',
        'total_pieces',
        'total_stems',
        'total',
        'id_user',
        'update_user',
        'coordination'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function userupdate()
    {
        return $this->belongsTo('App\User', 'update_user');
    }

    public static function groupEqualsMasterInvoice($invoiceItemsAll, $code)
    {
        foreach($invoiceItemsAll as $item)
        {
            // Buscamos los valores duplicados
            $dupliHawb = MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->count('hawb');
            // Validamos si hay valores duplicados, para agrupar
            
            if($dupliHawb > 1)
            {
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
                $client = ['client' => $item->client_confirm->name];
                // Para Facturas Fincas
                $address_farm = ['address_farm' => $item->address];
                $phone_farm = ['phone_farm' => $item->phone];
                $city_farm = ['city_farm' => $item->city];
                $address_client = ['address_client' => $item->client_confirm->address];
                $city_client = ['city_client' => $item->client_confirm->city];
                $state_client = ['state_client' => $item->client_confirm->state];
                $country_client = ['country_client' => $item->client_confirm->country];
                $phone_client = ['phone_client' => $item->client_confirm->phone];
                $carrier = ['carrier' => $item->invoiceh->carrier];
            }else{
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
                $client = ['client' => $item->client_confirm->name];
                // Para Facturas Fincas
                $address_farm = ['address_farm' => $item->address];
                $phone_farm = ['phone_farm' => $item->phone];
                $city_farm = ['city_farm' => $item->city];
                $address_client = ['address_client' => $item->client_confirm->address];
                $city_client = ['city_client' => $item->client_confirm->city];
                $state_client = ['state_client' => $item->client_confirm->state];
                $country_client = ['country_client' => $item->client_confirm->country];
                $phone_client = ['phone_client' => $item->client_confirm->phone];
                $carrier = ['carrier' => $item->invoiceh->carrier];
            }
            $invoiceItemsArray[] = Arr::collapse([$carrier, $phone_client, $country_client, $state_client, $city_client, $address_client, $city_farm, $phone_farm, $address_farm, $fulls, $pieces, $name, $variety, $scientific, $hawb, $stems, $bunches, $price, $total, $client]);
        }

        return collect(array_unique($invoiceItemsArray, SORT_REGULAR));
    }

    public static function excel_master($invoiceheaders, $lc_active, $company, $invoiceItems)
    {
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
        // Bordes finos
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $styleArray_2 = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(7);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(7);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        // Bordes
        $sheet->getStyle('A2:O2')->applyFromArray($styleArray);
        $sheet->getStyle('A4:O4')->applyFromArray($styleArray);
        $sheet->getStyle('A5:H8')->applyFromArray($styleArray_2);
        $sheet->getStyle('I5:O8')->applyFromArray($styleArray_2);
        $sheet->getStyle('A10:O11')->applyFromArray($styleArray);
        $sheet->getStyle('A13:O15')->applyFromArray($styleArray);

        // Titulo
        $sheet->getStyle('A2:O2')->getFont()->setBold(true);
        $sheet->mergeCells('A2:O2');
        $sheet->getStyle('A2:O2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:O2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:O2')->getFont()->setSize(24);
        $sheet->setCellValue('A2', 'MASTER INVOICE');
        // CABECERA 1
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);
        $sheet->mergeCells('A4:H4');
        $sheet->getStyle('A4:H4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A4:H4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:H4')->getFont()->setSize(14);
        $sheet->setCellValue('A4', 'Grower Name & Address / Nombre y Dirección de Cultivo');

        $sheet->getStyle('I4:O4')->getFont()->setBold(true);
        $sheet->mergeCells('I4:O4');
        $sheet->getStyle('I4:O4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('I4:O4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I4:O4')->getFont()->setSize(14);
        $sheet->setCellValue('I4', 'Foreign Purchaser / Comprador Extranjero');
        // contenido cabecera 1
        $sheet->getStyle('A5:H8')->getFont()->setSize(14);
        $sheet->mergeCells('A5:H5');
        $sheet->setCellValue('A5', $lc_active->name . 'RUC: ' . $lc_active->ruc);
        $sheet->mergeCells('A6:H6');
        $sheet->setCellValue('A6', $lc_active->address);
        $sheet->mergeCells('A7:H7');
        $sheet->setCellValue('A7', 'TLF: ' . $lc_active->phone);
        $sheet->mergeCells('A8:H8');
        $sheet->setCellValue('A8', $lc_active->city . ' - ' . $lc_active->country);

        $sheet->getStyle('I5:O8')->getFont()->setSize(14);
        $sheet->mergeCells('I5:O5');
        $sheet->setCellValue('I5', $company->name);
        $sheet->mergeCells('I6:O6');
        $sheet->setCellValue('I6', $company->address);
        $sheet->mergeCells('I7:O7');
        $sheet->setCellValue('I7', 'TLF: ' . $company->phone);
        $sheet->mergeCells('I8:O8');
        $sheet->setCellValue('I8', $company->city . ' - ' . $company->country);

        // Cabecera 2
        $sheet->getStyle('A10:O10')->getFont()->setBold(true);
        $sheet->getStyle('A10:O10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A10:O10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A10:O10')->getFont()->setSize(14);
        $sheet->mergeCells('A10:B10');
        $sheet->setCellValue('A10', 'Farm');
        $sheet->mergeCells('C10:E10');
        $sheet->setCellValue('C10', 'Date / Fecha');
        $sheet->mergeCells('F10:I10');
        $sheet->setCellValue('F10', 'Country INVOICE N°');
        $sheet->mergeCells('J10:M10');
        $sheet->setCellValue('J10', 'B/L N°');
        $sheet->mergeCells('N10:O10');
        $sheet->setCellValue('N10', 'Carrier');

        $sheet->getStyle('A11:O11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A11:O11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A11:O11')->getFont()->setSize(14);
        $sheet->mergeCells('A11:B11');
        $sheet->setCellValue('A11', 'VF');
        $sheet->mergeCells('C11:E11');
        $sheet->setCellValue('C11', $invoiceheaders->date);
        $sheet->mergeCells('F11:G11');
        $sheet->setCellValue('F11', 'GYE');
        $sheet->mergeCells('H11:I11');
        $sheet->setCellValue('H11', $invoiceheaders->invoice);
        $sheet->mergeCells('J11:M11');
        $sheet->setCellValue('J11', $invoiceheaders->bl);
        $sheet->mergeCells('N11:O11');
        $sheet->setCellValue('N11', $invoiceheaders->carrier);

        // Cabecera Items
        //Ajustar Texto
        $spreadsheet->getActiveSheet()->getStyle('C13')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('L13')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('N13')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('O13')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A13:O13')->getFont()->setBold(true);
        $sheet->getStyle('A13:O13')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A13:O13')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A13:O13')->getFont()->setSize(14);
        $sheet->mergeCells('A13:A15');
        $sheet->setCellValue('A13', 'Fulls');
        $sheet->mergeCells('B13:B15');
        $sheet->setCellValue('B13', 'Pcs');
        $sheet->mergeCells('C13:C15');
        $sheet->setCellValue('C13', 'Bunch per box');
        $sheet->mergeCells('D13:g15');
        $sheet->setCellValue('D13', 'Flower Provider');
        $sheet->mergeCells('H13:H15');
        $sheet->setCellValue('H13', 'Client');
        $sheet->mergeCells('I13:I15');
        $sheet->setCellValue('I13', 'Genus');
        $sheet->mergeCells('J13:J15');
        $sheet->setCellValue('J13', 'Species');
        $sheet->mergeCells('K13:K15');
        $sheet->setCellValue('K13', 'Hawb');
        $sheet->mergeCells('L13:L15');
        $sheet->setCellValue('L13', 'Total Stems');
        $sheet->mergeCells('M13:M15');
        $sheet->setCellValue('M13', 'Price');
        $sheet->mergeCells('N13:N15');
        $sheet->setCellValue('N13', 'Total Bunch');
        $sheet->mergeCells('O13:O15');
        $sheet->setCellValue('O13', 'Total USD');
        // Items de factura
        $count = 16;
        $fulls = 0; $pcs = 0; $stems = 0; $total = 0; $bunches = 0; $promBunches = 0;
        foreach($invoiceItems as $item)
        {
            // Bordes 
            $sheet->getStyle('A' . $count . ':C' . $count)->applyFromArray($styleArray);
            $sheet->getStyle('D' . $count . ':G' . $count)->applyFromArray($styleArray_2);
            $sheet->getStyle('H' . $count . ':O' . $count)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $count . ':C' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $count . ':C' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I' . $count . ':O' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('I' . $count . ':O' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $fulls+= $item['fulls'];
            $pcs+= $item['pieces'];
            $stems+= $item['stems'];
            $bunches+= $item['bunches'];
            $total+= $item['total'];

            $spreadsheet->getActiveSheet()->getStyle('A' . $count)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->setCellValue('A' . $count, number_format($item['fulls'], 3, '.',''));
            $sheet->setCellValue('B' . $count, $item['pieces']);
            // Promedio de bunches por cajas.
            $promBunches = $item['bunches'] / $item['pieces'];
            $sheet->setCellValue('C' . $count, round($promBunches));
            $sheet->setCellValue('D' . $count, Str::limit($item['name'], '40'));
            $sheet->setCellValue('H' . $count, Str::limit(str_replace('SAG-', '', $item['client']), '12'));
            $sheet->setCellValue('I' . $count, $item['variety']);
            $sheet->setCellValue('J' . $count, $item['scientific_name']);
            $sheet->setCellValue('K' . $count, $item['hawb']);
            $sheet->setCellValue('L' . $count, number_format($item['stems'], 0, '',''));
            $spreadsheet->getActiveSheet()->getStyle('M' . $count)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->setCellValue('M' . $count, number_format($item['price'], 2, '.',''));
            $sheet->setCellValue('N' . $count, $item['bunches']);
            $spreadsheet->getActiveSheet()->getStyle('O' . $count)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->setCellValue('O' . $count, number_format($item['total'], 2, '.',''));
            $count++;
        }
        //dd($count);
        // Bordes
        $sheet->getStyle('A' . $count . ':O' . $count)->applyFromArray($styleArray);
        // Totales
        $sheet->getStyle('A' . $count . ':O' . $count)->getFont()->setBold(true);
        $sheet->getStyle('A' . $count . ':B' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $count . ':B' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L' . $count . ':O' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('L' . $count . ':O' . $count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A' . $count)->getNumberFormat()->setFormatCode('#,##0.000');
        $sheet->setCellValue('A' . $count, number_format($fulls, 3, '.',''));
        $sheet->setCellValue('B' . $count, $pcs);
        $sheet->mergeCells('C' . $count . ':K' . $count);
        $sheet->setCellValue('C' . $count, 'TOTAL:');
        $sheet->setCellValue('L' . $count, number_format($stems, 0, '',''));
        $sheet->setCellValue('N' . $count, $bunches);
        $spreadsheet->getActiveSheet()->getStyle('O' . $count)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->setCellValue('O' . $count, number_format($total, 2, '.',''));

        // PIE
        $line = $count + 2;
        // Bordes
        $sheet->getStyle('C' . $line . ':L' . $line)->applyFromArray($styleArray);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('C' . $line . ':G' . $line);
        $sheet->setCellValue('C' . $line, 'Name and title of person preparing invoice');
        $sheet->mergeCells('H' . $line . ':L' . $line);
        $sheet->setCellValue('H' . $line, 'Freight forwarder / Agencia de carga');
        $line++;
        
        // Bordes
        $sheet->getStyle('C' . $line . ':L' . $line)->applyFromArray($styleArray);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('C' . $line . ':G' . $line);
        $sheet->setCellValue('C' . $line, '');
        $sheet->mergeCells('H' . $line . ':L' . $line);
        $sheet->setCellValue('H' . $line, $lc_active->name);
        $line++;
        // Bordes
        $sheet->getStyle('C' . $line . ':L' . $line)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getRowDimension($line)->setRowHeight(55);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('C' . $line . ':G' . $line);
        $sheet->setCellValue('C' . $line, '');
        $sheet->mergeCells('H' . $line . ':L' . $line);
        $sheet->setCellValue('H' . $line, '');
        $line++;
        // Bordes
        $sheet->getStyle('C' . $line . ':L' . $line)->applyFromArray($styleArray);
        $sheet->getStyle('C' . $line . ':L' . $line)->getFont()->setBold(true);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $line . ':O' . $line)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('C' . $line . ':G' . $line);
        $sheet->setCellValue('C' . $line, 'SIGNATURE');
        $sheet->mergeCells('H' . $line . ':L' . $line);
        $sheet->setCellValue('H' . $line, 'NANDINA');

        $writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="myfile.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
