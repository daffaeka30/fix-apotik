<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
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

    public function index()
    {
        return view('setting.index');
    }

    public function show()
    {
        return Setting::first();
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        $setting->nama_perusahaan = $request->nama_perusahaan;
        $setting->telepon = $request->telepon;
        $setting->alamat = $request->alamat;
        $setting->diskon = $request->diskon;
        $setting->tipe_nota = $request->tipe_nota;

        if ($request->hasFile('path_logo')) {
            if (file_exists(public_path($setting->path_logo))) {
                unlink(public_path($setting->path_logo));
            }

            $file = $request->file('path_logo');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/image'), $nama);

            $setting->path_logo = "/image/$nama";
        }

        if ($request->hasFile('path_kartu_member')) {
            if (file_exists(public_path($setting->path_kartu_member))) {
                unlink(public_path($setting->path_kartu_member));
            }

            $file = $request->file('path_kartu_member');
            $nama = 'logo-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/image'), $nama);

            $setting->path_kartu_member = "/image/$nama";
        }

        $setting->update();

        return response()->json('Data berhasil disimpan', 200);
    }
}
