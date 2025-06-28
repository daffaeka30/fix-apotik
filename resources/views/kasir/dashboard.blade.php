@extends('layouts.master')

@section('title', 'Dashboard')

@push('css')
    <style>
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }

        .summary-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Sapaan --}}
        <div class="row mb-4">
            <div class="col text-center">
                <div class="card shadow-sm">
                    <div class="card-body py-4">
                        <h2 class="mb-3">Selamat Datang!</h2>
                        <p class="lead">Anda login sebagai <strong>Kasir</strong></p>
                        <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-lg mt-3">
                            <i class="bx bx-cart"></i> Transaksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-4 mb-4">
            <!-- Total Transaksi -->
            <div class="col-md-6">
                <div class="card card-hover shadow-sm" style="background-color: #e0f2fe;">
                    <div class="card-body d-flex align-items-center">
                        <div class="summary-icon me-3">
                            <i class="bx bx-receipt text-primary fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Transaksi Hari Ini</div>
                            <h4 class="mb-0 text-primary">{{ $total_transaksi }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="col-md-6">
                <div class="card card-hover shadow-sm" style="background-color: #dcfce7;">
                    <div class="card-body d-flex align-items-center">
                        <div class="summary-icon me-3">
                            <i class="bx bx-money text-success fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Pendapatan Hari Ini</div>
                            <h4 class="mb-0 text-success">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-bold mb-4">Recent Orders</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Member</th>
                            <th class="p-2">Kasir</th>
                            <th class="p-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recent_order as $order)
                            <tr class="border-b">
                                <td class="p-2">{{ $order->created_at->format('d-m-y') }}</td>
                                <td class="p-2">{{ $order->member->nama ?? '-' }}</td>
                                <td class="p-2">{{ $order->user->name ?? '' }}</td>
                                <td class="p-2">Rp {{ number_format($order->bayar, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
