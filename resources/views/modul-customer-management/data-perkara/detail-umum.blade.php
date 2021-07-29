<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Data Umum
            </h3>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="thead-light">
            @foreach($data_list as $key=>$data)
                <?php
                    $tgl = date_create($data->tgl_perkara);
                    $tanggal = date_format($tgl, 'd M Y');
                ?>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%">Tanggal</th><td>{{ $tanggal}}</td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%">Klasifikasi Perkara</th><td>{{ $data->klasifikasi_perkara}}</td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%">Nomer Perkara</th><td>{{ $data->no_perkara}}</td>
                </tr>
                @endforeach
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Penggugat</th>
                    <td>
                        <table width="100%">
                            <thead class="thead-light">
                                <tr style="text-align:center">
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($data_p as $key=>$data_peng)
                                @if($data_peng->status == '1')
                                    <tr>
                                        <td style="text-align:center">{{ $no++}}</td>
                                        <td>{{ $data_peng->nama }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Kuasa Hukum Penggugat</th>
                    <td>
                        <table width="100%">
                            <thead class="thead-light">
                                <tr style="text-align:center">
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                    <th>Nama Pihak</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php $no=1; ?>
                                    @foreach($data_ as $key=>$data_peng)
                                    <tr>
                                    @if($data_peng->status == '1')
                                        <td style="text-align:center">{{ $no++}}</td>
                                        <td>{{ $data_peng->nama_hakim == null ? '-': $data_peng->nama_hakim }}</td>
                                        <td>{{ $data_peng->nama }}</td>
                                    
                                    @endif
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Tergugat</th>
                    <td>
                        <table width="100%">
                            <thead class="thead-light">
                                <tr style="text-align:center">
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php $no=1; ?>
                                    @foreach($data_p as $key=>$data_ter)
                                    <tr>
                                    @if($data_ter->status == '2')
                                        <td style="text-align:center">{{ $no++}}</td>
                                        <td>{{ $data_ter->nama }}</td>
                                    @endif
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Kuasa Hukum Tergugat</th>
                    <td>
                        <table width="100%">
                            <thead class="thead-light">
                                <tr style="text-align:center">
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                    <th>Nama Pihak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($data_ as $key=>$data_ter)
                                <tr>
                                    @if($data_ter->status == '2')
                                        <td style="text-align:center">{{ $no++}}</td>
                                        <td>{{ $data_ter->nama_hakim == null ? '-': $data_ter->nama_hakim }}</td>
                                        <td>{{ $data_ter->nama }}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Turut Tergugat</th>
                    <td>
                        <table width="100%">
                            <thead class="thead-light">
                                <tr style="text-align:center">
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($data_p as $key=>$data_turut)
                                <tr>
                                @if($data_turut->status == '3')
                                    <td style="text-align:center">{{ $no++}}</td>
                                    <td>{{ $data_turut->nama }}</td>
                                @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Kuasa Hukum Turut Tergugat</th>
                    <td>
                        <table width="100%">
                            <thead class="thead-light">
                                <tr style="text-align:center">
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                    <th>Nama Pihak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($data_ as $key=>$data_turut)
                                <tr>
                                    @if($data_turut->status == '3')
                                        <td style="text-align:center">{{ $no}}</td>
                                        <td>{{ $data_turut->nama_hakim == null ? '-': $data_turut->nama_hakim }}</td>
                                        <td>{{ $data_turut->nama }}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                @foreach($data_list as $data)
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Ringkasan Perkara</th><td style="text-align:justify;">
                    <?php 
                        $pecah = explode("\r\n\r\n", nl2br($data->r_perkara));
            
                        // string kosong inisialisasi
                        $text = "";
                        
                        for ($i=0; $i<=count($pecah)-1; $i++)
                        {
                        $part = str_replace($pecah[$i], "<p>".$pecah[$i]."</p>", $pecah[$i]);
                        $text .= $part;
                        }
                        
                        echo $text;
                    ?>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Ringkasan Petitum</th><td style="text-align:justify;">
                    <?php 
                        $pecah = explode("\r\n\r\n", nl2br($data->r_patitum));
            
                        // string kosong inisialisasi
                        $text = "";
                        
                        for ($i=0; $i<=count($pecah)-1; $i++)
                        {
                        $part = str_replace($pecah[$i], "<p>".$pecah[$i]."</p>", $pecah[$i]);
                        $text .= $part;
                        }
                        
                        echo $text;
                    ?>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%" class="align-middle">Ringkasan Putusan</th><td style="text-align:justify;">
                    <?php 
                        $pecah = explode("\r\n\r\n", nl2br($data->r_putusan));
            
                        // string kosong inisialisasi
                        $text = "";
                        
                        for ($i=0; $i<=count($pecah)-1; $i++)
                        {
                        $part = str_replace($pecah[$i], "<p>".$pecah[$i]."</p>", $pecah[$i]);
                        $text .= $part;
                        }
                        
                        echo $text;
                    ?>
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#F4F6F6;" width="20%">Nilai Perkara</th><td>
                    <?php
                        if($data->ci == 2){
                            echo "US$. ".number_format($data->nilai_perkara*$data->rate,2);
                        }else{
                            echo "Rp.".number_format($data->nilai_perkara,2);
                        }
                    ?>
                    </td>
                </tr>
            @endforeach
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>