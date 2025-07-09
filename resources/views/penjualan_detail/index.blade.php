@extends('layouts.master')

@section('title', 'Transaksi Penjualan')

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

        .table-penjualan tbody tr:last-child {
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
                    <a href="{{ route('penjualan.index') }}">Penjualan</a>
                </li>
                <li class="breadcrumb-item active">Detail Penjualan</li>
            </ol>
        </nav>

        <div class="container">
            <div class="card shadow-sm p-4">
                <form class="form-produk mb-3">
                    @csrf
                    <div class="row mb-3">
                        <label for="kode_produk" class="col-lg-2 col-form-label">Kode Produk</label>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" name="kode_produk" id="kode_produk" class="form-control">
                                <button onclick="tampilProduk()" class="btn btn-info" type="button">
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-striped table-penjualan mb-4">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Harga</th>
                            <th width="10%" class="text-center">Jumlah</th>
                            <th class="text-center">Diskon</th>
                            <th class="text-center">Subtotal</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary text-white rounded p-3 text-center mb-2">Bayar : Rp. 0</div>
                        <div class="tampil-terbilang text-muted fst-italic"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.simpan') }}" method="POST" class="form-penjualan">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total" value="0">
                            <input type="hidden" name="total_item" id="total_item" value="0">
                            <input type="hidden" name="bayar" id="bayar" value="0">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="mb-3">
                                <label for="totalrp" class="form-label">Total</label>
                                <input type="text" id="totalrp" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="kode_member" class="form-label">Member</label>
                                <div class="input-group">
                                    <input type="text" id="kode_member" class="form-control"
                                        value="{{ $memberSelected->kode_member }}">
                                    <button onclick="tampilMember()" class="btn btn-info" type="button">
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="diskon" class="form-label">Diskon</label>
                                <input type="number" name="diskon" id="diskon" class="form-control"
                                    value="{{ !empty($memberSelected->id_member) ? $diskon : 0 }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="bayarrp" class="form-label">Bayar</label>
                                <input type="text" id="bayarrp" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="diterima" class="form-label">Diterima</label>
                                <input type="text" id="diterima" name="diterima" class="form-control"
                                    value="{{ $penjualan->diterima ?? 0 }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="kembali" class="form-label">Kembali</label>
                                <input type="text" id="kembali" name="kembali" class="form-control" value="0"
                                    readonly>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @includeIf('penjualan_detail.produk')
        @includeIf('penjualan_detail.member')
    </div>
@endsection
@push('scripts')
    <script>
        let table, table2;

        $(function() {
            //$('body').addClass('sidebar-collapse');

            table = $('.table-penjualan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('transaksi.data', $id_penjualan) }}',
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
                        data: 'harga_jual'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'diskon'
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
                paginate: false
            });

            $('.table-member').DataTable();
            table1 = $('.table-detail').DataTable({
                    processing: true,
                    bsort: false,
                    dom: 'Brt',
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'telepon'
                        },
                        {
                            data: 'alamat'
                        }
                    ]
                })

                .on('draw.dt', function() {
                    loadForm($('#diskon').val());
                    setTimeout(() => {
                        $('#diterima').trigger('input');
                    }, 300);
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

                $.post(`{{ url('/transaksi') }}/${id}`, {
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

            $('#diterima').on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($('#diskon').val(), $(this).val());
            }).focus(function() {
                $(this).select();
            });

            $('.btn-simpan').on('click', function(e) {
                e.preventDefault(); // cegah submit default

                let total = parseInt($('#total').val()) || 0;
                let bayar = parseInt($('#bayar').val()) || 0;
                let diterima = parseInt($('#diterima').val()) || 0;

                if (total <= 0) {
                    alert('Transaksi kosong. Silakan tambahkan produk terlebih dahulu.');
                    return;
                }

                if (diterima <= 0) {
                    alert('Masukkan jumlah uang yang diterima.');
                    $('#diterima').focus();
                    return;
                }

                if (diterima < bayar) {
                    alert('Uang diterima kurang dari total bayar.');
                    $('#diterima').focus();
                    return;
                }

                $('.form-penjualan').submit();
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
            $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                .done(response => {
                    $('#kode_produk').focus();
                    table.ajax.reload(() => loadForm($('#diskon').val()))
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }

        function tampilMember() {
            $('#modal-member').modal('show');
        }

        function pilihMember(id, kode) {
            $('#id_member').val(id);
            $('#kode_member').val(kode);
            $('#diskon').val('{{ $diskon }}');
            loadForm($('#diskon').val());
            $('#diterima').val(0).focus().select();
            hideMember();
        }

        function hideMember() {
            $('#modal-member').modal('hide');
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

        function loadForm(diskon = 0, diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val('Rp. ' + response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar : Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);

                    $('#kembali').val('Rp.' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('Kembali : Rp. ' + response.kembalirp);
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += ' {{ $error }}<br>';
            @endforeach

            Swal.fire({
                icon: 'warning',
                title: 'Error',
                html: errorMessages,
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal2-border-radius'
                }
            });
        @endif
    </script>
@endpush
