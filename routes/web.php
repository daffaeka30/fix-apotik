<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PenjualanDetailController;

Route::get('/', fn() => redirect()->route('login'));

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Kategori
    Route::get('/kategori/data', [KategoriController::class, 'data'])
        ->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    // produk
    Route::get('/produk/data', [ProdukController::class, 'data'])
        ->name('produk.data');
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])
        ->name('produk.delete_selected');
    Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])
        ->name('produk.cetak_barcode');
    Route::resource('/produk', ProdukController::class);

    // member
    Route::get('/member/data', [MemberController::class, 'data'])
        ->name('member.data');
    Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])
        ->name('member.cetak_member');
    Route::resource('/member', MemberController::class);

    // supplier
    Route::get('/supplier/data', [SupplierController::class, 'data'])
        ->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    // pengeluaran
    Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])
        ->name('pengeluaran.data');
    Route::resource('/pengeluaran', PengeluaranController::class);

    // pembelian
    Route::get('/pembelian/data', [PembelianController::class, 'data'])
        ->name('pembelian.data');
    Route::post('/pembelian/{id}/cancel', [PembelianController::class, 'cancel'])
        ->name('pembelian.cancel');
    Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])
        ->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
        ->except('create');

    // pembelian detail 
    Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])
        ->name('pembelian_detail.data');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])
        ->name('pembelian_detail.load_form');
    Route::resource('/pembelian_detail', PembelianDetailController::class)
        ->except('create', 'edit');

    // penjualan
    Route::get('/penjualan/data', [PenjualanController::class, 'data'])
        ->name('penjualan.data');
    Route::get('/penjualan', [PenjualanController::class, 'index'])
        ->name('penjualan.index');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])
        ->name('penjualan.show');
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])
        ->name('penjualan.destroy');
    Route::post('/penjualan/{id}/cancel', [PenjualanController::class, 'cancel'])
        ->name('penjualan.cancel');

    
    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])
        ->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])
        ->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])
        ->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])
        ->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])
        ->name('transaksi.nota_besar');


    // penjualan detail
    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])
        ->name('transaksi.data');
    Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])
        ->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');
    Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])
        ->name('laporan.data');
    Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])
        ->name('laporan.export_pdf');

    Route::get('/user/data', [UserController::class, 'data'])
        ->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/setting', [SettingController::class, 'index'])
        ->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])
        ->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])
        ->name('setting.update');

    Route::get('/profil', [UserController::class, 'profil'])
        ->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])
        ->name('user.update_profil');
});
