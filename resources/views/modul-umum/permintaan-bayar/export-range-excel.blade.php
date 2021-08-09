<?php
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
$style_col = array(
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
);
$drawing = new Drawing();
$drawing->setName('Pertamina PDV Logo');
$drawing->setDescription('Pertamina PEDEVE');
$drawing->setPath(public_path('/images/pertamina.jpg'));
$drawing->setResizeProportional(false);
$drawing->setWidthAndHeight(160, 59);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($excel->getActiveSheet());
$tgl_laporan=date('Y-m-d');
$excel->getActiveSheet()->mergeCells('A1:G1');
$excel->getActiveSheet()->mergeCells('A2:G2');
$excel->getActiveSheet()->mergeCells('A3:G3');
$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PERTAMINA PEDEVE INDONESIA");
$excel->setActiveSheetIndex(0)->setCellValue('A2', "REKAP PERMINTAAN BAYAR ");
$excel->setActiveSheetIndex(0)->setCellValue('A3', "BULAN $bulan $tahun");
$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
$excel->setActiveSheetIndex(0)->setCellValue('B5', "NO. BAYAR");
$excel->setActiveSheetIndex(0)->setCellValue('C5', "NO. KAS");
$excel->setActiveSheetIndex(0)->setCellValue('D5', "KEPADA");
$excel->setActiveSheetIndex(0)->setCellValue('E5', "KETERANGAN");
$excel->setActiveSheetIndex(0)->setCellValue('F5', "LAMPIRAN");
$excel->setActiveSheetIndex(0)->setCellValue('G5', "JUMLAH");
$excel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('A5:G5')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$excel->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EEE8AA');
$excel->getActiveSheet()->getStyle('A1:G5')->applyFromArray($style_col);

$no = 1; 
$numrow =6;
foreach($bayar_header_list as $data){ 
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow,$no);
    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->no_bayar);
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->no_kas);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->kepada);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->keterangan);
    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->lampiran);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, number_format($data->nilai, 0, ',', '.'));
    $excel->getActiveSheet()->getStyle("G$numrow")->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle("A$numrow:G$numrow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $no++;
    $numrow++;
}
    $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $excel->getActiveSheet()->mergeCells("A$numrow:E$numrow");
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "Total :");
    foreach ($bayar_header_list_total as $bayar){
      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow,  number_format($bayar->nilai, 0, ',', '.'));
    }
    $excel->getActiveSheet()->getStyle("A$numrow:G$numrow")->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle("A$numrow:G$numrow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $numrow++;


$tgl_laporan=date('Ymd');
$excel = new Xlsx($excel);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Rekap Permintaan Bayar $tgl_laporan.xlsx");
header('Cache-Control: max-age=0');
$excel->save('php://output');
?>