<!DOCTYPE html>
<html lang="en">
<body>
    <table>
        <tr>
            <td colspan="10">PT PERTAMINA PEDEVE INDONESIA</td>
        </tr>
        <tr>
            <td colspan="10">REPORT RKAP &amp; REALISASI</td>
        </tr>
        <tr>
            <td colspan="10">
                Tahun : {{ $tahun_pdf }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th rowspan="2" scope="col">
                    <b>Perusahaan</b>
                </th>
                <th rowspan="2">
                    <b>Keterangan</b>
                </th>
                <th rowspan="2">
                    <b>RKAP {{ $tahun_pdf }}</b>
                </th>
                <th rowspan="2">
                    <b>CI</b>
                </th>
                <th colspan="12">
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
                <td rowspan="12">{{ $rkapRealiasi->nama }}</td>
                <td>Total Aset</td>
                <td>{{ currency_format($rkapRealiasi->aset_r) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_aset_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_aset_r) }}</td>
            </tr>
            <tr>
                <td>Pendapatan Usaha</td>
                <td>{{ currency_format($rkapRealiasi->pendapatan_usaha) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_pendapatan_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_pendapatan_usaha) }}</td>
            </tr>
            <tr>
                <td>Beban Usaha</td>
                <td>{{ currency_format($rkapRealiasi->beban_usaha) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_beban_usaha) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_beban_usaha) }}</td>
            </tr>
            <tr>
                <td>Laba Kotor</td>
                <td>{{ currency_format($rkapRealiasi->laba_kotor_r) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_laba_kotor_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_laba_kotor_r) }}</td>
            </tr>
            <tr>
                <td>Pendapatan/Beban Lain</td>
                <td>{{ currency_format($rkapRealiasi->pendapatan_or_beban_lain) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_pendapatan_or_beban_lain) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_pendapatan_or_beban_lain) }}</td>
            </tr>
            <tr>
                <td>Laba Operasi</td>
                <td>{{ currency_format($rkapRealiasi->laba_operasi_r) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_laba_operasi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_laba_operasi_r) }}</td>
            </tr>
            <tr>
                <td>Laba Bersih</td>
                <td>{{ currency_format($rkapRealiasi->laba_bersih_r) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_laba_bersih_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_laba_bersih_r) }}</td>
            </tr>
            <tr>
                <td>EBITDA</td>
                <td>{{ currency_format($rkapRealiasi->ebitda) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_ebitda) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_ebitda) }}</td>
            </tr>
            <tr>
                <td>Investasi BD</td>
                <td>{{ currency_format($rkapRealiasi->investasi_bd) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_investasi_bd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_investasi_bd) }}</td>
            </tr>
            <tr>
                <td>Investasi NBD</td>
                <td>{{ currency_format($rkapRealiasi->investasi_nbd) }}</td>
                <td>{{ $rkapRealiasi->ci_r }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_investasi_nbd) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_investasi_nbd) }}</td>
            </tr>
            <tr>
                <td>TKP</td>
                <td>{{ currency_format($rkapRealiasi->tkp_r) }}</td>
                <td></td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_tkp_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_tkp_r) }}</td>
            </tr>
            <tr>
                <td>KPI</td>
                <td>{{ currency_format($rkapRealiasi->kpi_r) }}</td>
                <td></td>
                <td>{{ currency_format($rkapRealiasi->trk_jan_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_feb_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mar_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_apr_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_mei_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jun_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_jul_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_agu_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_sep_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_okt_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_nov_kpi_r) }}</td>
                <td>{{ currency_format($rkapRealiasi->trk_des_kpi_r) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>