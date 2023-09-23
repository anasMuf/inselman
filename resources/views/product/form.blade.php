<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="form-title"></h4>
        </div>
        <div class="card-body">
            <form class="forms-product">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="product_name">Nama Barang</label>
                    <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Tulis Nama Barang">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Tulis Deskripsi"></textarea>
                </div>
                <div class="form-group">
                    <label for="product_category_id">Kategori</label>
                    <select name="product_category_id" class="form-control" id="product_category_id">
                    </select>
                </div>
                <div class="form-group">
                    <label for="selling_price">Harga Jual</label>
                    <input type="text" name="selling_price" class="form-control" id="selling_price" placeholder="Tulis Harga Jual">
                </div>
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" name="stock" class="form-control" id="stock" placeholder="Tulis Stok">
                </div>
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="number" name="sku" class="form-control" id="sku" placeholder="Tulis SKU">
                </div>
                <button type="button" class="btn btn-secondary" onclick="hide_form_data()">Kembali</button>
                <button type="submit" class="btn btn-primary me-2 btn-simpan">Simpan</button>
            </form>
        </div>
    </div>
</div>
