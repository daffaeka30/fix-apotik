<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengeluaranController extends Controller
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
        return view('pengeluaran.index');
    }

    public function data()
    {
        $pengeluaran = Pengeluaran::orderBy('id_pengeluaran', 'desc')->get();

        return datatables()
            ->of($pengeluaran)
            ->addIndexColumn()
            ->addColumn('created_at', function ($pengeluaran) {
                return tanggal_indonesia($pengeluaran->created_at, false);
            })
            ->addColumn('nominal', function ($pengeluaran) {
                return 'Rp. ' . format_uang($pengeluaran->nominal);
            })
            ->addColumn('aksi', function ($pengeluaran) {
                return '
                <div class="btn-action">
                    <button type="button" onclick="editForm(`' . route('pengeluaran.update', $pengeluaran->id_pengeluaran) . '`)" class="btn btn-sm btn-info btn-icon"><i class="bx bx-edit"></i></button>
                    <button type="button" onclick="deleteData(`' . route('pengeluaran.destroy', $pengeluaran->id_pengeluaran) . '`)" class="btn btn-sm btn-danger btn-icon"><i class="bx bx-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
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
        $pengeluaran = Pengeluaran::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        return response()->json($pengeluaran);
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
        $pengeluaran = Pengeluaran::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();

        return response(null, 204);
    }
}
