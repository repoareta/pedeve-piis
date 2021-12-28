<html>
    <head>
        <title>Report Panjar Dinas</title>
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

            td.border-less {
              border-top: 2px solid #FFFFFF;
            }
        </style>
    </head>
    <body>
        <div class="row">
          <div class="text-center">
            <p>
                <u>SURAT KETERANGAN PERJALANAN DINAS</u>
            </p>
            {{ $panjar_header->no_panjar }}
          </div>

          <div>
            <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="120px" height="60px">
          </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <table class="table-no-border">
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $panjar_header->nama }}</td>
              </tr>
              <tr>
                <td>No. Pekerja</td>
                <td>:</td>
                <td>{{ $panjar_header->nopek }}</td>
              </tr>
              <tr>
                <td>PJL/Golongan</td>
                <td>:</td>
                <td>{{ $panjar_header->gol }}</td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $panjar_header->jabatan }}</td>
              </tr>
              <tr>
                <td>No. KTP/Passport</td>
                <td>:</td>
                <td>{{ $panjar_header->ktp ? $panjar_header->ktp : '-' }}</td>
              </tr>
              <tr>
                <td>Untuk Melaksanakan</td>
                <td>:</td>
                <td>
                  @if ($panjar_header->jenis_dinas == 'LN')
                    PDN-LN
                  @elseif($panjar_header->jenis_dinas == 'DN')
                    PDN-DN
                  @else
                    {{ $panjar_header->jenis_dinas }}    
                  @endif
                </td>
              </tr>
              <tr>
                <td>Dari/Asal</td>
                <td>:</td>
                <td>{{ $panjar_header->dari }}</td>
              </tr>
              <tr>
                <td>Tempat Tujuan</td>
                <td>:</td>
                <td>{{ $panjar_header->tujuan }}</td>
              </tr>
              <tr>
                <td>Terhitung Mulai Tanggal</td>
                <td>:</td>
                <td>{{ Carbon\Carbon::parse($panjar_header->mulai)->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <td>Berangkat/Kembali Tanggal</td>
                <td>:</td>
                <td>{{ Carbon\Carbon::parse($panjar_header->sampai)->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <td>Berkendaraan</td>
                <td>:</td>
                <td>{{ $panjar_header->kendaraan }}</td>
              </tr>
              <tr>
                <td>Biaya Ditanggung Oleh</td>
                <td>:</td>
                <td>
                  @if ($panjar_header->ditanggung_oleh == 'K')
                    Ditanggung Pribadi
                  @elseif($panjar_header->ditanggung_oleh == 'P')
                    Ditanggung Perusahaan
                  @elseif($panjar_header->ditanggung_oleh == 'U')
                    Ditanggung PPU
                  @endif
                </td>
              </tr>
            </table>
        </div>

        <div class="row" style="margin-top:5px">
            <table style="width:100%;" class="table">
              <tr>
                  <td colspan="6" valign="top">
                    <u>KETERANGAN/KEPERLUAN</u>
                    <p>
                      {{ $panjar_header->keterangan }}
                    </p>
                  </td>
              </tr>
              <thead>
                <tr>
                  <th>NO</th>
                  <th>NAMA PENGIKUT</th>
                  <th>NOPEK</th>
                  <th>GOLONGAN</th>
                  <th>JABATAN</th>
                  <th>KETERANGAN</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $i = 1;
                @endphp
                @forelse ($panjar_header->panjar_detail->sortBy('no') as $panjar_detail)
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $panjar_detail->nama }}</td>
                    <td>{{ $panjar_detail->nopek }}</td>
                    <td>{{ $panjar_detail->status }}</td>
                    <td>{{ $panjar_detail->jabatan }}</td>
                    <td>{{ $panjar_detail->keterangan }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" style="text-align:center">-</td>
                  </tr>
                @endforelse

                <tr>
                  <td colspan="2" class="container" valign="top">
                    YBS,
                  </td>
                  <td colspan="2" valign="top">
                    ATASAN YBS,
                  </td>
                  <td valign="top">
                    MENYETUJUI
                  </td>
                  <td valign="top">
                    JAKARTA, {{ date('d/m/Y') }}
                    <br>
                    <center>
                      Corporate Secretary & Business Support
                    </center>
                  </td>
                </tr>

                <tr>
                  <td colspan="2" class="text-center border-less">
                    {{ $panjar_header->nama }}
                  </td>
                  <td colspan="2" class="text-center border-less">
                    {{ $panjar_header->atasan }}
                  </td>
                  <td class="text-center border-less">
                    {{ $panjar_header->menyetujui }}
                  </td>
                  <td class="text-center border-less">
                    {{ $panjar_header->personalia }}
                  </td>
                </tr>

                <tr>
                  <td colspan="6" class="container" valign="top">
                    PANJAR/LUMPSUM PERJALANAN DINAS
                    <br>
                    <br>
                    <br>
                    <br>
                    {{ currency_idr($panjar_header->jum_panjar) }}
                    {{ abs($panjar_header->jum_panjar) > 0 ? '('.strtoupper(Terbilang::make($panjar_header->jum_panjar)).' RUPIAH )' : '(NOL RUPIAH)' }} 
                  </td>
                </tr>
              </tbody>
          </table>
        </div>
        
        <div class="row" style="margin-top:5px">
          <table style="width:100%;" class="table">
            <tr>
              <td rowspan=2 class="text-center" width="160px">KETERANGAN</td>
              <td colspan="4" class="text-center">TUJUAN</td>
            </tr>
            <tr>
              <td class="text-center">I</td>
              <td class="text-center">II</td>
              <td class="text-center">III</td>
              <td class="text-center">IV</td>
            </tr>
            <tr>
              <td>TANGGAL TIBA</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>TANGGAL KEMBALI</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="container" valign="top">TANDA TANGAN PEJABAT YANG DIKUNJUNGI</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </table>
        </div>

        <div class="row">
          <table class="table-no-border">
            <tr>
              <td>*ASLI</td>
              <td>:</td>
              <td>Yang Bersangkutan</td>
            </tr>
            <tr>
              <td>*TEMBUSAN</td>
              <td>:</td>
              <td>1. CS&BS 2. FINANCE 3. FILE</td>
            </tr>
          </table>
        </div>

    </body>
</html>