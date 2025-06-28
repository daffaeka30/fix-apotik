<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        $recent_order = Penjualan::with('member', 'penjualanDetail.produk')
            ->whereHas('penjualanDetail')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $low_stock_produk = Produk::where('stok', '<=', 5)->orderBy('stok', 'asc')->take(5)->get();

        $expired_soon = Produk::whereDate('expired', '>=', now())
            ->whereDate('expired', '<=', now()->addDays(30))
            ->orderBy('expired', 'asc')
            ->take(5)
            ->get();


        if (auth()->user()->level == '1') {
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan', 'recent_order', 'low_stock_produk', 'expired_soon'));
        } else {
            $today = date('Y-m-d');
            $total_transaksi = Penjualan::whereDate('created_at', $today)->count();
            $total_pendapatan = Penjualan::whereDate('created_at', $today)->sum('bayar');

            $recent_order = Penjualan::with('member', 'penjualanDetail.produk')
                ->whereHas('penjualanDetail')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('kasir.dashboard', compact('total_transaksi', 'total_pendapatan', 'recent_order'));
        }
    }
}
