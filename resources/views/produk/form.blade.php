<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Nama Produk -->
                    <div class="mb-3 row">
                        <label for="nama_produk" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" required autofocus>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3 row">
                        <label for="id_kategori" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="" hidden>Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Merk -->
                    <div class="mb-3 row">
                        <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                        <div class="col-sm-9">
                            <input type="text" name="merk" id="merk" class="form-control" required>
                        </div>
                    </div>

                    <!-- Harga Beli -->
                    <div class="mb-3 row">
                        <label for="harga_beli" class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                        </div>
                    </div>

                    <!-- Harga Jual -->
                    <div class="mb-3 row">
                        <label for="harga_jual" class="col-sm-3 col-form-label">Harga Jual</label>
                        <div class="col-sm-9">
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                        </div>
                    </div>

                    <!-- Diskon -->
                    <div class="mb-3 row">
                        <label for="diskon" class="col-sm-3 col-form-label">Diskon</label>
                        <div class="col-sm-9">
                            <input type="number" name="diskon" id="diskon" class="form-control" value="0" required>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div class="mb-3 row">
                        <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                        <div class="col-sm-9">
                            <input type="number" name="stok" id="stok" class="form-control" required value="0">
                        </div>
                    </div>

                    <!-- Satuan -->
                    <div class="mb-3 row">
                        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <select name="satuan" id="satuan" class="form-control" required>
                                <option value="" hidden>Pilih Satuan</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Pil">Pil</option>
                                <option value="Botol">Botol</option>
                                <option value="Mililiter">Mililiter (ml)</option>
                                <option value="Lembar">Lembar</option>
                            </select>
                        </div>
                    </div>

                    <!-- Expired -->
                    <div class="mb-3 row">
                        <label for="expired" class="col-sm-3 col-form-label">Tanggal Expired</label>
                        <div class="col-sm-9">
                            <input type="date" name="expired" id="expired" class="form-control @error('expired') is-invalid @enderror" value="{{ old('expired') }}" min="{{ date('Y-m-d') }}" required>
                            @error('expired')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
