<html>
    <head>
        <title>COI Lampiran Dua</title>
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
                <center>
                    <b>
                        SURAT PERNYATAAAN INSAN PERTAMINA PEDEVE INDONESIA
                    </b>
                </center>
            </p>
            <br>
            <p>
                Yang bertanda tangan dibawah ini:
                <br>
                Nama: {{ Auth::user()->pekerja->nama }}
                <br>
                Nomor Pekerja: {{ Auth::user()->nopeg }}
                <br>
                Jabatan: {{ Auth::user()->pekerja->jabatan[0]->kode_jabatan->keterangan }}
                <br>
                Fungsi: {{ Auth::user()->pekerja->jabatan[0]->kode_bagian->nama }}
            </p>

            <p class="text-justify">
                Dengan ini menyatakan dan menjamin bahwa SAYA tidak mempunyai benturan kepentingan terhadap PT. Pertamina Pedeve Indonesia yang membuat SAYA tidak patut untuk melakukan tindakan berikut ini :

                <ul class="text-justify">
                    <li>
                        Melaksanakan jasa apapun atau memiliki peran apapun dalam perusahaan lain atau usaha pesaing yang sedang atau akan melakukan kerjasama usaha dengan PT. Pertamina Pedeve Indonesia.
                    </li>
                    <li>
                        Memiliki kepentingan ekonomi secara langsung maupun tidak langsunh terhadap persahaan atau organisasi manapun yang saat ini sedang melakukan kerjasama dengan PT. Pertamina Pedeve Indonesia atau ingin melakukan kerjasama dengan PT. Pertamina Pedeve Indonesia.
                    </li>
                    <li>
                        Memiliki anggota keluarga atau teman yang memiliki kepentingan ekonomi secara langsung maupun tidak langsung terhadap perusahaan atau organisasi yang saat ini melakukan usaha dengan PT. Pertamina Pedeve Indonesia.
                    </li>
                    <li>
                        Melakukan transaksi dan/atau menggunakan harta/fasilitas PT. Pertamina Pedeve Indonesia untuk kepentingan diri sendiri, keluarga, atau golongan.
                    </li>
                    <li>
                        Mewakili PT. Pertamina Pedeve Indonesia dalam transaksi dengan perusahaan lain dimana SAYA atau anggota keluarga SAYA atau teman SAYA memiliki kepentingan.
                    </li>
                    <li>
                        Menerima hadiah, uang atau hiburan dari pemasok atau mitra usaha, atau dari agen manapun atau bertindak sebagai atau mewakili pemasok atau mitra usaha dalam transaksinya dengan PT. Pertamina Pedeve Indonesia selain daripada yang diuraikan dalam kebijakan PT. Pertamina Pedeve Indonesia mengenai Hadiah dan Hiburan.
                    </li>
                    <li>
                        Menggunakan informasi rahasia dan data bisnis PT. Pertamina Pedeve Indonesia untuk kepentingan pribadi atau dengan cara yang merugikan kepentingan PT. Pertamina Pedeve Indonesia.
                    </li>
                    <li>
                        Mengungkapkan kepada individu atau organisasi atau pihak manapun di luar PT. Pertamina Pedeve Indonesia setiap informasi, program, data keuangan, formula, proses atau "Know-How" rahasia milik PT. Pertamina Pedeve Indonesia atau yang dikembangkan oleh SAYA dalam memenuhi tanggung jawab SAYA terhadap PT. Pertamina Pedeve Indonesia.
                    </li>
                    <li>
                        Melaksanakan setiap tindakan lainnya, yang tidak disebutkan secara spesifik diatas ini, yang dianggap merugikan bagi kepentingan PT. Pertamina Pedeve Indonesia.
                    </li>
                </ul>

                SAYA mengerti bahwa apabila SAYA memiliki benturan kepentingan dan sebelumnya SAYA tidak melaporkan hal tersebut kepada atasan atau pihak yang berwenang di PT. Pertamina Pedeve Indonesia. SAYA dapat dikenakan tindakan disiplin sebagaimana yang tercantum dalam peraturan perusahaan PT. Pertamina Pedeve Indonesia yang mana SAYA telah memahami peraturan tersebut.

                <br>
                <br>

                Demikian pernyataan ini SAYA buat dengan sebenarnya, dalam keadaan sehat baik jasmani dan rohani dan tanpa ada paksaan dari pihak manapun.
            </p>

            <br>
            <br>
            <div style="text-align:right;">
                {{ ucwords($tempat).', '.$tanggal_efektif }}
            </div>

            <div style="text-align:left;">
            Mengetahui,
            <br>
            Atasan
            <span style="float:right;">
                Pekerja
            </span>
            </div>
            <br>
            <br>
            <br>
            <div style="text-align: left">
			{{ Auth::user()->pekerja->jabatan[0]->kode_bagian->pimpinan->nama . ' - ' . Auth::user()->pekerja->jabatan[0]->kode_bagian->pimpinan->jabatan[0]->kode_jabatan->keterangan }}

			<span style="float:right;">
				{{ Auth::user()->pekerja->nama.' - '.Auth::user()->pekerja->jabatan[0]->kode_bagian->nama }}
			</span>
		</div>

        </div>
    </body>
</html>
