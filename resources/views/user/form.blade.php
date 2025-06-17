<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" class="modal-content">
            @csrf
            @method('post')

            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control" required data-match="#password">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fa fa-save me-1"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>
