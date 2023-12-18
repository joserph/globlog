<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Coordination extends Model
{
    protected $fillable = [
        'hawb',
        'pieces',
        'hb',
        'qb', 
        'eb', 
        'hb_r',
        'qb_r',
        'eb_r',
        'missing',
        'id_client',
        'id_farm',
        'id_load',
        'variety_id',
        'id_user',
        'update_user',
        'fulls',
        'pieces_r',
        'fulls_r',
        'returns',
        'id_marketer',
        'observation'
    ];

    public function farm()
    {
        return $this->belongsTo('App\Farm', 'id_farm');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'id_client');
    }

    public function variety()
    {
        return $this->belongsTo('App\Variety', 'variety_id');
    }

    public function marketer()
    {
        return $this->belongsTo('App\Marketer', 'id_marketer');
    }

    public static function excel($load, $clientsDistribution, $coordinations, $ruc)
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

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(13);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(48);
        $spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(30);
        // Ocultar RUC
        if($ruc == false)
        {
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(0);
        }
        

        // Número de paginas
        $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddFooter('&RPagina &P de &N');

        $letra = 'A';
        // Calculo de las caldas en blanco
        $total_lineas = $coordinations->count() + ($clientsDistribution->count() * 3) + 5 + 9;
        for($letra; $letra <= 'R'; $letra++)
        {
            $spreadsheet->getActiveSheet()->getStyle($letra . '1:' . $letra . $total_lineas)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFFFF');
        }

        $sheet->getStyle('B7:R7')->getFont()->setBold(true);
        $sheet->getStyle('B8:R8')->getFont()->setBold(true);
        $sheet->getStyle('B8:R8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B8:R8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Titulo
        $sheet->getStyle('B2:R2')->getFont()->setBold(true);
        $sheet->mergeCells('B2:R2');
        $sheet->getStyle('B2:R2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:R2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:R2')->getFont()->setSize(24);
        $sheet->setCellValue('B2', 'COORDINACIÓN MARÍTIMA');
        // BL
        $sheet->getStyle('B3:R3')->getFont()->setBold(true);
        $sheet->mergeCells('B3:R3');
        $sheet->getStyle('B3:R3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B3:R3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B3:R3')->getFont()->setSize(20);
        $sheet->setCellValue('B3', $load->bl . ' - #' . $load->shipment);
        // Empresa de Logistica
        $sheet->getStyle('B4:R4')->getFont()->setBold(true);
        $sheet->mergeCells('B4:R4');
        $sheet->getStyle('B4:R4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B4:R4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if(isset($load->logistic_company->name))
        {
            $sheet->setCellValue('B4', $load->logistic_company->name);
        }else{
            $sheet->setCellValue('B4', '');
        }
        // Head coordinado
        $sheet->mergeCells('F7:J7');
        $sheet->getStyle('F7:J7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F7:J7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F7:J7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('d7f4fe');
        $sheet->getStyle('F7:J7')->applyFromArray($styleArray);
        $sheet->setCellValue('F7', 'COORDINADO');
        // Head RECIBIDO
        $sheet->mergeCells('K7:O7');
        $sheet->getStyle('K7:O7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('K7:O7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('K7:O7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('b7ffe9');
        $sheet->getStyle('K7:O7')->applyFromArray($styleArray);
        $sheet->setCellValue('K7', 'RECIBIDO');
        // HEAD
        $sheet->setCellValue('B8', 'FINCA');
        $sheet->setCellValue('C8', 'HAWB');
        $sheet->setCellValue('D8', 'RUC');
        $sheet->setCellValue('E8', 'VARIEDAD');
        $spreadsheet->getActiveSheet()->getStyle('B8:E8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('f0f0f0');
        $sheet->getStyle('B8:E8')->applyFromArray($styleArray);

        $sheet->setCellValue('F8', 'PCS');
        $sheet->setCellValue('G8', 'HB');
        $sheet->setCellValue('H8', 'QB');
        $sheet->setCellValue('I8', 'EB');
        $sheet->setCellValue('J8', 'FULL');
        $spreadsheet->getActiveSheet()->getStyle('F8:J8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('d7f4fe');
        $sheet->getStyle('F8:J8')->applyFromArray($styleArray);

        $sheet->setCellValue('K8', 'PCS');
        $sheet->setCellValue('L8', 'HB');
        $sheet->setCellValue('M8', 'QB');
        $sheet->setCellValue('N8', 'EB');
        $sheet->setCellValue('O8', 'FULL');
        $spreadsheet->getActiveSheet()->getStyle('K8:O8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('b7ffe9');
        $sheet->getStyle('K8:O8')->applyFromArray($styleArray);

        $sheet->setCellValue('P8', 'DEV');
        $spreadsheet->getActiveSheet()->getStyle('P8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('ffbcc7');
        $sheet->setCellValue('Q8', 'FALTANTES');
        $spreadsheet->getActiveSheet()->getStyle('Q8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('feffb5');
        $sheet->setCellValue('R8', 'OBSERVACIONES');
        $spreadsheet->getActiveSheet()->getStyle('R8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('00B0F0');
        $sheet->getStyle('P8:R8')->applyFromArray($styleArray);

        $fila = 9;
        $arrSubTotal = array();
        foreach($clientsDistribution as $key => $client)
        {
            $sheet->mergeCells('B'. $fila .':R' .$fila);
            $sheet->getStyle('B'. $fila .':R' .$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B'. $fila .':R' .$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'. $fila .':R' .$fila)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);
            $sheet->getStyle('B'. $fila .':R' .$fila)->getFont()->setSize(18);
            $sheet->setCellValue('B' . $fila, $client['name']);
            $sheet->getStyle('B'. $fila .':R' .$fila)->getFont()->setBold(true);
            
            $filaDos = $fila + 1;
            
            $indice = 0;
            foreach($coordinations as $key => $coord)
            {
                if($coord->id_client == $client['id'])
                {
                    $sheet->getStyle('C'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('C'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('D'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('D'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('P'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('P'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('Q'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('Q'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('R'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('R'. $filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C'. $filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $spreadsheet->getActiveSheet()->getRowDimension($filaDos)->setRowHeight(20);
                    
                    $spreadsheet->getActiveSheet()->getStyle('R'. $filaDos)
                        ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                    
                    $sheet->getStyle('E'. $filaDos .':O' .$filaDos)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('E'. $filaDos .':O' .$filaDos)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $spreadsheet->getActiveSheet()->getStyle('J' . $filaDos)->getNumberFormat()->setFormatCode('#,##0.000');
                    $spreadsheet->getActiveSheet()->getStyle('O' . $filaDos)->getNumberFormat()->setFormatCode('#,##0.000');
                    $spreadsheet->getActiveSheet()->getStyle('D' . $filaDos)->getNumberFormat()->setFormatCode('0000');

                    $sheet->setCellValue('B' . $filaDos, $coord->farm_name);
                    $sheet->setCellValue('C' . $filaDos, $coord->hawb);
                    if(isset($coord->farm_ruc))
                    {
                        $sheet->setCellValue('D' . $filaDos, $coord->farm_ruc);
                    }else{
                        $spreadsheet->getActiveSheet()->getStyle('D' . $filaDos)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('F29F05');
                        $sheet->setCellValue('D' . $filaDos, '-');
                    }
                    
                    $sheet->setCellValue('E' . $filaDos, $coord->variety->name);
                    $sheet->setCellValue('F' . $filaDos, '=SUM(G' . $filaDos . ':I' . $filaDos . ')');
                    $sheet->setCellValue('G' . $filaDos, ($coord->hb > 0 ? $coord->hb : NULL));
                    $sheet->setCellValue('H' . $filaDos, ($coord->qb > 0 ? $coord->qb : NULL));
                    $sheet->setCellValue('I' . $filaDos, ($coord->eb > 0 ? $coord->eb : NULL));
                    $sheet->setCellValue('J' . $filaDos, '=+(G' . $filaDos . '*0.5)+(H' . $filaDos . '*0.25)+(I' . $filaDos . '*0.125)', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA);
                    $sheet->setCellValue('K' . $filaDos, '=SUM(L' . $filaDos . ':N' . $filaDos . ')');
                    $sheet->setCellValue('L' . $filaDos, ($coord->hb_r > 0 ? $coord->hb_r : NULL));
                    $sheet->setCellValue('M' . $filaDos, ($coord->qb_r > 0 ? $coord->qb_r : NULL));
                    $sheet->setCellValue('N' . $filaDos, ($coord->eb_r > 0 ? $coord->eb_r : NULL));
                    $sheet->setCellValue('O' . $filaDos, '=+(L' . $filaDos . '*0.5)+(M' . $filaDos . '*0.25)+(N' . $filaDos . '*0.125)');
                    $sheet->setCellValue('P' . $filaDos, ($coord->returns > 0 ? $coord->returns : NULL));
                    $sheet->setCellValue('Q' . $filaDos, '=+F' . $filaDos . '-K' . $filaDos);
                    
                    if($coord->id_marketer)
                    {
                        $observation = 'COMPRA DE ' . $coord->marketer->name . ' (' . $coord->observation . ')';
                    }else{
                        $observation = $coord->observation;
                    }
                    $sheet->setCellValue('R' . $filaDos, $observation);
                    $sheet->getStyle('B'. $filaDos .':R' .$filaDos)->applyFromArray($styleArray);
                    
                    $filaDos++;
                }
            }
            // Imprimimos SubTotales
            $numCell = $filaDos;
            
            $sheet->mergeCells('B'. $numCell .':E' .$numCell);
            $sheet->getStyle('B'. $numCell .':E' .$numCell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B'. $numCell .':E' .$numCell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'. $numCell .':Q' .$numCell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F'. $numCell .':Q' .$numCell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('F'. $numCell .':J' .$numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('d7f4fe');
            $spreadsheet->getActiveSheet()->getStyle('K'. $numCell .':O' .$numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('b7ffe9');
            $spreadsheet->getActiveSheet()->getStyle('P' . $numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('ffbcc7');
            $spreadsheet->getActiveSheet()->getStyle('Q' . $numCell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('feffb5');
            $sheet->getStyle('B'. $numCell .':Q' .$numCell)->getFont()->setBold(true);
            $sheet->getStyle('B'. $numCell .':E' .$numCell)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getRowDimension($numCell)->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getStyle('J' . $numCell)->getNumberFormat()->setFormatCode('#,##0.000');
            $spreadsheet->getActiveSheet()->getStyle('O' . $numCell)->getNumberFormat()->setFormatCode('#,##0.000');
            $sheet->setCellValue('B' . $numCell, 'SUB-TOTAL');
            
            $arrSubTotal[] = $numCell;

            $sheet->setCellValue('D' . $numCell, '');
            $sheet->setCellValue('E' . $numCell, '');
            
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
            $sheet->setCellValue('P' . $numCell, '=SUM(P' . ($fila + 1) . ':P' . ($numCell - 1) . ')');
            $sheet->setCellValue('Q' . $numCell, '=SUM(Q' . ($fila + 1) . ':Q' . ($numCell - 1) . ')');
            
            $sheet->getStyle('B'. $numCell .':Q' .$numCell)->applyFromArray($styleArray);
            // Espacio en blanco
            $space = $numCell + 1;

            if($numCell == 50)
            {
                // SALTO DE PAGINA
                $spreadsheet->getActiveSheet()->setBreak('R' . $numCell, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW); /* new */
            }
            $sheet->setCellValue('B' . $space, '');
            $fila = $space + 1;
        }

        $numCellTotal = $fila + 1;
        $sheet->mergeCells('B'. $numCellTotal .':E' .$numCellTotal);
        $sheet->getStyle('B'. $numCellTotal .':E' .$numCellTotal)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B'. $numCellTotal .':E' .$numCellTotal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F'. $numCellTotal .':Q' .$numCellTotal)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F'. $numCellTotal .':Q' .$numCellTotal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F'. $numCellTotal .':J' .$numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('d7f4fe');
        $spreadsheet->getActiveSheet()->getStyle('K'. $numCellTotal .':O' .$numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('b7ffe9');
        $spreadsheet->getActiveSheet()->getStyle('P'. $numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('ffbcc7');
        $spreadsheet->getActiveSheet()->getStyle('Q'. $numCellTotal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('feffb5');
        $spreadsheet->getActiveSheet()->getRowDimension($numCellTotal)->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getStyle('J' . $numCellTotal)->getNumberFormat()->setFormatCode('#,##0.000');
        $spreadsheet->getActiveSheet()->getStyle('O' . $numCellTotal)->getNumberFormat()->setFormatCode('#,##0.000');
        $sheet->getStyle('B'. $numCellTotal .':Q' .$numCellTotal)->getFont()->setBold(true);
        $sheet->getStyle('B'. $numCellTotal .':Q' .$numCellTotal)->applyFromArray($styleArray);

        $sheet->setCellValue('B' . $numCellTotal, 'TOTAL');
        // SUMAR TODOS LOS SUBTOTALES DESDE LA CELDA E HASTA LA P.
        $i = 'F';
        for($i; $i <= 'Q'; $i++)
        {
            $cadena = '';
            foreach($arrSubTotal as $tot)
            {
                $cadena .= '+' . $i . $tot;
            }
            $sheet->setCellValue($i . $numCellTotal, '=' . $cadena);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if($ruc == false)
        {
            header('Content-Disposition: attachment;filename="COORDINACIÓN_MARÍTIMA - ' . $load->bl . '.xlsx"');
        }else{
            header('Content-Disposition: attachment;filename="COORDINACIÓN_MARÍTIMA_CON_RUC - ' . $load->bl . '.xlsx"');
        }
        
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
