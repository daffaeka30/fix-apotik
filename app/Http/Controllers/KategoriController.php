<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KategoriController extends Controller
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
        return view('kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->get();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('ikon', function ($kategori) {
                return '<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <img src="' . asset(getIconPath($kategori->nama_kategori)) . '" width="24">
            </div>';
            })
            ->addColumn('aksi', function ($kategori) {
                return '
                <div class="btn-action">
                    <button onclick="editForm(`' . route('kategori.update', $kategori->id_kategori) . '`)" class="btn btn-sm btn-info btn-icon">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button onclick="deleteData(`' . route('kategori.destroy', $kategori->id_kategori) . '`)" class="btn btn-sm btn-danger btn-icon">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            ';
            })
            ->rawColumns(['aksi', 'ikon'])
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
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);

        return response()->json($kategori);
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
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}
