@extends('layouts.master')

@section('title', 'Detail Pembelian')

@push('css')
    <style>
        .tampil-bayar {
            font-size: 3.5rem;
            text-align: center;
            padding: 15px;
            color: white;
            background-color: #6366f1;
            border-radius: 10px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
            border-radius: 6px;
            margin-top: 8px;
            color: #666;
            font-style: italic;
        }

        .table-pembelian tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('pembelian.index') }}">Pembelian</a>
                </li>
                <li class="breadcrumb-item active">Detail Pembelian</li>
            </ol>
        </nav>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Supplier</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="100px">Supplier</th>
                        <td>: {{ $supplier->nama }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>: {{ $supplier->telepon }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $supplier->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form class="form-produk mb-4">
                    @csrf
                    <div class="row align-items-center">
                        <label for="kode_produk" class="col-sm-2 col-form-label">Kode Produk</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="text" name="kode_produk" id="kode_produk" class="form-control">
                                <button type="button" onclick="tampilProduk()" class="btn btn-info"><i
                                        class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-pembelian w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center" width="10%">Jumlah</th>
                                <th class="text-center">Subtotal</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary text-white rounded p-3 mb-2"></div>
                        <div class="tampil-terbilang rounded"></div>
                    </div>

                    <div class="col-lg-4">
                        <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                            @csrf
                            <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="mb-3">
                                <label for="totalrp" class="form-label">Total</label>
                                <input type="text" id="totalrp" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="diskon" class="form-label">Diskon</label>
                                <input type="number" name="diskon" id="diskon" class="form-control"
                                    value="{{ $diskon }}">
                            </div>
                            <div class="mb-3">
                                <label for="bayarrp" class="form-label">Bayar</label>
                                <input type="text" id="bayarrp" class="form-control" readonly>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-simpan"><i class="bx bx-save"></i> Simpan
                                    Transaksi</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @includeIf('pembelian_detail.produk')
    </div>
@endsection



@push('scripts')
    <script>
        let table, table2;

        $(function() {
            table = $('.table-pembelian').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: {
                        url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
                    },
                    columns: [{
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
                            data: 'harga_beli'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'subtotal'
                        },
                        {
                            data: 'aksi',
                            searchable: false,
                            sortable: false,
                            className: 'text-center'
                        },
                    ],
                    dom: 'Brt',
                    bSort: false,
                })
                .on('draw.dt', function() {
                    loadForm($('#diskon').val());
                });
            table2 = $('.table-produk').DataTable()

            $(document).on('input', '.quantity', function() {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());

                if (jumlah < 1) {
                    $(this).val(1);
                    alert('Jumlah tidak boleh kurang dari 1');
                    return;
                }

                if (jumlah > 10000) {
                    $(this).val(10000);
                    alert('Jumlah tidak boleh lebih dari 10000');
                    return;
                }

                $.post(`{{ url('/pembelian_detail') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        $(this).on('mouseout', function() {
                            table.ajax.reload(() => loadForm($('#diskon').val()));
                        });
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            });

            $('.btn-simpan').on('click', function(e) {
                e.preventDefault();

                let total = parseInt($('#total').val()) || 0;

                if (total <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Transaksi Kosong!',
                        text: 'Silakan tambahkan produk terlebih dahulu sebelum menyimpan.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $('.form-pembelian').submit();
            });

        });

        function tampilProduk() {
            $('#modal-produk').modal('show');
        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function pilihProduk(id, kode) {
            $('#id_produk').val(id);
            $('#kode_produk').val(kode);
            hideProduk();
            tambahProduk();
        }

        function tambahProduk() {
            $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
                .done(response => {
                    $('#kode_produk').focus();
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        }

        function loadForm(diskon = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val('Rp. ' + response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }
    </script>
@endpush
