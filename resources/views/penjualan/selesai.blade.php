@extends('layouts.master')

@section('title', 'Transaksi Penjualan')

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
                <li class="breadcrumb-item active">Penjualan Selesai</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa fa-check me-2"></i>
                            <div>Data Transaksi telah selesai</div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            @if ($setting->tipe_nota == 1)
                                <button class="btn btn-warning"
                                    onclick="notaKecil('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')">
                                    Cetak Ulang Nota
                                </button>
                            @else
                                <button class="btn btn-warning"
                                    onclick="notaBesar('{{ route('transaksi.nota_besar') }}', 'Nota PDF')">
                                    Cetak Ulang Nota
                                </button>
                            @endif

                            <a href="{{ route('transaksi.baru') }}" class="btn btn-primary">Transaksi Baru</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('scripts')
        <script>
            // tambahkan untuk delete cookie innerHeight terlebih dahulu
            document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

            function notaKecil(url, title) {
                popupCenter(url, title, 625, 500);
            }

            function notaBesar(url, title) {
                popupCenter(url, title, 900, 675);
            }

            function popupCenter(url, title, w, h) {
                const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
                const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

                const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                    .documentElement.clientWidth : screen.width;
                const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                    .documentElement.clientHeight : screen.height;

                const systemZoom = width / window.screen.availWidth;
                const left = (width - w) / 2 / systemZoom + dualScreenLeft
                const top = (height - h) / 2 / systemZoom + dualScreenTop
                const newWindow = window.open(url, title,
                    `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
                );

                if (window.focus) newWindow.focus();
            }
        </script>
    @endpush
