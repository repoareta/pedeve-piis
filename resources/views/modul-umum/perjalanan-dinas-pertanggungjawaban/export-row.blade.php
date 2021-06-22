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
          <div>
            <p>
                <b>PT. PERTAMINA PEDEVE INDONESIA</b>
                <br>
                <b>Deklarasi</b>
            </p>
          </div>
          <div>
            <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="120px" height="60px">
          </div>
        </div>
        <div class="row" style="margin-bottom:20px;">
          <table class="table-no-border">
            <tr>
              <td>Klaim Pegawai</td>
              <td>:</td>
              <td><b>{{ $ppanjar_header->nama }}</b></td>
            </tr>
            <tr>
              <td>Keterangan</td>
              <td>:</td>
              <td>{{ $ppanjar_header->keterangan }}</td>
            </tr>
            <tr>
              <td>Dokumen</td>
              <td>:</td>
              <td>
                Surat Keterangan Perjalanan Dinas Nomor 
                {{ $ppanjar_header->panjar_header->no_panjar }} 
                tanggal 
                {{ Carbon\Carbon::parse($ppanjar_header->panjar_header->tgl_panjar)->translatedFormat('d F Y') }}
              </td>
            </tr>
            <tr>
              <td>Tujuan</td>
              <td>:</td>
              <td>{{ $ppanjar_header->panjar_header->tujuan }}</td>
            </tr>
          </table>
        </div>

        @php
            $ppanjar_header_jumlah = $ppanjar_header->jmlpanjar;
            $ppanjar_detail_jumlah = $ppanjar_header->ppanjar_detail->sum('total');
            $spanrow = $ppanjar_header->ppanjar_detail->count('total');
        @endphp

        <div class="row" style="margin-bottom:20px;">
          <table class="table" style="width:100%;">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Qty</th>
                <th></th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @php
                $total =  0;
                $rowid = 0;
                $rowspan = 0; 
              @endphp
              @forelse ($ppanjar_header->ppanjar_detail as $key => $detail)
              @php
                $rowid += 1;
              @endphp
                <tr>
                  @if ($key == 0 || $rowspan == $rowid)
                      @php
                          $rowid = 0;
                          $rowspan = $spanrow;
                      @endphp
                      <td rowspan="{{ $rowspan }}" class="text-center" valign="top">
                        {{ Carbon\Carbon::parse($ppanjar_header->panjar_header->mulai)->translatedFormat('d')." - ".Carbon\Carbon::parse($ppanjar_header->panjar_header->sampai)->translatedFormat('d M Y') }}
                      </td>
                  @endif
                  <td>
                    {{ $detail->keterangan }}
                  </td>
                  <td class="text-center">
                    {{ abs($detail->qty) }}
                  </td>
                  <td class="text-right">
                    {{ currency_idr($detail->nilai) }}
                  </td>
                  <td class="text-right">
                    {{ currency_idr($detail->nilai * $detail->qty) }}
                    @php
                      $total +=  $detail->nilai * $detail->qty;  
                    @endphp
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">
                    <b>Tidak ada data</b>
                  </td>
                </tr>
              @endforelse
              <tr>
                <td colspan="2">
                </td>
                <td colspan="2" class="text-center">
                  <b>Total</b>
                </td>
                <td class="text-right">
                  {{ currency_idr($total) }}
                </td>  
              </tr>
              <tr>
                <td colspan="5">
                  <b>Terbilang</b>: {{ strtoupper(Terbilang::make(abs($total))).' RUPIAH' }}
                </td>  
              </tr>
            </tbody>
          </table>
        </div>

        <div class="row">
          <table class="table-no-border" style="width:100%;">
            <tr>
              <td colspan="2">Panjar yang sudah di terima</td>
              <td class="text-right">
                {{ currency_idr($ppanjar_header->panjar_header->jum_panjar) }}
              </td>
            </tr>
            <tr>
              <td colspan="2">
                Selisih yang harus dibayar
                <br>
                <br>
                <br>
                <br>
              </td>
              <td class="text-right" valign="top">
                {{ currency_idr(abs($ppanjar_header->panjar_header->jum_panjar - $total)) }}
              </td>
            </tr>
            <tr>
              <td class="text-center">Menyetujui</td>
              <td class="text-center">Mengetahui,</td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td class="text-center">untuk pembayaran menurut keterangan tersebut diatas</td>
              <td class="text-center">Jakarta, {{ Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
              <td class="text-center">
                <b>Atasan</b> 
                <br>
                <br>
                <br>
                <br>
                <br>
              </td>
              <td class="text-center" valign="top">
                <b>{{ $pekerja_jabatan }}</b>
              </td>
              <td></td>
            </tr>
            <tr>
              <td class="text-center"><b><u>{{ $ppanjar_header->panjar_header->atasan }}</u></b></td>
              <td class="text-center"><b><u>{{ $ppanjar_header->nama }}</u></b></td>
              <td class="text-center"><b><u>Anggraini Gitta L</u></b></td>
            </tr>
          </table>
        </div>
    </body>
</html>