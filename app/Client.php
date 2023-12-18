<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'state', // Estado
        'city', // Ciudad
        'country',
        'poa',
        'id_user',
        'update_user',
        'owner',
        'sub_owner',
        'sub_owner_phone',
        'related_names',
        'buyer',
        'type_load',
        'delivery',
        'method_payment',
    ];

    public function masterinvoiceitems()
    {
        return $this->hasMany('App\MasterInvoiceItem', 'id_client');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public static function excel()
    {
        // CLIENTS
        $clients = Client::orderBy('name', 'ASC')->get();
        //dd($clients->count());
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
        // Horientacion de la pagina
        $spreadsheet->getActiveSheet()->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Bordes finos
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(32);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(67);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(22);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(17);

        // Número de paginas
        $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddFooter('&RPagina &P de &N');

        $letra = 'A';
        // Calculo de las caldas en blanco
        $total_lineas = $clients->count() + 3;
        for($letra; $letra <= 'P'; $letra++)
        {
            $spreadsheet->getActiveSheet()->getStyle($letra . '1:' . $letra . $total_lineas)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');
        }

        // Titulo
        $sheet->getStyle('A2:P2')->getFont()->setBold(true);
        $sheet->mergeCells('A2:P2');
        $sheet->getStyle('A2:P2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:P2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:P2')->getFont()->setSize(24);
        $spreadsheet->getActiveSheet()->getStyle('A2:P2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('CACACA');
        $sheet->getStyle('A2:P2')->applyFromArray($styleArray);
        $sheet->setCellValue('A2', 'LISTA DE CLIENTES');
        
        $sheet->getStyle('A3:P3')->getFont()->setBold(true);
        $sheet->getStyle('A3:P3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:P3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:P3')->applyFromArray($styleArray);
        $sheet->setCellValue('A3', 'NOMBRE DE MARCACIÓN');
        $sheet->setCellValue('B3', 'TELÉFONO');
        $sheet->setCellValue('C3', 'DIRECCIÓN');
        $sheet->setCellValue('D3', 'ESTADO');
        $sheet->setCellValue('E3', 'CIUDAD');
        $sheet->setCellValue('F3', 'PAIS');
        $sheet->setCellValue('G3', 'POA');
        $sheet->setCellValue('H3', 'CORREO');
        $sheet->setCellValue('I3', 'PROPIETARIO');
        $sheet->setCellValue('J3', 'SUB PROPIETARIO');
        $sheet->setCellValue('K3', 'TELÉFONO SUB PROPIETARIO');
        $sheet->setCellValue('L3', 'NOMBRES RELACIONADOS');
        $sheet->setCellValue('M3', 'BROKER / COMPRADOR');
        $sheet->setCellValue('N3', 'TIPO DE CARGA');
        $sheet->setCellValue('O3', 'DELIVERY / PICK UP');
        $sheet->setCellValue('P3', 'FORMA DE PAGO');
        
        $fila = 4;
        foreach($clients as $item)
        {
            $sheet->getStyle('A'. $fila .':P' .$fila)->applyFromArray($styleArray);
            $sheet->setCellValue('A' . $fila, Str::of($item->name)->upper());
            $sheet->setCellValue('B' . $fila, Str::of($item->phone)->upper());
            $sheet->setCellValue('C' . $fila, Str::of($item->address)->upper());
            $sheet->setCellValue('D' . $fila, Str::of($item->state)->upper());
            $sheet->setCellValue('E' . $fila, Str::of($item->city)->upper());
            $sheet->setCellValue('F' . $fila, Str::of($item->country)->upper());
            if($item->poa == 'yes')
            {
                $poa = 'SI';
            }else{
                $poa = 'NO';
            }
            $sheet->getStyle('G' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('G' . $fila, Str::of($poa)->upper());
            $sheet->setCellValue('H' . $fila, Str::of($item->email)->lower());
            $sheet->setCellValue('I' . $fila, Str::of($item->owner)->upper());
            $sheet->setCellValue('J' . $fila, Str::of($item->sub_owner)->upper());
            $sheet->setCellValue('K' . $fila, Str::of($item->sub_owner_phone)->upper());
            $sheet->setCellValue('L' . $fila, Str::of($item->related_names)->upper());
            $sheet->setCellValue('M' . $fila, Str::of($item->buyer)->upper());
            $sheet->setCellValue('N' . $fila, Str::of($item->type_load)->upper());
            $sheet->getStyle('O' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('O' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('O' . $fila, Str::of($item->delivery)->upper());
            $sheet->getStyle('P' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('P' . $fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('P' . $fila, Str::of($item->method_payment)->upper());
            $fila++;
        }
        


        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LISTA_DE_CLIENTES.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
