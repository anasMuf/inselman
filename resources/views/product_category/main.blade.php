@extends('layouts.app')

@section('content')
<div class="row main-page">

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12">
                        <label>Export data ke:</label>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-success text-white">Excel</button>
                                <button type="button" class="btn btn-danger text-white">PDF</button>
                                <button type="button" class="btn btn-warning text-white">Print</button>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <form id="f-cari" class="form-inline">
                                    <input type="text" name="tanggal" class="form-control mr-1" style="width: 392px;">
                                    <div class="btn btn-success filter">Cari</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">

        <div class="card">
            <div class="card-body">
                <div class="mb-3 d-flex flex-wrap justify-content-between">
                    <h4 class="card-title mb-3">Data Kategori Barang</h4>
                    <button type="button" class="btn btn-info" onclick="form_data(null,'tambah')">Tambah</button>
                </div>
                <table id="tableData" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="row preload-page mt-3">
    <div class="col-xl-12 d-flex justify-content-center">
        <img src="{{ asset('dist/img/preload.gif') }}" alt="">
    </div>
</div>

<div class="row other-page mt-3">

</div>
@endsection

@push('prepand-style')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@push('addon-script')

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

<!-- moment -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.preload-page').hide()
        $('.other-page').hide()

        $('input[name="tanggal"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                weekLabel: "M",
                daysOfWeek: ["Mg","Sen","Sel","Rab","Kam","Jum","Sab"],
                monthNames: ["Januari","Februari","Maret","April","Mei","Juni","Juli","Augustus","September","Oktober","November","Desember"],
            },
            startDate: moment().subtract(1, 'M'),
            endDate: moment()
        })

        var table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('product_category') }}",
                data: function (d) {
                    d.from_date = $('input[name="tanggal"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.to_date = $('input[name="tanggal"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [
                // {data: 'no', name: 'no', searchable: false},
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false},
                {data: 'category_name', name: 'category_name'},
                {data: 'opsi', name: 'opsi', className: 'text-center', orderable: false, searchable: false},
            ]
        });

        $(".filter").click(function(){
            table.draw();
        });
    });
</script>
<script>

    function reset_form(){
        $('#id').val('')
        $('#category_name').val('')
    }

    function form_save() {
        $('.forms-product-category').submit(function(e){
            e.preventDefault()
            var data = $(this).serialize();
            $.ajax({
                type: "post",
                url: "{{ route('saveProductCategory') }}",
                data: data,
                dataType: "json",
                success: function (result) {
                    if(result.status == 'success'){
                        Swal.fire ( "Berhasil" ,  "Data tersimpan" ,  "success" )
                        hide_form_data()
                        $('#tableData').DataTable().ajax.reload()
                    }else{
                        var message = '';
                        $.each(result.message_validation, function (i,msg) {
                            message += msg[0]+', \n';
                        })
                        Swal.fire ( result.message , message, 'warning' )
                    }
                },
                error: function(xhr, status, error){
                    Swal.fire ( "Terjadi Kesalahan" ,  "Data tidak tersimpan "+error ,  "error" )
                }
            });
        })
    }

    function isi_form_data(data){
        $('#id').val(data.id)
        $('#category_name').val(data.category_name)
    }

    function form_data(id=nul,action='edit') {
        $('.main-page').hide()
        $('.preload-page').show()
        if(action == 'edit'){
            $.get("{{ route('getDataProductCategory') }}",{id:id})
            .done(function(result){
                if(result.status == 'success'){
                    var data = result.data;
                    $('.preload-page').hide()
                    $('.other-page').show()
                    $('.other-page').html(result.content)
                    $('#form-title').text('Edit Data Kategori Barang')
                    $('.forms-product-category form-control').removeAttr('disabled')

                    isi_form_data(data)
                    form_save()
                }else{
                    Swal.fire ( "Terjadi Kesalahan" ,  "Data tidak ditemukan" ,  "error" )
                }
            })
        }else if(action == 'tambah'){
            $.get("{{ route('formContentProductCategory') }}")
            .done(function(result){
                $('.preload-page').hide()
                $('.other-page').show()
                $('.other-page').html(result.content)
                $('#form-title').text('Tambah Data Kategori Barang')
                $('.forms-product-category form-control').removeAttr('disabled')
                reset_form()

                form_save()
            })
        }else if(action == 'lihat'){
            $.get("{{ route('getDataProductCategory') }}",{id:id})
            .done(function(result){
                if(result.status == 'success'){
                    var data = result.data;
                    $('.preload-page').hide()
                    $('.other-page').show()
                    $('.other-page').html(result.content)
                    $('#form-title').text('Detail Data Kategori Barang')
                    $('.forms-product-category .form-control').prop('disabled',true)
                    $('.btn-simpan').hide()

                    isi_form_data(data)
                }else{
                    Swal.fire ( "Terjadi Kesalahan" ,  "Data tidak ditemukan" ,  "error" )
                }
            })
        }
    }

    function hide_form_data(){
        $('.other-page').hide()
        $('.preload-page').hide()
        $('.main-page').show()
        reset_form()
    }

    function hapus(id){
        const customSwal = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger mr-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        })

        customSwal.fire({
            title: "Data akan dihapus!",
            text: "Apakah Anda yakin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "delete",
                    url: "{{ route('deleteProductCategory') }}",
                    data: {id:id},
                    dataType: "json",
                    success: function(result) {
                        if (result.status == 'success') {
                            Swal.fire("Berhasil", "Data berhasil dihapus", "success");
                            $('#tableData').DataTable().ajax.reload();
                        } else {
                            Swal.fire("Gagal", "Data gagal dihapus", "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Terjadi Kesalahan", "Data gagal dihapus", "error");
                    }
                });
            }
        });
    }

</script>
@endpush
