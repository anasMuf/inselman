<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="form-title"></h4>
        </div>
        <div class="card-body">
            <form class="forms-purchase">
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="purchase_date">Tanggal Pembelian</label>
                            <input type="date" name="purchase_date" class="form-control" id="purchase_date" placeholder="Tulis Tanggal Pembelian">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="warehouse_id">Untuk Gudang</label>
                            <select name="warehouse_id" class="form-control" id="warehouse_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="supplier_id">Dari Supplier</label>
                            <select name="supplier_id" class="form-control" id="supplier_id">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="product_id">Cari Barang</label>
                            <select name="product_id" class="form-control" id="product_id"></select>
                        </div>
                        <p>Tidak menemukan barang yang dicari? tambahkan barang <a href="{{ route('product') }}">disini</a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="listSelectedProduct">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Nama Barang</th>
                                    <th style="width: 20%">Jumlah</th>
                                    <th style="width: 20%">Harga Satuan</th>
                                    <th style="width: 20%">Subtotal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr class="text-right">
                                    <th colspan="3">Total</th>
                                    <th id="grandTotal"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Tambahkan Keterangan"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="hide_form_data()">Kembali</button>
                <button type="button" class="btn btn-primary me-2 btn-next" data-toggle="modal" data-target="#exampleModal">Lanjutkan</button>
                {{-- <button type="submit" class="btn btn-primary me-2 btn-simpan">Simpan</button> --}}
            </form>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
