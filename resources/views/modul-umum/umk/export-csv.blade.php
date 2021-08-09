<?php
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
$tgl_laporan=date('Y-m-d');
$excel->getActiveSheet()->mergeCells('A1:F1');
$excel->getActiveSheet()->mergeCells('A2:F2');
$excel->getActiveSheet()->mergeCells('A3:F3');
$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. PERTAMINA PEDEVE INDONESIA");
$excel->setActiveSheetIndex(0)->setCellValue('A2', "REKAP UANG MUKA KERJA ");
$excel->setActiveSheetIndex(0)->setCellValue('A3', "BULAN $bulan $tahun");
$excel->setActiveSheetIndex(0)->setCellValue('A4', "NO");
$excel->setActiveSheetIndex(0)->setCellValue('B4', "NO. UMK");
$excel->setActiveSheetIndex(0)->setCellValue('C4', "NO. KAS");
$excel->setActiveSheetIndex(0)->setCellValue('D4', "KEPADA");
$excel->setActiveSheetIndex(0)->setCellValue('E4', "KETERANGAN");
$excel->setActiveSheetIndex(0)->setCellValue('F4', "JUMLAH");
$no = 1; 
$numrow =5;
foreach($umk_header_list as $data){ 
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow,$no);
    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->no_umk);
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->no_kas);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->kepada);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->keterangan);
    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->jumlah);
    $no++;
    $numrow++;
}
$tgl_laporan=date('Ymd');
$excel = new Csv($excel);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=Rekap UMK $tgl_laporan.csv");
header('Cache-Control: max-age=0');
$excel->save('php://output');
?>