<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Form Cetak 1721-A1 Tahunan
    </title>
</head>
<style media="screen">
    table {
        width: 100%;
        border-collapse: collapse;
        padding-top: 30%;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    td {
        vertical-align: top;
        padding: 5px;
    }

    .row-td {
        vertical-align: top;
        padding: 5px;
        border-left: 1px solid black;
        border-right: 1px solid black;
        width: 11%;
        /* font: normal 12px Verdana, Arial, sans-serif; */
    }

    th {
        padding: 7px;
        border: 1px solid black;
    }

    thead {
        display: table-header-group;
        /* font: normal 14px Verdana, Arial, sans-serif; */
    }

    tr {
        page-break-inside: avoid
    }

    .th-small {
        width: 40px;
    }

    .th-medium {
        width: 70px;
    }

    .th-large {
        width: 120px;
    }
</style>

<body style="">
    <?php
foreach($data_list as $key=>$row){
?>
    <table border="1">
        <thead style="border-bottom:1px solid black;">
            <tr>
                <td style="text-align: center;padding-left:10px;padding-top:20px;">
                    <table>
                        <tr style="font-size: 18pt;font-weight: bold;">
                            <td>1721 - A1 </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11pt;">DEPARTEMEN KEUANGAN RI</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11pt;">DIREKTORAT JENDERAL PAJAK</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;font-weight: bold;">
                    <table>
                        <tr>
                            <td>BUKTI PEMOTONGAN PAJAK PENGHASILAN PASAL 21 BAGI PEGAWAI</td>
                        </tr>
                        <tr>
                            <td>TETAP ATAU PENERIMA PENSIUN ATAU TUNJANGAN HARI</td>
                        </tr>
                        <tr>
                            <td>TUA/TABUNGAN HARI TUA/JAMINAN HARI TUA</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center">
                    <table>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="font-size: 18pt;font-weight: bold;padding-top:25%">{{ $row->tahun }}</td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
    </table>
    <main>
        <table border="1">
            <thead style="border-bottom:1px solid black;">
                <tr>
                    <td style="text-align: left;padding-left:10px;padding-top:20px;">
                        <table>
                            <?php 
                                $data_pegawai = DB::table('sdm_master_pegawai')->where('nopeg',$row->nopek)->get();
                                if(count($data_pegawai) > 0){
                                    foreach($data_pegawai as $data_peg)
                                    {
                                        $nama = $data_peg->nama;
                                        $npwp = $data_peg->npwp;
                                        $alamat = $data_peg->alamat1;
                                        $jenis = $data_peg->gender;
                                        $kdkel = $data_peg->kodekeluarga;
                                    }
                                } else {
                                    $nama = '-';
                                    $npwp = '-';
                                    $alamat = '-';
                                    $jenis = 'L';
                                    $kdkel = '-';
                                }
                        
                                $data_tunj = DB::table('report_pajak')->where('nopek',$row->nopek)->where('tahun',$row->tahun)->get();
                                if(count($data_tunj) > 0){
                                    foreach($data_tunj as $data_t)
                                    {
                                        $data_no_2 = $data_t->tunjpajak;
                                        $data_no_10 = $data_t->bjabatan;
                                        $data_no_11 = $data_t->bjabatan2;
                                        $data_no_17 = $data_t->nilptkp;
                                        $data_no_19 = $data_t->tunjpajak;
                                        $data_tunjpajak = $data_t->tunjpajak;
                                        $mulai = $data_t->mulai;
                                        $sampai = $data_t->sampai;
                                    }
                                } else {
                                    $data_tunjpajak = 0;
                                    $data_no_2 = 0;
                                    $data_no_10 = 0;
                                    $data_no_11 = 0;
                                    $data_no_17 = 0;
                                    $data_no_19 = 0;
                                    $mulai = '-';
                                    $sampai = '-';
                                }
                                $data_no_9 = $row->data_9+$data_tunjpajak+$row->data_2;
                            ?>
                            <tr style="font-size: 11pt;">
                                <td width="45%">NOMOR URUT</td>
                                <td></td>
                                <td width="100%"></td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>NPWP PEMOTONG PAJAK</td>
                                <td></td>
                                <td>02.097.576.9-073.000</td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>NAMA PEMOTONG PAJAK</td>
                                <td></td>
                                <td>PT. PERTAMINA PEDEVE INDONESIA</td>
                                <td>{{number_format($row->data_8,2) < 0 ? "(".number_format($row->data_8*-1,2).")" : number_format($row->data_8,2)}}
                                </td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>NAMA PEGAWAI ATAU PENERIMA PENSIUN/THT/JHT</td>
                                <td>:</td>
                                <td>{{ $nama }}{{ $row->nopek}}</td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>NPWP PEGAWAI ATAU PENERIMA PENSIUN/THT/JHT</td>
                                <td>:</td>
                                <td>{{ $npwp}}</td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>ALAMAT PEGAWAI ATAU PENERIMA </td>
                                <td>:</td>
                                <td>{{ $alamat}}</td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>JENIS KELAMIN</td>
                                <td>:</td>
                                <td><input type="checkbox" <?php if ($jenis == 'L' )  echo 'checked' ; ?>> LAKI-LAKI
                                    <input type="checkbox" <?php if ($jenis == 'P' )  echo 'checked' ; ?>> PEREMPUAN
                                </td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>JUMLAH TANGGUNGAN KELUARGA UNTUK PTKP</td>
                                <td>:</td>
                                <td>
                                    <?php
                                        if ($kdkel == '100') {
                                            echo "TK/0";
                                        }else if($kdkel == '102'){
                                            echo "TK/2";
                                        }else if($kdkel == '200'){
                                            echo "K/0";
                                        }else if($kdkel =='201'){
                                            echo "K/1";
                                        }else if($kdkel =='202'){
                                            echo "K/2";
                                        }else if($kdkel =='203'){
                                            echo "K/3";
                                        } else {
                                            echo "";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>JABATAN</td>
                                <td>:</td>
                                <td>-</td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td>MASA PEROLEHAN PENGHASILAN</td>
                                <td>:</td>
                                <td>{{ $mulai}}/{{ $sampai}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </thead>
        </table>

        {{--<table>
            <tr>
                <td>0.00</td>
                <td>{{number_format($row->data_1,2) < 0 ? "(".number_format($row->data_1*-1,2).")" : number_format($row->data_1,2)}}
        </td>
        <td>{{number_format($row->data_2,2) < 0 ? "(".number_format($row->data_2*-1,2).")" : number_format($row->data_2,2)}}
        </td>
        <td>{{number_format($row->data_3,2) < 0 ? "(".number_format($row->data_3*-1,2).")" : number_format($row->data_3,2)}}
        </td>
        <td>{{number_format($row->data_6,2) < 0 ? "(".number_format($row->data_6*-1,2).")" : number_format($row->data_6,2)}}
        </td>
        <td>{{number_format($row->data_4,2) < 0 ? "(".number_format($row->data_4*-1,2).")" : number_format($row->data_4,2)}}
        </td>
        <td>{{number_format($row->data_5,2) < 0 ? "(".number_format($row->data_5*-1,2).")" : number_format($row->data_5,2)}}
        </td>
        </tr>
        </table>--}}

        <table border="1">
            <thead style="border-bottom:1px solid black;">
                <tr>
                    <td style="text-align: left;padding-left:10px;padding-top:20px;">
                        <table>
                            <tr style="font-size: 11pt;font-weight: bold;">
                                <td width="85%">A. RINCIAN PENGHASILAN DAN PENGHITUNGAN PPh PASAL 21 SEBAGAI BERIKUT
                                </td>
                                <td></td>
                                <td width="100%" style="text-align: center;">RUPIAH</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;font-weight: bold;padding-left:25px;">PENGHASILAN BRUTO :
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">1. GAJI/ PENSIUN ATAU THT/JHT</td>
                                <td>:</td>
                                <td>{{number_format($row->data_1,2) < 0 ? "(".number_format($row->data_1*-1,2).")" : number_format($row->data_1,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">2. TUNJANGAN PPh</td>
                                <td>:</td>
                                <td>{{number_format($data_no_2,2) < 0 ? "(".number_format($data_no_2*-1,2).")" : number_format($data_no_2,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">3. TUNJANGAN LAINNYA, UANG LEMBUR DAN
                                    SEBAGAINYA</td>
                                <td>:</td>
                                <td>{{number_format($row->data_6,2) < 0 ? "(".number_format($row->data_6*-1,2).")" : number_format($row->data_6,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">4. HONORARIUM DAN IMBALAN LAIN SEJENISNYA
                                </td>
                                <td>:</td>
                                <td>{{number_format($row->data_4,2) < 0 ? "(".number_format($row->data_4*-1,2).")" : number_format($row->data_4,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">5. PREMI ASURANSI YANG DIBAYAR PEMBERI
                                    KERJA</td>
                                <td>:</td>
                                <td>{{number_format($row->data_8,2) < 0 ? "(".number_format($row->data_8*-1,2).")" : number_format($row->data_8,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">6. PENERIMAAN DALAM BENTUK NATURA DAN
                                    KENIKMATAN LAINNYA YANG DIKENAKAN PPh PASAL 21 </td>
                                <td>:</td>
                                <td>0.00</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">7. JUMLAH (1 s.d 6) </td>
                                <td>:</td>
                                <td>{{number_format($row->data_9+$data_tunjpajak,2) < 0 ? "(".number_format($row->data_9+$data_tunjpajak*-1,2).")" : number_format($row->data_9+$data_tunjpajak,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">8. TANTIEM, BONUS, GRATIFIKASI, JASA
                                    PRODUKSI DAN THR </td>
                                <td>:</td>
                                <td>{{number_format($row->data_2,2) < 0 ? "(".number_format($row->data_2*-1,2).")" : number_format($row->data_2,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">9. JUMLAH PENGHASILAN BRUTO (7 + 8) </td>
                                <td>:</td>
                                <td>{{number_format($data_no_9,2) < 0 ? "(".number_format($data_no_9*-1,2).")" : number_format($data_no_9,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;font-weight: bold;padding-left:25px;">PENGURANGAN :</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">10. BIAYA JABATAN/BIAYA PENSIUN ATAS
                                    PENGHASILAN PADA ANGKA 7</td>
                                <td>:</td>
                                <td>{{number_format($data_no_10,2) < 0 ? "(".number_format($data_no_10*-1,2).")" : number_format($data_no_10,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">11. BIAYA JABATAN/BIAYA PENSIUN ATAS
                                    PENGHASILAN PADA ANGKA 8 </td>
                                <td>:</td>
                                <td>{{number_format($data_no_11,2) < 0 ? "(".number_format($data_no_11*-1,2).")" : number_format($data_no_11,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">12. IURAN PENSIUN ATAU IURAN THT/ JHT
                                </td>
                                <td>:</td>
                                <td>{{number_format($row->data_5,2) < 0 ? "(".number_format($row->data_5*-1,2).")" : number_format($row->data_5,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">13. JUMLAH PENGURANGAN (10 + 11 + 12)
                                </td>
                                <td>:</td>
                                <td>{{number_format($data_no_10+$data_no_10+$row->data_5,2) < 0 ? "(".number_format($data_no_10+$data_no_10+$row->data_5*-1,2).")" : number_format($data_no_10+$data_no_10+$row->data_5,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;font-weight: bold;padding-left:25px;">PENGHITUNGAN PPh PASAL
                                    21 :</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">14. JUMLAH PENGHASILAN NETO (9 - 13)
                                </td>
                                <td>:</td>
                                <td>{{number_format($data_no_9+$data_no_10+$data_no_10+$row->data_5,2) < 0 ? "(".number_format($data_no_9+$data_no_10+$data_no_10+$row->data_5*-1,2).")" : number_format($data_no_9+$data_no_10+$data_no_10+$row->data_5,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">15. PENGHASILAN NETO MAS SEBELUMNYA </td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">16. JUMLAH PENGHASILAN NETO UNTUK
                                    PENGHITUNGAN PPh PASAL 21 (SETAHUN/DISETAHUNKAN) </td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">17. PENGHASILAN TIDAK KENA PAJAK (PTKP)
                                </td>
                                <td>:</td>
                                <td>{{number_format($data_no_17,2) < 0 ? "(".number_format($data_no_17*-1,2).")" : number_format($data_no_17,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">18. PENGHASILAN KENA PAJAK SETAHUN/
                                    DISETAHUNKAN (16-17) </td>
                                <td>:</td>
                                <td>{{number_format(($data_no_9+$data_no_10+$data_no_10+$row->data_5)-$data_no_17,2) < 0 ? "(".number_format(($data_no_9+$data_no_10+$data_no_10+$row->data_5)-$data_no_17*-1,2).")" : number_format(($data_no_9+$data_no_10+$data_no_10+$row->data_5)-$data_no_17,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">19. PPh PASAL 21 ATAS PENGHASILAN KENA
                                    PAJAK SETAHUN/DISETAHUNKAN </td>
                                <td>:</td>
                                <td>{{number_format($data_no_19,2) < 0 ? "(".number_format($data_no_19*-1,2).")" : number_format($data_no_19,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">20. PPh PASAL 21 YANG TELAH DIPOTONG MASA
                                    SEBELUMNYA</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">21. PPh PASAL 21 TERUTANG </td>
                                <td>:</td>
                                <td>{{number_format($data_no_19,2) < 0 ? "(".number_format($data_no_19*-1,2).")" : number_format($data_no_19,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">22. PPh PASAL 21 DAN PPh PASAL 26 YANG
                                    TELAH DIPOTONG DAN DILUNASI </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:35px;">22a. Dipotong dan dilunasi dengan SSP PPh
                                    Pasal 21 Ditanggung </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:35px;">22b. Dipotong dan dilunasi dengan SSP
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">23. JUMLAH PPh PASAL 21 :</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:35px;">a. Yang Kurang Dipotong (21 - 22) </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:35px;">b. Yang Lebih Dipotong (22 - 21)</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:15px;">24. JUMLAH TERSEBUT PADA ANGKA 23 TELAH
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:35px;">a. Dipotong Dari Pembayaran Gaji</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 11pt;padding-left:35px;">b. Diperhitungkan Dengan Pph Pasal 21
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </thead>
        </table>
        <table border="1">
            <thead style="border-bottom:1px solid black;">
                <tr>
                    <td style="text-align: left;padding-left:10px;padding-top:10px;">
                        <table>
                            <tr style="font-size: 11pt;font-weight: bold;">
                                <td width="85%">B. TANDA TANGAN DAN CAP PERUSAHAAN </td>
                            </tr>
                            <tr style="font-size: 11pt;">
                                <td colspan="3">
                                    <table>
                                        <tr>
                                            <td>
                                                <p><input type="checkbox" checked> PEMOTONG PAJAK <input
                                                        type="checkbox"> KUASA</p>
                                            </td>
                                        </tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td width="20%">NAMA LENGKAP</td>
                                                    <td>MUHAMMAD SURYOHADI </td>
                                                </tr>
                                                <tr>
                                                    <td>NPWP </td>
                                                    <td>47.442.180.7-609.000</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </thead>
        </table>
    </main>
    <?php } ?>
</body>

</html>