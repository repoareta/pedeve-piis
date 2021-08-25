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

class RekapUMKExport implements
    WithDrawings,
    WithEvents
{
    use Exportable;

    private $dataUMK,
        $jumlahUMK,
        $tanggal,
        $waktu,
        $columns,
        $styles;

    /**
     * __construct
     *
     * @param  array $dataInArray
     * 
     * $dataInArray[0] = data UMK
     * $dataInArray[1] = data Jumlah UMK
     * $dataInArray[2] = $mulai, $sampai
     * $dataInArray[3] = $bulan, $tahun
     * 
     * @return void
     */
    public function __construct(array $dataInArray)
    {
        $this->dataUMK = $dataInArray[0];
        $this->jumlahUMK = $dataInArray[1];
        $this->tanggal = $dataInArray[2];
        $this->waktu = $dataInArray[3];

        $this->columns = ['A', 'B', 'C', 'D', 'E', 'F'];
        $this->styles = [
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => Border::BORDER_MEDIUM),
                'right' => array('style'  => Border::BORDER_MEDIUM),
                'bottom' => array('style'  => Border::BORDER_MEDIUM),
                'left' => array('style'  => Border::BORDER_MEDIUM)
            )
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
        $sheet->setCellValue('A2', "REKAP UANG MUKA KERJA ");
        $sheet->setCellValue('A3', "BULAN {$this->waktu[0]} {$this->waktu[1]}");
        $sheet->setCellValue('A5', "NO");
        $sheet->setCellValue('B5', "NO. BAYAR");
        $sheet->setCellValue('C5', "NO. KAS");
        $sheet->setCellValue('D5', "KEPADA");
        $sheet->setCellValue('E5', "KETERANGAN");
        $sheet->setCellValue('F5', "JUMLAH");

        $lineNumber = 1;
        $rowNumber = 6;

        foreach ($this->dataUMK as $dataUMK) {
            $sheet->setCellValue('A' . $rowNumber, $lineNumber);
            $sheet->setCellValue('B' . $rowNumber, $dataUMK['no_umk']);
            $sheet->setCellValue('C' . $rowNumber, $dataUMK['no_kas']);
            $sheet->setCellValue('D' . $rowNumber, $dataUMK['kepada']);
            $sheet->setCellValue('E' . $rowNumber, $dataUMK['keterangan']);
            $sheet->setCellValue('F' . $rowNumber, currency_idr($dataUMK['jumlah']));
            $this->selfStyling($sheet, $rowNumber);

            $rowNumber++;
            $lineNumber++;
        }

        $sheet->mergeCells('A' . $rowNumber . ':E' . $rowNumber);
        $sheet->setCellValue('A' . $rowNumber, 'TOTAL: ');
        $sheet->setCellValue('F' . $rowNumber, currency_idr($this->jumlahUMK));
        $this->selfStyling($sheet, $rowNumber, true);
    }

    private function selfStyling($sheet, $rowNumber, bool $useStyles = false)
    {
        if ($useStyles) {
            $sheet->getDelegate()
                ->getStyle('A' . $rowNumber . ':F' . $rowNumber)
                ->applyFromArray($this->styles);
        }

        $sheet->getDelegate()
            ->getStyle('A' . $rowNumber . ':F' . $rowNumber)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
    }

    private function sheetStyling($event)
    {
        $event->sheet->getDelegate()->mergeCells('A1:F1');
        $event->sheet->getDelegate()->mergeCells('A2:F2');
        $event->sheet->getDelegate()->mergeCells('A3:F3');
        $event->sheet
            ->getDelegate()
            ->getStyle('A5:F5')
            ->applyFromArray($this->styles);

        $event->sheet
            ->getDelegate()
            ->getStyle('A5:F5')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $event->sheet
            ->getDelegate()
            ->getStyle('A5:F5')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('EEE8AA');

        $event->sheet
            ->getDelegate()
            ->getStyle('A1:F5')
            ->applyFromArray($this->styles);

        foreach ($this->columns as $columns) {
            $event->getDelegate()
                ->getColumnDimension($columns)
                ->setAutoSize(true);
        }
    }
}
