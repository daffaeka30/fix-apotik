<?php

namespace App\Http\Controllers;

use Log;
use PDF;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MemberController extends Controller
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
        return view('member.index');
    }

    public function data()
    {
        $member = Member::orderBy('kode_member')->get();

        return datatables()
            ->of($member)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_member[]" value="' . $produk->id_member . '">
                ';
            })
            ->addColumn('kode_member', function ($member) {
                return '<span class="badge bg-success">' . $member->kode_member . '<span>';
            })
            ->addColumn('aksi', function ($member) {
                return '
                <div class="btn-action">
                    <button type="button" onclick="editForm(`' . route('member.update', $member->id_member) . '`)" class="btn btn-sm btn-info btn-icon"><i class="bx bx-edit"></i></button>
                    <button type="button" onclick="deleteData(`' . route('member.destroy', $member->id_member) . '`)" class="btn btn-sm btn-danger btn-icon"><i class="bx bx-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_member'])
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
            'nama' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $prefix = 'MB';
        $dateCode = date('ym'); // Contoh: 2506 (2025 Juni)

        // Ambil member terakhir yang pakai kode bulan ini
        $lastMember = Member::where('kode_member', 'like', $prefix . $dateCode . '%')
            ->orderBy('kode_member', 'desc')
            ->first();

        // Ambil nomor urut terakhir
        if ($lastMember) {
            $lastNumber = (int)substr($lastMember->kode_member, -5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Bentuk kode lengkap
        $kodeMember = $prefix . $dateCode . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        try {
            $member = new Member();
            $member->kode_member = $kodeMember;
            $member->nama = $request->nama;
            $member->telepon = $request->telepon;
            $member->alamat = $request->alamat;
            $member->save();

            return response()->json('Data berhasil disimpan', 200);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan member: ' . $e->getMessage());
            return response()->json('Tidak dapat menyimpan data', 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $member = Member::find($id);

        return response()->json($member);
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
        $member = Member::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();

        return response(null, 204);
    }

    public function cetakMember(Request $request)
    {
        $datamember = collect(array());
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $datamember[] = $member;
        }

        $datamember = $datamember->chunk(2);
        $setting = Setting::first();

        $no  = 1;
        $pdf = PDF::loadView('member.cetak', compact('datamember', 'no', 'setting'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
        return $pdf->stream('member.pdf');
    }
}
