@extends('layouts.master')

@section('title', 'Produk')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Produk</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Produk</h5>

                <div class="d-flex gap-2 ms-auto flex-wrap">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-sm btn-primary">
                        <i class="bx bx-plus-circle"></i> Tambah
                    </button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-sm btn-danger">
                        <i class="bx bx-trash"></i> Hapus
                    </button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-sm btn-info">
                        <i class="bx bx-printer"></i> Cetak Barcode
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-bordered table-hover w-100 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" name="select_all" id="select_all">
                                    </th>
                                    <th width="5%" class="text-center">No</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Merk</th>
                                    <th class="text-center">Harga Beli</th>
                                    <th class="text-center">Harga Jual</th>
                                    <th class="text-center">Diskon</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Expired</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @includeIf('produk.form')
@endsection
@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                stateSave: false,
                ajax: {
                    url: '{{ route('produk.data') }}',
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'merk'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'stok'
                    },
                    {
                        data: 'satuan'
                    },
                    {
                        data: 'expired'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false,
                        className: 'text-center'
                    },
                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .fail(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Tidak dapat menyimpan data.'
                            });
                        });
                }
            });

            $('[name=select_all]').on('click', function() {
                $(':checkbox').prop('checked', this.checked);
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_produk]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama_produk]').val(response.nama_produk);
                    $('#modal-form [name=kode_produk]').val(response.kode_produk);
                    $('#modal-form [name=id_kategori]').val(response.id_kategori);
                    $('#modal-form [name=merk]').val(response.merk);
                    $('#modal-form [name=harga_beli]').val(response.harga_beli);
                    $('#modal-form [name=harga_jual]').val(response.harga_jual);
                    $('#modal-form [name=diskon]').val(response.diskon);
                    $('#modal-form [name=stok]').val(response.stok);
                    $('#modal-form [name=satuan]').val(response.satuan);
                    $('#modal-form [name=expired]').val(response.expired);
                })
                .fail(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menampilkan data.'
                    });
                });
        }

        function deleteData(url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'delete'
                        })
                        .done((response) => {
                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .fail((errors) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Tidak dapat menghapus data.'
                            });
                        });
                }
            });
        }

        function deleteSelected(url) {
            if ($('input:checked').length > 1) {
                Swal.fire({
                    title: 'Yakin ingin menghapus semua data terpilih?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(url, $('.form-produk').serialize())
                            .done(() => {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            })
                            .fail(() => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Tidak dapat menghapus data.'
                                });
                            });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Data',
                    text: 'Pilih minimal 2 data untuk dihapus.'
                });
            }
        }

        function cetakBarcode(url) {
            const selectedCount = $('input:checked').length;

            if (selectedCount < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Data',
                    text: 'Pilih data yang akan dicetak.'
                });
            } else if (selectedCount < 3) {
                Swal.fire({
                    icon: 'info',
                    title: 'Minimal 3 Data',
                    text: 'Pilih minimal 3 data untuk dicetak.'
                });
            } else {
                $('.form-produk')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit();
            }
        }
    </script>
@endpush
