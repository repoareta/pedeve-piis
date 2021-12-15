<html>
    <head>
        <title>COC Lampiran Satu</title>
        <style>
            .row {
              display: -ms-flexbox;
              display: flex;
              -ms-flex-wrap: wrap;
              flex-wrap: wrap;
              margin-right: -5px;
              margin-left: -5px;
            }

            .text-center {
              text-align: center;
            }

            .text-justify {
              text-align: justify;
            }
        </style>
    </head>
    <body>
        <div class="">
          <p>
            <center><b>SURAT PERNYATAAN INSAN PERTAMINA PEDEVE INDONESIA</b></center>
          </p>

          <br>

          <p class="text-justify">
            Dengan ini saya menyatakan telah menerima, membaca dan memahami
		
            Etika Usaha dan Tata Perilaku (Code of Conduct) PT. Pertamina Pedeve Indonesia
		
            Tanggal (Efektif) <b>{{ $tanggal_efektif }}</b>
            
            dan bersedia untuk mematuhi semua ketentuan yang tercantum di dalamnya dan menerima sanksi atas pelanggaran (jika ada) yang saya lakukan.
						
            <br>
            <br>
            <br>
            <br>
            <br>
            
            {{ ucwords($tempat).', '.$tanggal_efektif }}
            
            <br>
            <br>
            <br>
            <br>

            <b>
              {{ ucwords(strtolower(Auth::user()->pekerja->nama)) }} - {{ Auth::user()->fungsi->nama }}
            </b>
          </p>
        </div>
    </body>
</html>