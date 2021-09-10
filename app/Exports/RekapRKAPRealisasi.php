<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RekapRKAPRealisasi implements FromView, WithDrawings, WithEvents, ShouldAutoSize
{
    protected $rkapRealisasiList;
    protected $tahun_pdf;
    protected $perusahaan_pdf;
    
    public function __construct($rkapRealisasiList, $tahun_pdf, $perusahaan_pdf)
    {
        $this->rkapRealisasiList = $rkapRealisasiList;
        $this->tahun_pdf = $tahun_pdf;
        $this->perusahaan_pdf = $perusahaan_pdf;
    }

    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $rkapRealisasiList = $this->rkapRealisasiList;
        $tahun_pdf = $this->tahun_pdf;
        $perusahaan_pdf = $this->perusahaan_pdf;
        
        return view(
            'modul-customer-management.rkap-realisasi.report-export-xlsx',
            compact(
            'rkapRealisasiList',
            'tahun_pdf',
            'perusahaan_pdf'
            )
        );
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Pertamina PDV Logo');
        $drawing->setDescription('Pertamina PEDEVE');
        $drawing->setPath(public_path('/images/pertamina.jpg'));
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(160, 59);
        $drawing->setCoordinates('K1');

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A5:P6'; // All headers
                $highestRow = $event->sheet->getHighestRow();
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
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A5:P'.$highestRow)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A5:A'.$highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A5:D5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B5:D5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E5:P6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('C7:C'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $event->sheet->getDelegate()->getStyle('E7:P'.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e8e6e6');
            },
        ];
    }
}
