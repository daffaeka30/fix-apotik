<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PembelianDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('nama_produk')->get();
        $supplier = Supplier::find(session('id_supplier'));
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;

        if (! $supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier', 'diskon'));
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();

        $data = array();
        $total = 0;
        $total_item = 0; 

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="badge bg-success">'. $item->produk['kode_produk'] .'</span>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli']  = 'Rp. ' . number_format($item->harga_beli, 0, ',', '.');
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'">';
            $row['subtotal']    = 'Rp. ' . number_format($item->subtotal, 0, ',', '.');
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-sm btn-danger btn-icon"><i class="bx bx-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah; 
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];
        
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();

        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PembelianDetail();

        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah; 
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon, $total) 
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar)) . ' Rupiah'
        ];

        return response()->json($data);
    }
}
