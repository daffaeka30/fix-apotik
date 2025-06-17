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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-hover shadow-sm text-center">
                    <div class="card-body py-5">
                        <h2 class="mb-2">Selamat Datang!</h2>
                        <p class="lead mb-4">Anda login sebagai <strong>Kasir</strong></p>
                        <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-lg">
                            <i class="bx bx-cart"></i> Transaksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
