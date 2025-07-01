<?php

namespace App\Http\Controllers;

use datatables;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PDF;

class ProdukController extends Controller
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
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->select('produk.*', 'nama_kategori')
            ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="' . $produk->id_produk . '">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="badge bg-success">' . $produk->kode_produk . '</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return 'Rp. ' . format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return 'Rp. ' . format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })->addColumn('expired', function ($produk) {
                $today = now()->toDateString();
                $soon = now()->addDays(30)->toDateString();
                $expiredDate = $produk->expired;

                if ($expiredDate < $today) {
                    // Sudah kadaluarsa
                    return '<span class="text-danger fw-bold">' . tanggal_indonesia($expiredDate, false) . '</span>';
                } elseif ($expiredDate <= $soon) {
                    // Mendekati kadaluarsa (dalam 30 hari)
                    return '<span class="text-warning fw-bold">' . tanggal_indonesia($expiredDate, false) . '</span>';
                } else {
                    // Masih aman
                    return tanggal_indonesia($expiredDate, false);
                }
            })


            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-action">
                    <button type="button" onclick="editForm(`' . route('produk.update', $produk->id_produk) . '`)" class="btn btn-sm btn-info btn-icon"><i class="bx bx-edit"></i></button>
                    <button type="button" onclick="deleteData(`' . route('produk.destroy', $produk->id_produk) . '`)" class="btn btn-sm btn-danger btn-icon"><i class="bx bx-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all', 'expired'])
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
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'stok' => 'required|integer|min:0',
        'expired' => 'required|date|after_or_equal:today',
        'merk' => 'required|string|max:255',
        'id_kategori' => 'required|exists:kategori,id_kategori',
    ]);

    // Ambil kategori
    $kategori = Kategori::find($request->id_kategori);

    // Mapping kategori ke prefix
    $prefixMap = [
        'Bebas' => 'OB',
        'Bebas Terbatas' => 'OBT',
        'Narkotika' => 'N',
        'Jamu' => 'J',
        'Herbal' => 'H',
        'Fitofarmaka' => 'F',
    ];

    $prefix = $prefixMap[$kategori->nama_kategori] ?? 'X';

    // Format merk
    $brand = strtoupper(preg_replace('/\s+/', '', $request->merk));

    // Ambil semua kode_produk dan cari nomor terbesar
    $existingCodes = Produk::pluck('kode_produk');
    $maxNumber = 0;

    foreach ($existingCodes as $code) {
        $parts = explode('-', $code);
        $number = (int)end($parts);
        if ($number > $maxNumber) {
            $maxNumber = $number;
        }
    }

    $urutan = str_pad($maxNumber + 1, 3, '0', STR_PAD_LEFT);

    // Gabungkan kode
    $kodeProduk = "$prefix-$brand-$urutan";
    $request['kode_produk'] = $kodeProduk;

    Produk::create($request->all());

    return response()->json('Data berhasil disimpan', 200);
}






    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'expired' => 'required|date|after_or_equal:today'
        ]);

        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
