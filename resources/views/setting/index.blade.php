@extends('layouts.master')

@section('title', 'Pengaturan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Pengaturan Operasional</h4>
            </div>
            <form action="{{ route('setting.update') }}" method="post" class="form-setting" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <i class="fa fa-check me-2"></i> Perubahan berhasil disimpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="mb-3">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="path_logo" class="form-label">Logo Perusahaan</label>
                        <input type="file" class="form-control" id="path_logo" name="path_logo"
                            onchange="preview('.tampil-logo', this.files[0])">
                        <div class="mt-2 tampil-logo"></div>
                    </div>

                    <div class="mb-3">
                        <label for="path_kartu_member" class="form-label">Kartu Member</label>
                        <input type="file" class="form-control" id="path_kartu_member" name="path_kartu_member"
                            onchange="preview('.tampil-kartu-member', this.files[0], 300)">
                        <div class="mt-2 tampil-kartu-member"></div>
                    </div>

                    <div class="mb-3">
                        <label for="diskon" class="form-label">Diskon</label>
                        <input type="number" class="form-control" id="diskon" name="diskon" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_nota" class="form-label">Tipe Nota</label>
                        <select class="form-control" id="tipe_nota" name="tipe_nota" required>
                            <option value="1">Nota Kecil</option>
                            <option value="2">Nota Besar</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(function () {
        showData(); // Load data saat halaman dibuka

        $('.alert').hide(); // Hide alert default bootstrap (jika belum dihapus)

        // Tangani submit form dengan ajax
        $('.form-setting').validator().on('submit', function (e) {
            if (!e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    showData(); // reload tampilan data
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pengaturan berhasil disimpan.',
                        timer: 2500,
                        showConfirmButton: false
                    });
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menyimpan data.'
                    });
                });
            }
        });
    });

    function showData() {
        $.get('{{ route('setting.show') }}')
            .done(response => {
                $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                $('[name=telepon]').val(response.telepon);
                $('[name=alamat]').val(response.alamat);
                $('[name=diskon]').val(response.diskon);
                $('[name=tipe_nota]').val(response.tipe_nota);

                $('title').text(`${response.nama_perusahaan} | Pengaturan`);

                // Inisialisasi logo mini dan besar
                let words = response.nama_perusahaan.split(' ');
                let singkatan = words.map(w => w.charAt(0)).join('');
                $('.logo-mini').text(singkatan);
                $('.logo-lg').text(response.nama_perusahaan);

                $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
                $('.tampil-kartu-member').html(`<img src="{{ url('/') }}${response.path_kartu_member}" width="300">`);
                $('[rel=icon]').attr('href', `{{ url('/') }}${response.path_logo}`);
            })
            .fail(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menampilkan data.'
                });
            });
    }

    function preview(selector, file, width = 200) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $(selector).html(`<img src="${e.target.result}" width="${width}">`);
        }
        reader.readAsDataURL(file);
    }
</script>
@endpush

