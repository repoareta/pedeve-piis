<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RekapPermintaanBayarExport implements
    WithDrawings,
    WithEvents
{
    use Exportable;

    private $dataPermintaanBayar,
        $jumlahPermintaanBayar,
        $tanggal,
        $waktu,
        $columns,
        $styles;

    /**
     * __construct
     *
     * @param  array $dataInArray
     * 
     * $dataInArray[0] = data Permintaan Bayar
     * $dataInArray[1] = data Jumlah Permintaan Bayar
     * $dataInArray[2] = [$mulai, $sampai]
     * $dataInArray[3] = [$bulan, $tahun]
     * 
     * @return void
     */
    public function __construct(array $dataInArray)
    {
        $this->dataPermintaanBayar = $dataInArray[0];
        $this->jumlahPermintaanBayar = $dataInArray[1];
        $this->tanggal = $dataInArray[2];
        $this->waktu = $dataInArray[3];

        $this->columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        $this->styles = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['style'  => Border::BORDER_MEDIUM],
                'right' => ['style'  => Border::BORDER_MEDIUM],
                'bottom' => ['style'  => Border::BORDER_MEDIUM],
                'left' => ['style'  => Border::BORDER_MEDIUM]
            ]
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Pertamina PDV Logo');
        $drawing->setDescription('Pertamina PEDEVE');
        $drawing->setPath(public_path('/images/pertamina.jpg'));
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(160, 59);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $activeSheet = $event->writer->getSheetByIndex(0);
                $this->populateSheet($activeSheet);
            },

            AfterSheet::class => function (AfterSheet $event) {
                $this->sheetStyling($event);
            },
        ];
    }

    private function populateSheet($sheet)
    {
        $sheet->setCellValue('A1', "PT. PERTAMINA PEDEVE INDONESIA");
        $sheet->setCellValue('A2', "REKAP PERMINTAAN BAYAR ");
        $sheet->setCellValue('A3', "BULAN {$this->waktu[0]} {$this->waktu[1]}");
        $sheet->setCellValue('A5', "NO");
        $sheet->setCellValue('B5', "NO. BAYAR");
        $sheet->setCellValue('C5', "NO. KAS");
        $sheet->setCellValue('D5', "KEPADA");
        $sheet->setCellValue('E5', "KETERANGAN");
        $sheet->setCellValue('F5', "LAMPIRAN");
        $sheet->setCellValue('G5', "JUMLAH");

        $lineNumber = 1;
        $rowNumber = 6;

        foreach ($this->dataPermintaanBayar as $dataPermintaanBayar) {
            $sheet->setCellValue('A' . $rowNumber, $lineNumber);
            $sheet->setCellValue('B' . $rowNumber, $dataPermintaanBayar->no_bayar);
            $sheet->setCellValue('C' . $rowNumber, $dataPermintaanBayar->no_kas);
            $sheet->setCellValue('D' . $rowNumber, $dataPermintaanBayar->kepada);
            $sheet->setCellValue('E' . $rowNumber, $dataPermintaanBayar->keterangan);
            $sheet->setCellValue('F' . $rowNumber, $dataPermintaanBayar->lampiran);
            $sheet->setCellValue('G' . $rowNumber, currency_idr($dataPermintaanBayar->nilai));
            $this->selfStyling($sheet, $rowNumber);

            $rowNumber++;
            $lineNumber++;
        }

        $sheet->mergeCells('A' . $rowNumber . ':F' . $rowNumber);
        $sheet->setCellValue('A' . $rowNumber, 'TOTAL: ');
        $sheet->setCellValue('G' . $rowNumber, currency_idr($this->jumlahPermintaanBayar));
        $this->selfStyling($sheet, $rowNumber, true);
    }

    private function selfStyling($sheet, $rowNumber, bool $useStyles = false)
    {
        if ($useStyles) {
            $sheet->getDelegate()
                ->getStyle('A' . $rowNumber . ':G' . $rowNumber)
                ->applyFromArray($this->styles);
        }

        $sheet->getDelegate()
            ->getStyle('A' . $rowNumber . ':G' . $rowNumber)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
    }

    private function sheetStyling($event)
    {
        $event->sheet->getDelegate()->mergeCells('A1:G1');
        $event->sheet->getDelegate()->mergeCells('A2:G2');
        $event->sheet->getDelegate()->mergeCells('A3:G3');
        $event->sheet
            ->getDelegate()
            ->getStyle('A5:G5')
            ->applyFromArray($this->styles);

        $event->sheet
            ->getDelegate()
            ->getStyle('A5:G5')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $event->sheet
            ->getDelegate()
            ->getStyle('A5:G5')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('EEE8AA');

        $event->sheet
            ->getDelegate()
            ->getStyle('A1:G5')
            ->applyFromArray($this->styles);

        foreach ($this->columns as $columns) {
            $event->getDelegate()
                ->getColumnDimension($columns)
                ->setAutoSize(true);
        }
    }
}
