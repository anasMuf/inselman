<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="form-title"></h4>
        </div>
        <div class="card-body">
            <form class="forms-warehouse">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="warehouse_code">Kode Gudang</label>
                    <input type="text" name="warehouse_code" class="form-control" id="warehouse_code" readonly>
                </div>
                <div class="form-group">
                    <label for="warehouse_name">Nama Gudang</label>
                    <input type="text" name="warehouse_name" class="form-control" id="warehouse_name" placeholder="Tulis Nama Gudang">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Tulis Deskripsi"></textarea>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" class="form-control" id="address" placeholder="Tulis Alamat"></textarea>
                </div>
                <div class="form-group">
                    <label for="contact">Kontak</label>
                    <input type="number" name="contact" class="form-control" id="contact" placeholder="Tulis Kontak">
                </div>
                <button type="button" class="btn btn-light" onclick="hide_form_data()">Kembali</button>
                <button type="submit" class="btn btn-primary me-2 btn-simpan">Simpan</button>
            </form>
        </div>
    </div>
</div>
