<html>
    <head>
        <title>COI Lampiran Satu</title>
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
                        SURAT PERNYATAAN INSAN PERTAMINA PEDEVE INDONESIA
                    </b>
                </center>
            </p>

            <br>

            <p>
                Yang bertanda tangan dibawah ini, Saya 
                <b>{{ Auth::user()->pekerja->nama }}</b> 
                Nomor Pekerja 
                <b>{{ Auth::user()->nopeg }}</b>
                , menyatakan bahwa :
            </p>

            <p class="text-justify">
                <ol class="text-justify">
                <li>
                    Atasan saya telah menjelaskan mengenai apa yang dimaksud dengan Konflik Kepentingan.
                </li>
                <li>
                    Saya juga telah membaca dan mengerti bahwa berikut ini merupakan Konflik kepentingan yaitu sebagai berikut :
                    <br>
                    <ol type="a" class="text-justify">
                    <li>
                        Melaksanakan jasa apapun atau memainkan peran apapun dalam perusahaan atau usaha pesaing yang memalukan atau ingin melakukan usaha dengan PT. Pertamina Pedeve Indonesia;
                    </li>
                    <li>
                        Memiliki kepentingan apapun (komersial atau lainnya) dalam perusahaan atau organisasi manapun yang saat ini sedang melakukan usaha dengan PT. Pertamina Pedeve Indonesia atau ingin melakukan usaha dengan PT. Pertamina Pedeve Indonesia;
                    </li>
                    <li>
                        Memiliki anggota keluarga atau teman yang memiliki kepentingan dalam perusahaan atau organisasi yang saat ini melakukan usaha dengan PT. Pertamina Pedeve Indonesia; 
                    </li>
                    <li>
                        Melakukan transaksi dan/atau menggunakan harga/fasilitas PT. Pertamina Pedeve Indonesia untuk kepentingan diri sendiri, keluarga, atau golongan;
                    </li>
                    <li>
                        Mewakili PT Pertamina Pedeve Indonesia dalam transaksi dengan perusahaan lain dimana saya atau anggota keluarga saya atau teman saya memiliki kepentingan;
                    </li>
                    <li>
                        Menerima hadiah, uang atau hiburan dan pemasok atau mitra usaha, atau dari agen manapun atau bertindak sebagai atau mewakili pemasok atau mitra usaha dalam transaksinya dengan PT. Pertamina Pedeve Indonesia, selain daripada yang diuraikan dalam kebijakan Hadiah dan Hiburan;
                    </li>
                    <li>
                        Menggunakan informasi rahasia dan data bisnis PT. Pertamina Pedeve Indonesia untuk kepentingan pribadi atau dengan cara yang merugikan kepentingan PT. Pertamina Pedeve Indonesia;  
                    </li>
                    <li>
                        Mengungkapkan kepada individu atau organisasi manapun di luar PT. Pertamina Pedeve Indonesia setiap informasi, program, data keuangan, formula, proses atau "Know-How" rahasia milik PT. Pertamina Pedeve Indonesia atau yang dikembangkan oleh saya dalam memenuhi tanggung jawab saya terhadap PT. Pertamina Pedeve Indonesia.
                    </li>
                    </ol>
                </li>
                <li>
                    Saya juga ingin mengambil kesempatan ini untuk menyatakan bahwa saya mempunyai Potensial Konflik Kepentingan sebagai berikut :

                    <br>
                
                {{ $konflik }}
                
                </li>
                <li>
                    Saya mengerti bahwa apabila PT. Pertamina Pedeve Indonesia mengetahui bahwa saya memiliki benturan kepentingan dan sebelumnya saya tidak melaporkan hal tersebut kepada atasan atau pihak yang berwenang, saya dapat dikenakan tindakan disiplin yang tercantum dalam peraturan perusahaan PT. Pertamina Pedeve Indonesia. Saya juga sudah membaca dan memahami peraturan tsb.
                </li>
                </ol>
                
                    Demikian Deklarasi ini saya buat dengan sebenarnya dalam keadaan sehat baik jasmani dan rohani dan tanpa ada paksaan dari pihak manapun.
            </p>

            <br>
            <br>
            <br>
            <br>
            
            {{ ucwords($tempat).', '.$tanggal_efektif }}
            <br>
            <br>
            <br>
            <br>
            <br>
            {{ Auth::user()->pekerja->nama.' - '.Auth::user()->fungsi_jabatan->nama }}
        </div>
    </body>
</html>