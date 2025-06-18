@extends('layouts.master')

@section('title', 'Laporan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>

        {{-- Card --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</h5>
                <div class="d-flex gap-2">
                    <button onclick="updatePeriode()" class="btn btn-info btn-sm">
                        <i class="fa fa-exchange me-1"></i> Ubah Periode
                    </button>
                    <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank"
                        class="btn btn-success btn-sm">
                        <i class="fa fa-download me-1"></i> Export PDF
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover w-100 text-nowrap">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Penjualan</th>
                                <th>Pembelian</th>
                                <th>Pengeluaran</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        @includeIf('laporan.form')

    </div>
@endsection

@push('scripts')
    <script>
        let table;

        $(function () {
            table = $('.table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
                },
                columns: [
                    { data: 'DT_RowIndex', searchable: false, sortable: false },
                    { data: 'tanggal' },
                    { data: 'penjualan' },
                    { data: 'pembelian' },
                    { data: 'pengeluaran' },
                    { data: 'pendapatan' },
                ],
                language: {
                    emptyTable: "Tidak ada data yang ditemukan dalam periode ini"
                }
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });

        function updatePeriode() {
            $('#modal-form').modal('show');
        }
    </script>
@endpush
