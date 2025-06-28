@extends('layouts.master')

@section('title', 'Dashboard')

@push('css')
    <style>
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }
    </style>
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="p-4 space-y-6">

            <!-- Summary Cards -->
            <div class="row">
                <!-- Kategori -->
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-white card-hover" style="background-color: #dbeafe;">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px;">
                                    <i class="bx bx-category text-primary fs-5"></i>
                                </div>
                                <span class="fw-semibold small text-primary">Total Kategori</span>
                            </div>
                            <h4 class="mb-1 text-primary">{{ $kategori }}</h4>
                        </div>
                        <div class="card-footer py-2 px-3 bg-transparent border-top-0">
                            <a href="{{ route('kategori.index') }}" class="text-primary small">More Info <i
                                    class="bx bx-right-arrow-alt align-middle"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Produk -->
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-white card-hover" style="background-color: #dcfce7;">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px;">
                                    <i class="bx bx-package text-success fs-5"></i>
                                </div>
                                <span class="fw-semibold small text-success">Total Produk</span>
                            </div>
                            <h4 class="mb-1 text-success">{{ $produk }}</h4>
                        </div>
                        <div class="card-footer py-2 px-3 bg-transparent border-top-0">
                            <a href="{{ route('produk.index') }}" class="text-success small">More Info <i
                                    class="bx bx-right-arrow-alt align-middle"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Supplier -->
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-white card-hover" style="background-color: #fef9c3;">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px;">
                                    <i class="bx bxs-truck text-warning fs-5"></i>
                                </div>
                                <span class="fw-semibold small text-warning">Total Supplier</span>
                            </div>
                            <h4 class="mb-1 text-warning">{{ $supplier }}</h4>
                        </div>
                        <div class="card-footer py-2 px-3 bg-transparent border-top-0">
                            <a href="{{ route('supplier.index') }}" class="text-warning small">More Info <i
                                    class="bx bx-right-arrow-alt align-middle"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Member -->
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-white card-hover" style="background-color: #fecaca;">
                        <div class="card-body py-2 px-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 30px; height: 30px;">
                                    <i class="bx bx-id-card text-danger fs-5"></i>
                                </div>
                                <span class="fw-semibold small text-danger">Total Member</span>
                            </div>
                            <h4 class="mb-1 text-danger">{{ $member }}</h4>
                        </div>
                        <div class="card-footer py-2 px-3 bg-transparent border-top-0">
                            <a href="{{ route('member.index') }}" class="text-danger small">More Info <i
                                    class="bx bx-right-arrow-alt align-middle"></i></a>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Tables (Recent Order Full Width, Others Below) -->
            <div class="grid grid-cols-1 gap-6">

                <!-- Recent Orders -->
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

                <!-- Low Stock & Expired Products side by side -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Low Stock Products -->
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-lg font-bold mb-4">Low Stock Product</h3>
                        @if (count($low_stock_produk) > 0)
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-left text-sm">
                                    <thead class="bg-gray-100 text-gray-700">
                                        <tr>
                                            <th class="p-2">Nama Produk</th>
                                            <th class="p-2">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($low_stock_produk as $product)
                                            <tr class="border-b">
                                                <td class="p-2">{{ $product->nama_produk }}</td>
                                                <td class="p-2">{{ $product->stok }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada produk dengan stok rendah.</p>
                        @endif
                    </div>

                    <!-- Expired Soon Products -->
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-lg font-bold mb-4">Produk Mendekati Expired</h3>
                        @if (count($expired_soon) > 0)
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-left text-sm">
                                    <thead class="bg-gray-100 text-gray-700">
                                        <tr>
                                            <th class="p-2">Nama Produk</th>
                                            <th class="p-2">Expired</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expired_soon as $product)
                                            <tr class="border-b">
                                                <td class="p-2">{{ $product->nama_produk }}</td>
                                                <td class="p-2 text-yellow-600 font-semibold">
                                                    {{ \Carbon\Carbon::parse($product->expired)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada produk yang mendekati masa expired.</p>
                        @endif
                    </div>
                </div>

                <!-- Grafik -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-bold mb-4">Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d
                        {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                    <canvas id="incomeChart" class="w-full h-64"></canvas>
                </div>
            </div>


        </div>
    </div>

    </div>
@endsection
@push('scripts')
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('incomeChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($data_tanggal) !!},
                    datasets: [{
                        label: 'Pendapatan',
                        data: {!! json_encode($data_pendapatan) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
@endpush
