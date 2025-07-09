@extends('layouts.master')

@section('title', 'Edit Profil')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>

        {{-- Card --}}
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4 fw-bold">Profile Details</h5>
                <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="alert-success">
                    <strong>Berhasil!</strong> Perubahan berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.update_profil') }}" method="POST" enctype="multipart/form-data"
                    id="form-profil">
                    @csrf

                    {{-- Foto Profil --}}
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ url($profil->foto ?? asset('image/user.jpg')) }}" class="rounded" width="80" height="80"
                            id="img-preview">
                        <div class="ms-3">
                            <label class="btn btn-primary btn-sm mb-1">
                                Upload new photo
                                <input type="file" name="foto" id="foto" class="d-none"
                                    onchange="preview('#img-preview', this.files[0])">
                            </label>
                            <button type="button" class="btn btn-outline-secondary btn-sm mb-1" onclick="resetImage()">Reset</button>
                            <div><small class="text-muted">Allowed JPG, PNG. Max size of 800KB</small></div>
                        </div>
                    </div>

                    {{-- Form Input --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" required
                            value="{{ $profil->name }}">
                    </div>

                    <div class="mb-3">
                        <label for="old_password" class="form-label">Password Lama</label>
                        <input type="password" name="old_password" id="old_password" class="form-control" minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const originalImg = '{{ url($profil->foto ?? asset('image/user.jpg')) }}';

    function preview(selector, file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector(selector).src = e.target.result;
        }
        reader.readAsDataURL(file);
    }

    function resetImage() {
        $('#img-preview').attr('src', originalImg);
        $('#foto').val('');
    }

    $(function() {
        // Set field password baru & konfirmasi wajib jika password lama diisi
        $('#old_password').on('keyup', function() {
            const isFilled = $(this).val() !== "";
            $('#password, #password_confirmation').attr('required', isFilled);
        });

        // Submit form profil via AJAX
        $('#form-profil').on('submit', function(e) {
            e.preventDefault();

            const form = $(this)[0];
            const data = new FormData(form);

            $.ajax({
                url: form.action,
                type: form.method,
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#name').val(response.name);
                    $('#img-preview').attr('src', `{{ url('/') }}/${response.foto}`);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Profil berhasil diperbarui',
                        timer: 2500,
                        showConfirmButton: false
                    });
                },
                error: function(errors) {
                    if (errors.status === 422) {
                        let message = '';
                        const res = errors.responseJSON.errors;
                        for (const key in res) {
                            if (res.hasOwnProperty(key)) {
                                message += `${res[key][0]}<br>`;
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: message,
                            confirmButtonColor: '#d33'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });
        });
    });
</script>
@endpush

