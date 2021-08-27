<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-plus-1 text-primary"></i>
        </span>
        <h3 class="card-label">
            Detail Pertanggungjawaban Panjar Dinas
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <div class="">
                <a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.create') }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
                    </span>
                </a>
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-xl-12">
            <table class="table table-bordered" id="kt_table">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>NO</th>
                        <th>NOPEK</th>
                        <th>NAMA</th>
                        <th>GOL</th>
                        <th>JABATAN</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>        
</div>