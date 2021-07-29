<!DOCTYPE html>
<html lang="en">
    <body>
        <table>
            <tr>
                <td colspan="10">PT PERTAMINA PEDEVE INDONESIA</td>
            </tr>
            <tr>
                <td colspan="10">Report Compliance Online PEDEVE</td>
            </tr>
            <tr>
                <td colspan="10">
                    Bulan {{ $bulan." ".$tahun }}
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th rowspan="3">No</th>
                    <th rowspan="3">Fungsi</th>
                    <th rowspan="3">Jabatan</th>
                    <th rowspan="3">Nopek</th>
                    <th rowspan="3">Nama</th>
                    <th rowspan="2" colspan="2">CoC</th>
                    <th rowspan="2" colspan="2">CoI</th>
                    <th rowspan="2" colspan="2">LHKPN</th>
                    <th colspan="6">Gratifikasi</th>
                    <th rowspan="3">Average</th>
                    <th rowspan="2" colspan="2">Sosialisasi</th>
                    <th rowspan="3">Nilai GCG</th>
                </tr>
                <tr>
                    <th colspan="2">Penerimaan</th>
                    <th colspan="2">Pemberian</th>
                    <th colspan="2">Permintaan</th>
                </tr>
                <tr>
                    <th>Status</th>
                    <th>%</th>
                    <th>Status</th>
                    <th>%</th>
                    <th>Status</th>
                    <th>%</th>
                    <th>Status</th>
                    <th>%</th>
                    <th>Status</th>
                    <th>%</th>
                    <th>Status</th>
                    <th>%</th>
                    <th>Status</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $total_nilai_gcg = 0;
                @endphp
                @foreach ($report_list as $report)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $report->nama_fungsi }}</td>
                        <td>{{ $report->nama_jabatan }}</td>
                        <td>{{ $report->nopeg }}</td>
                        <td>{{ $report->nama_pekerja }}</td>
                        <td>{{ $report->total_coc }}</td>
                        <td>
                            @if ($report->total_coc > 0)
                                100%
                                @php
                                    $coc_persen = 100;
                                @endphp
                            @else
                                0%
                                @php
                                    $coc_persen = 0;
                                @endphp
                            @endif
                        </td>
                        <td>{{ $report->total_coi }}</td>
                        <td>
                            @if ($report->total_coi > 0)
                                100%                    
                                @php
                                    $coi_persen = 100;
                                @endphp        
                            @else
                                0%
                                @php
                                    $coi_persen = 0;
                                @endphp     
                            @endif
                        </td>
                        <td>{{ $report->total_lhkpn }}</td>
                        <td>
                            @if ($report->total_lhkpn > 0)
                                100%                      
                                @php
                                    $lhkpn_persen = 100;
                                @endphp      
                            @else
                                0%
                                @php
                                    $lhkpn_persen = 0;
                                @endphp   
                            @endif
                        </td>
                        <td>{{ $report->penerimaan }}</td>
                        <td>
                            @if ($report->penerimaan > 0)
                                100%
                                @php
                                    $penerimaan_persen = 100;
                                @endphp                              
                            @else
                                0%
                                @php
                                    $penerimaan_persen = 0;
                                @endphp
                            @endif
                        </td>
                        <td>{{ $report->pemberian }}</td>
                        <td>
                            @if ($report->pemberian > 0)
                                100%
                                @php
                                    $pemberian_persen = 100;
                                @endphp                             
                            @else
                                0%
                                @php
                                    $pemberian_persen = 0;
                                @endphp
                            @endif
                        </td>
                        <td>{{ $report->permintaan }}</td>
                        <td>
                            @if ($report->permintaan > 0)
                                100%
                                @php
                                    $permintaan_persen = 100;
                                @endphp                          
                            @else
                                0%
                                @php
                                    $permintaan_persen = 0;
                                @endphp  
                            @endif
                        </td>
                        <td>
                            @php
                                $gratifikasi_persen = 
                                $penerimaan_persen + 
                                $pemberian_persen +
                                $permintaan_persen;

                                $gratifikasi_persen = $gratifikasi_persen / 3;
                            @endphp

                            {{ $gratifikasi_persen }}%
                        </td>
                        <td>{{ $report->total_sosialisasi }}</td>
                        <td>
                            @if ($report->total_sosialisasi > 0)
                                100%
                                @php
                                    $sosialisasi_persen = 100;
                                @endphp                           
                            @else
                                0%
                                @php
                                    $sosialisasi_persen = 0;
                                @endphp 
                            @endif
                        </td>
                        <td>
                            @php
                                $sub_nilai_gcg = 0;
                                if($report->nama_jabatan == 'Staff'){
                                    $sub_nilai_gcg = 
                                    $coc_persen * 20 +
                                    $coi_persen * 20 +
                                    $lhkpn_persen * 0 +
                                    $sosialisasi_persen * 30 +
                                    $gratifikasi_persen * 30;

                                    echo $sub_nilai_gcg / 100 . "%";
                                } else {
                                    $sub_nilai_gcg = 
                                    $coc_persen * 15 +
                                    $coi_persen * 15 +
                                    $lhkpn_persen * 20 +
                                    $sosialisasi_persen * 20 +
                                    $gratifikasi_persen * 30;

                                    echo $sub_nilai_gcg / 100 . "%";
                                }

                                $total_nilai_gcg += $sub_nilai_gcg / 100;
                            @endphp
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="20">Nilai GCG</td>
                    <td>
                        {{ $total_nilai_gcg / ($no-1) }}%
                    </td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <td></td>
                    <td>Wajib Lapor LHKPN</td>
                    <td>Non Wajib Lapor LHKPN</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        COC
                    </td>
                    <td>
                        15%
                    </td>
                    <td>
                        20%
                    </td>
                </tr>
                <tr>
                    <td>
                        COI
                    </td>
                    <td>
                        15%
                    </td>
                    <td>
                        20%
                    </td>
                </tr>
                <tr>
                    <td>
                        Sosialisasi GCG
                    </td>
                    <td>
                        20%
                    </td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>
                        Pengisian LHKPN
                    </td>
                    <td>
                        20%
                    </td>
                    <td>
                        0%
                    </td>
                </tr>
                <tr>
                    <td>
                        Pengisian Pengisian Gratifikasi
                    </td>
                    <td>
                        30%
                    </td>
                    <td>
                        30%
                    </td>
                </tr>
            </tbody>
        </table>

        <p>
            *Catatan
            <br>			
            WL LHKPN hanya untuk Level Manager Ke atas
            <br>					
            Perhitungan Average menyesuaikan dengan jabatan
            <br>							
            COI, COC, LHKPN diisi 1 tahun sekali
            <br>							
            Laporan Gratifikasi diisi setiap bulan
            <br>				
            Sosialisasi 1 tahun sekali
        </p>
    </body>
</html>