<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportBoundary implements FromView, WithDrawings, WithEvents, ShouldAutoSize
{
    protected $report_list;
    protected $bulan;
    protected $tahun;

    public function __construct($report_list, $bulan, $tahun)
    {
        $this->report_list = $report_list;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }
    
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $report_list = $this->report_list;
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        
        return view('modul-sdm-payroll.gcg.report-boundary.export-xlsx', compact('report_list', 'bulan', 'tahun'));
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Pertamina PDV Logo');
        $drawing->setDescription('Pertamina PEDEVE');
        $drawing->setPath(public_path('/images/pertamina.jpg'));
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(160, 59);
        $drawing->setCoordinates('O1');

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A5:U7'; // All headers
                $highestRow = $event->sheet->getHighestRow() - 14;
                $styleArray = [
                    'borders' => [
                        // 'outline' => [
                        //     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        //     'color' => ['argb' => 'FFFF0000'],
                        // ],

                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => [
                                'rgb' => '333333'
                            ]
                        ]
                    ],
                ];

                $styleArrayHeader = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];

                $styleArrayFooter = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ];

                $styleArrayContent = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ];

                $styleArrayNopek = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ];
                
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArrayHeader);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e8e6e6');
                $event->sheet->getDelegate()->getStyle('A5:U'.$highestRow)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A'.$highestRow.':U'.$highestRow)->applyFromArray($styleArrayFooter);
                $event->sheet->getDelegate()->getStyle('F8:U'.$highestRow)->applyFromArray($styleArrayContent);
                $event->sheet->getDelegate()->getStyle('D8:D'.$highestRow)->applyFromArray($styleArrayNopek);
            },
        ];
    }
}
