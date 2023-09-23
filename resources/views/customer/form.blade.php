<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="form-title"></h4>
        </div>
        <div class="card-body">
            <form class="forms-customer">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="name">Nama Pelanggan</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Tulis Nama Pelanggan">
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
