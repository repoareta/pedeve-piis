<html>
    <head>
        <style>
            .row {
              display: -ms-flexbox;
              display: flex;
              -ms-flex-wrap: wrap;
              flex-wrap: wrap;
              margin-right: -5px;
              margin-left: -5px;
            }

            .table {
                font: normal 12px Verdana, Arial, sans-serif;
                border-collapse: collapse;
                border: 1px solid black;
            }
            th, td {
                border: 1px solid black;
                padding: 5px;
            }
            td.container {
                height: 110px;
            }
            .table-no-border-all td {
                font: normal 12px Verdana, Arial, sans-serif;
                border: 0px;
                padding: 0px;
            }
            .table-no-border td, .table-no-border tr {
                font: normal 12px Verdana, Arial, sans-serif;
                border:0px;
                padding: 0px;
            }
            .text-center {
              text-align: center;
            }
            .text-right {
              text-align: right;
            }
            td.border-less {
              border-top: 2px solid #FFFFFF;
            }
        </style>
    </head>
    <body>
        <div class="row">
          <div class="text-center">
            <p>
                <b>PT. PERTAMINA PEDEVE INDONESIA</b>
            </p>
          </div>
          <div>
            <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="120px" height="60px">
          </div>
        </div>
        <div class="row" style="margin-bottom:50px;">
          <div class="text-center">
            <p>
                <u><b>PERTANGGUNGJAWABAN UANG MUKA KERJA</b></u>
            </p>
            NOMOR: {{ $pumk_header->no_pumk }}
          </div>
        </div>

        <div class="row">
            <table class="table-no-border">
              <tr>
                <td>NAMA</td>
                <td>:</td>
                <td>{{ $pumk_header->nama }}</td>
              </tr>
              <tr>
                <td>NOMOR PEGAWAI</td>
                <td>:</td>
                <td>{{ $pumk_header->nopek }}</td>
              </tr>
              <tr>
                <td>BAGIAN/ESELON</td>
                <td>:</td>
                <td>{{ $pekerja_jabatan->kode_bagian->nama }}</td>
              </tr>
            </table>
        </div>

        <div class="row">
          <hr>
        </div>

        @php
            $umk_header_jumlah = optional($pumk_header->umk_header)->jumlah;
            $pumk_detail_jumlah = $pumk_header->pumk_detail->sum('nilai');
        @endphp

        <div class="row">
          <table class="table-no-border" style="width:100%;">
            <tr>
              <td colspan="2" style="height:40px;">
                <b>UANG MUKA KERJA/PANJAR KERJA</b>
              </td>
              <td>
                <b>Rp.</b>
              </td>
              <td class="text-right">
                <b>{{ number_format($umk_header_jumlah, 2, ',', '.') }}</b>
              </td>
            </tr>

            <tr>
              <td colspan="4">
                <b>RINCIAN PENGGUNAAN UANG MUKA KERJA : </b>
              </td>
            </tr>

            @forelse ($pumk_header->pumk_detail as $detail)
            <tr>
              <td colspan="2">
                {{ $detail->keterangan }}
              </td>
              <td>
                Rp.
              </td>
              <td class="text-right">
                {{ number_format($detail->nilai, 2, ',', '.') }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4">
                <b>Tidak ada data</b>
              </td>
            </tr>
            @endforelse

            <tr>
              <td></td>
              <td class="text-right" style="padding-right:30px; height:40px;">
                <b>JUMLAH</b>
              </td>
              <td>
                <b>Rp.</b>
              </td>
              <td style="border-top:1px solid;" class="text-right">
                <b>{{ number_format($pumk_detail_jumlah, 2, ',', '.') }}</b>
              </td>
            </>

            <tr>
              <td colspan="2" style="height:20px;">
                <b>SISA UNTUK DISETOR KEMBALI :</b>
              </td>
              <td>
                <b>Rp.</b>
              </td>
              <td class="text-right">
                <b>{{ number_format(($umk_header_jumlah - $pumk_detail_jumlah), 2, ',', '.') }}</b>
              </td>
            </tr>

            <tr>
              <td class="container" colspan="2"></td>
              <td colspan="2" valign="bottom">
                JAKARTA, 19/04/2020
              </td>
            </tr>

            <tr>
              <td class="text-center">
                MENYETUJUI,
              </td>
              <td></td>
              <td colspan="2">
                PEMOHON,
              </td>
            </tr>

            <tr>
              <td class="container text-center" valign="top">
                CS & BS
              </td>
              <td></td>
              <td colspan="2" valign="top">
                {{ $pekerja_jabatan->kode_bagian->nama }}
              </td>
            </tr>

            <tr>
              <td class="text-center">
                <u>ALI SYAMSUL ROHMAN</u>
              </td>
              <td></td>
              <td colspan="2">
                <u>{{ $pumk_header->nama }}</u>
              </td>
            </tr>
          </table>
        </div>
    </body>
</html>
