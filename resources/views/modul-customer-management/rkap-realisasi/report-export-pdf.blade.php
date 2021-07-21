<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reporting RKAP & REALISASI TAHUN 2021</title>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font: normal 10px Verdana, Arial, sans-serif;
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
    }

    thead { display: table-header-group }
    tr { page-break-inside: avoid }

    th, tr {
        white-space: nowrap;
    }

    .text-right {
        text-align: right !important;
    }

    .text-center {
        text-align: center;
    }
</style>
<body style="padding-top:120px;">
    <div class="row">
        <div class="content-page">
            <table class="table" style="width:100%;">
                <thead>
                    <tr>
                        {{-- <th rowspan="2" class="text-center" scope="col">
                            <b>Perusahaan</b>
                        </th> --}}
                        <th rowspan="2" class="text-center">
                            <b>Keterangan</b>
                        </th>
                        <th rowspan="2" class="text-center" style="white-space: nowrap;">
                            <b>RKAP {{ $tahun_pdf }}</b>
                        </th>
                        <th rowspan="2" class="text-center">
                            <b>CI</b>
                        </th>
                        <th colspan="12" class="text-center">
                            <b>Realisasi {{ $tahun_pdf }}</b>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <b>Jan</b>
                        </th>
                        <th>
                            <b>Feb</b>
                        </th>
                        <th>
                            <b>Mar</b>
                        </th>
                        <th>
                            <b>Apr</b>
                        </th>
                        <th>
                            <b>Mei</b>
                        </th>
                        <th>
                            <b>Jun</b>
                        </th>
                        <th>
                            <b>Jul</b>
                        </th>
                        <th>
                            <b>Agu</b>
                        </th>
                        <th>
                            <b>Sep</b>
                        </th>
                        <th>
                            <b>Okt</b>
                        </th>
                        <th>
                            <b>Nov</b>
                        </th>
                        <th>
                            <b>Des</b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rkapRealisasiList as $rkapRealiasi)
                    <tr>
                        {{-- <td rowspan="9" class="no-wrap align-middle" style="padding-left:10px">{{ $rkapRealiasi->nama }}</td> --}}
                        <td class="no-wrap">Total Aset</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->aset_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_aset_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_aset_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">Revenue</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->revenue_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_revenue_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_revenue_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">Beban Pokok</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->beban_pokok_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_beban_pokok_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_beban_pokok_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">Laba Kotor</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->laba_kotor_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_laba_kotor_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_laba_kotor_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">Biaya Operasi</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->biaya_operasi_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_biaya_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_biaya_operasi_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">Laba Operasi</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->laba_operasi_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_laba_operasi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_laba_operasi_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">Laba Bersih</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->laba_bersih_r) }}</td>
                        <td class="text-center">{{ $rkapRealiasi->ci_r }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_laba_bersih_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_laba_bersih_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">TKP</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->tkp_r) }}</td>
                        <td class="text-center"></td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_tkp_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_tkp_r) }}</td>
                    </tr>
                    <tr>
                        <td class="no-wrap">KPI</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->kpi_r) }}</td>
                        <td class="text-center"></td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_kpi_r) }}</td>
                        <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_kpi_r) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>