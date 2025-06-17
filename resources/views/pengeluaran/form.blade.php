<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="deskripsi" class="col-sm-3 col-form-label">Jenis Pengeluaran</label>
                        <div class="col-sm-9">
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                                required autofocus>
                            <span class="help-blobk with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
                        <div class="col-sm-9">
                            <input type="number" name="nominal" id="nominal" class="form-control"
                                required>
                            <span class="help-blobk with-errors"></span>
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
