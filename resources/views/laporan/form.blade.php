<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('laporan.index') }}" method="get" data-toggle="validator" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Periode Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="tanggal_awal" class="col-sm-4 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-8">
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control datepicker"
                            value="{{ request('tanggal_awal') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="tanggal_akhir" class="col-sm-4 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-8">
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control datepicker"
                            value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            </div>
        </form>
    </div>
</div>
