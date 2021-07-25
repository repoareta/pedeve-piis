<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RekapSPD implements FromView, WithDrawings, WithEvents, ShouldAutoSize
{
    protected $panjar_header_list;
    protected $type;
    protected $mulai;
    protected $sampai;

    public function __construct($panjar_header_list, $type, $mulai, $sampai)
    {
        $this->panjar_header_list = $panjar_header_list;
        $this->type = $type;
        $this->mulai = $mulai;
        $this->sampai = $sampai;
    }
    
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $panjar_header_list = $this->panjar_header_list;
        $mulai = $this->mulai;
        $sampai = $this->sampai;
        
        if ($this->type == 'xlsx') {
            return view('perjalanan_dinas.export_xlsx', compact('panjar_header_list', 'mulai', 'sampai'));
        }
        
        return view('perjalanan_dinas.export_csv', compact('panjar_header_list'));
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Pertamina PDV Logo');
        $drawing->setDescription('Pertamina PEDEVE');
        $drawing->setPath(public_path('/images/pertamina.jpg'));
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(160, 59);
        $drawing->setCoordinates('H1');

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A5:J5'; // All headers
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
                $event->sheet->getDelegate()->getStyle('A5:J'.$highestRow)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e8e6e6');
            },
        ];
    }
}
