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
                    <h4 class="card-title mb-3">Data Pembelian Barang</h4>
                    <button type="button" class="btn btn-info" onclick="form_data(null,'tambah')">Tambah</button>
                </div>
                <table id="tableData" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nomor Pembelian</th>
                            <th>Tanggal Beli</th>
                            <th>Status</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
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
<link rel="stylesheet" href="{{ asset('dist/css/mine/spinner-navigation.css') }}">
@endpush
@push('addon-style')
<style>
    .existing-row {
        background-color: #ffeeba;
    }
</style>
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
<script src="{{ asset('dist/js/mine/spinner-navigation.js') }}"></script>
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
                url: "{{ route('purchase') }}",
                data: function (d) {
                    d.from_date = $('input[name="tanggal"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.to_date = $('input[name="tanggal"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [
                {data: 'purchase_reff', name: 'purchase_reff', className: 'text-center'},
                {data: 'purchase_date', name: 'purchase_date', className: 'text-center'},
                {data: 'status', name: 'status', className: 'text-center'},
                {data: 'supplier_name', name: 'supplier_name'},
                {data: 'total_payment', name: 'total_payment', className: 'text-right'},
                {data: 'payment', name: 'payment', className: 'text-center'},
                {data: 'opsi', name: 'opsi', className: 'text-center', orderable: false, searchable: false},
            ]
        });

        $(".filter").click(function(){
            table.draw();
        });
    });
</script>
<script>
    function selectWare(selectedValue=null) {
        var selectWarehouse = $('#warehouse_id');
        $.ajax({
            type: "get",
            url: "{{ route('formContentPurchase') }}",
            dataType: "json",
            success: function (response) {
                var data = response.warehouse;
                selectWarehouse.append(`<option value="">.:: Pilih Gudang ::.</option>`)
                $.each(data, function (i, v) {
                    if(selectedValue){
                        if(v.id == selectedValue){
                            selectWarehouse.append(`<option value="${v.id}" selected>${v.warehouse_name}</option>`)
                        }else{
                            selectWarehouse.append(`<option value="${v.id}">${v.warehouse_name}</option>`)
                        }
                    }else{
                        selectWarehouse.append(`<option value="${v.id}">${v.warehouse_name}</option>`)
                    }
                });
            }
        });
        selectWarehouse.select2({
            width: "100%"
        })
    }
    function selectSupp(selectedValue=null) {
        var selectSupplier = $('#supplier_id');
        $.ajax({
            type: "get",
            url: "{{ route('formContentPurchase') }}",
            dataType: "json",
            success: function (response) {
                var data = response.supplier;
                selectSupplier.append(`<option value="">.:: Pilih Supplier ::.</option>`)
                $.each(data, function (i, v) {
                    if(selectedValue){
                        if(v.id == selectedValue){
                            selectSupplier.append(`<option value="${v.id}" selected>${v.supplier_name}</option>`)
                        }else{
                            selectSupplier.append(`<option value="${v.id}">${v.supplier_name}</option>`)
                        }
                    }else{
                        selectSupplier.append(`<option value="${v.id}">${v.supplier_name}</option>`)
                    }
                });
            }
        });
        selectSupplier.select2({
            width: "100%"
        })
    }
    function selectProd(selectedValue=null) {
        $('#product_id').select2({
            width: "100%",
            ajax: {
                type: "get",
                url: "{{ route('formContentPurchase') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.product, function (product) {
                            return {
                                id: product.id,
                                text: product.product_name
                            };
                        })
                    };
                },
                cache: true
            },
            placeholder: '.:: Cari Barang ::.',
            //   minimumInputLength: 1,
        })
    }

    function reset_form(){
        $('#id').val('')
        $('#purchase_date').val('')
        $('#warehouse_id').empty().trigger('change')
        $('#supplier_id').empty().trigger('change')
        $('#product_id').empty().trigger('change')
        $('#description').val('')
    }

    function form_save() {
        $('.forms-purchase').submit(function(e){
            e.preventDefault()
            var data = $(this).serialize();
            $.ajax({
                type: "post",
                url: "{{ route('savePurchase') }}",
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
        $('#purchase_date').val(data.purchase_date)
        selectWare(data.warehouse_id)
        selectSupp(data.supplier_id)
        $('#description').val(data.description)
    }

    function tambah_baris_barang() {
        $('#product_id').on('select2:select', function (e) {
            var selectedProduct = e.params.data;
            // Cek apakah produk sudah ada dalam tabel
            var existingRow = $('#listSelectedProduct tbody').find('tr[data-product-id="' + selectedProduct.id + '"]');
            if (existingRow.length > 0) {
                existingRow.addClass('existing-row');
                setTimeout(function() {
                    existingRow.removeClass('existing-row');
                }, 1000); // Menghilangkan tampilan existing-row setelah 1 detik
                return;
            }
            // Tambahkan baris baru ke dalam tabel
            var newRow = `
                <tr data-product-id="${selectedProduct.id}">
                    <td>
                        <input type="hidden" name="product_id[]" value="${selectedProduct.id}">
                        ${selectedProduct.text}
                    </td>
                    <td>
                        <div class="spinner">
                            <button type="button" class="minus spin btn btn-secondary">-</button>
                            <input type="number" name="purchase_quantity[]" class="form-control input-number" id="purchase_quantity${selectedProduct.id}" value="1">
                            <button type="button" class="plus spin btn btn-primary">+</button>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="purchase_price_per_unit[]" class="form-control purchase_price_per_unit" id="purchase_price_per_unit${selectedProduct.id}" style="text-align:right;">
                    </td>
                    <td><input readonly type="text" name="subtotal[]" class="form-control subtotal" id="subtotal${selectedProduct.id}" style="text-align:right;"></td>
                    <td>
                        <button type="button" class="btn btn-danger delete-row"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            `;
            $('#listSelectedProduct tbody').append(newRow);
            $('.spinner').spinnerNavigation()

            $(`tr[data-product-id=${selectedProduct.id}] .spin`).on('click keydown keyup',function(){
                hitungSubTotal(selectedProduct.id)
            })
            $(`tr[data-product-id=${selectedProduct.id}] .purchase_price_per_unit`).on('keydown keyup',function(){
                var inputValue = $(this).val();
                var formattedValue = formatNumber(inputValue);
                $(this).val(formattedValue);

                hitungSubTotal(selectedProduct.id)
            })

        });
    }

    function hitungSubTotal(idRow){
        $('#subtotal'+idRow).val('loading...')
        let purchase_quantity = $('#purchase_quantity'+idRow).val()
        let purchase_price_per_unit = $('#purchase_price_per_unit'+idRow).val()
        $.post("{{ route('hitungSubTotal') }}",{
            purchase_quantity: purchase_quantity,
            purchase_price_per_unit:purchase_price_per_unit,
        }).done(function(data){
            $('#subtotal'+idRow).val(data);
            hitungTotal()
        })
    }
    function hitungTotal() {
        $('#grandTotal').val('<i class="fas fa-spinner fa-spin"></i>')
        var subtotals = [];
        $('.subtotal').each(function() {
            subtotals.push($(this).val().replace(/\./g, ""));
        });
        $.post("{{ route('hitungTotal') }}",{
            subtotals: subtotals,
        }).done(function(data){
            $('#grandTotal').text(data.total);
        }).fail(function(xhr, status, error){

        })
    }

    function formatNumber(value) {
        return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function hapus_baris_barang() {
        $('#listSelectedProduct').on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            hitungTotal()
        });
    }


    function form_data(id=nul,action='edit') {
        $('.main-page').hide()
        $('.preload-page').show()
        if(action == 'edit'){
            $.get("{{ route('getDataPurchase') }}",{id:id})
            .done(function(result){
                if(result.status == 'success'){
                    var data = result.data;
                    $('.other-page').html(result.content)
                    $('#form-title').text('Edit Pembelian Barang')
                    $('.forms-purchase form-control').removeAttr('disabled')

                    isi_form_data(data)
                    form_save()

                    $('.preload-page').hide()
                    $('.other-page').show()
                }else{
                    Swal.fire ( "Terjadi Kesalahan" ,  "Data tidak ditemukan" ,  "error" )
                }
            })
        }else if(action == 'tambah'){
            $.get("{{ route('formContentPurchase') }}")
            .done(function(result){
                $('.other-page').html(result.content)
                $('#form-title').text('Buat Pembelian Barang')
                $('.forms-purchase form-control').removeAttr('disabled')
                reset_form()

                selectWare()
                selectSupp()
                selectProd()

                tambah_baris_barang()
                hapus_baris_barang()

                form_save()

                $('.preload-page').hide()
                $('.other-page').show()
            })
        }else if(action == 'lihat'){
            $.get("{{ route('getDataPurchase') }}",{id:id})
            .done(function(result){
                if(result.status == 'success'){
                    var data = result.data;
                    $('.other-page').html(result.content)
                    $('#form-title').text('Detail Pembelian Barang')
                    $('.forms-purchase .form-control').prop('disabled',true)
                    $('.btn-simpan').hide()

                    isi_form_data(data)

                    $('.preload-page').hide()
                    $('.other-page').show()
                }else{
                    Swal.fire ( "Terjadi Kesalahan" ,  "Data tidak ditemukan" ,  "error" )
                }
            })
        }
    }

    function hide_form_data(){
        reset_form()
        $('.other-page').hide()
        $('.preload-page').show()
        $('#tableData').DataTable().ajax.reload();
        $('.preload-page').hide()
        $('.main-page').show()
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
                    url: "{{ route('deletePurchase') }}",
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
