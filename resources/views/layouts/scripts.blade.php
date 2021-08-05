<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>

<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
{{-- <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/custom/datatables/dataTables.rowsGroup.js') }}" type="text/javascript"></script>
<!--end::Page Vendors-->

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page)-->
{{-- <script src="{{ asset('assets/js/pages/widgets.js') }}"></script> --}}
<!--end::Page Scripts-->
<script type="text/javascript">
    
    function swalAlertInit(text) {
        Swal.fire({
            icon: 'warning',
            timer: 2000,
            title: 'Oops...',
            text: 'Tandai baris yang ingin di' + text
        });
    }

    function swalSuccessInit(title) {
        Swal.fire({
            icon : 'success',
            title: title,
            text : 'Berhasil',
            timer: 2000
        });
    }
    
    $( document ).ready(function() {
        $(".sidebar-switch").click(function() {
            if($(this).is(":checked")) {
                $("#kt_body").removeClass('aside-minimize',300);
            } else {
                $("#kt_body").addClass('aside-minimize',200);
            }
        });

        $('.money').mask('000,000,000,000,000.00', {
            reverse: true
        });

        $('.tahun').mask('0000', {
            reverse: true
        });

        $('.select2').select2().on('change', function() {
            $(this).valid();
        });

        $('#kt_table tbody').on( 'click', 'tr', function (event) {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            } else {
                $('#kt_table tbody tr.selected').removeClass('selected');
                // $(':radio', this).trigger('click');
                if (event.target.type !== 'radio') {
                    $(':radio', this).trigger('click');
                }
                $(this).addClass('selected');
            }
        });

        (function ($, DataTable) {
            // Datatable global configuration
            $.extend(true, DataTable.defaults, {
                ordering: false,
                searching : false,
                language: {
                    // url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json",
                    "sEmptyTable":	 "Tidak ada data yang tersedia pada tabel ini",
                    "sProcessing":   '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Sedang memproses...',
                    "sLengthMenu":   "Tampilkan _MENU_ entri",
                    "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                    "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                    "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Cari:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Pertama",
                        "sPrevious": "Sebelumnya",
                        "sNext":     "Selanjutnya",
                        "sLast":     "Terakhir"
                    }
                },
            });

        })(jQuery, jQuery.fn.dataTable);

        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                }

                return a + b;
            }, 0 );
        });

        // Restricts input for the set of matched elements to the given inputFilter function.
        (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
            });
        };
        }(jQuery));

        $.fn.datepicker.dates['id'] = {
            days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            daysMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            today: "Hari Ini",
            clear: "Clear",
            format: "mm/dd/yyyy",
            titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
            weekStart: 0
        };

        $('#nopek').select2().on('change', function() {
            var id = $(this).val();
            var url = '{{ route("modul_sdm_payroll.master_pegawai.show.json", ":pekerja") }}';
            // go to page edit
            url = url.replace(':pekerja',id);
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    _token:"{{ csrf_token() }}"		
                },
                success: function(response){
                    // console.log(response);
                    // isi jabatan
                    $('#jabatan').val(response.jabatan).trigger('change');
                    // isi golongan
                    $('#golongan').val(response.golongan);
                    console.log(response.pekerja.noktp);
                },
                error: function () {
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });
        });

        $('#nopek_detail').select2().on('change', function() {
            // console.log($(this).val());
            var id = $(this).val().split('-')[0];
            // var id = $('#nopek_detail').val().split('-')[0];
            var url = '{{ route("modul_sdm_payroll.master_pegawai.show.json", ":pekerja") }}';
            // go to page edit
            url = url.replace(':pekerja',id);
            if(id != ''){
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token:"{{ csrf_token() }}"		
                    },
                    success: function(response){
                        // console.log(response);
                        // isi jabatan
                        $('#jabatan_detail').val(response.jabatan).trigger('change');
                        // isi golongan
                        $('#golongan_detail').val(response.golongan);
                    },
                    error: function () {
                        alert("Terjadi kesalahan, coba lagi nanti");
                    }
                });
            }
        });

        $('#no_panjar').select2().on('change', function() {
            var id = $(this).val().split('/').join('-');
            var url = '{{ route("modul_umum.perjalanan_dinas.show.json") }}';

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    id: id,
                    _token:"{{ csrf_token() }}"		
                },
                success: function(response){
                    console.log(response);
                    // isi keterangan
                    $('#keterangan').val(response.keterangan);
                    // isi jumlah
                    const jumlah = parseFloat(response.jum_panjar).toFixed(2);
                    $('#jumlah').data('jumlah', jumlah);
                    $('#jumlah').val(jumlah).trigger("change");
                    $('#nopek').val(response.nopek).trigger("change");
                },
                error: function () {
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });
        });

        $('#no_umk').select2().on('change', function(e) {
            var id  = $(this).val().split('/').join('-');
            var url = '{{ route("modul_umum.uang_muka_kerja.show.json") }}';

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    id: id,
                    _token:"{{ csrf_token() }}"		
                },
                success: function(response){
                    // isi keterangan
                    $('#keterangan').val(response.keterangan);
                    // isi jumlah
                    const jumlah = parseFloat(response.jumlah).toFixed(2);
                    $('#jumlah').data('jumlah', jumlah);
                    $('#jumlah').val(jumlah).trigger("change");
                    // $('#nopek').val(response.nopek).trigger("change");
                },
                error: function () {
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });
        });
    });
    
</script>

@stack('page-scripts')