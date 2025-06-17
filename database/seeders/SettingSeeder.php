<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->insert([
            'id_setting'        => 1,
            'nama_perusahaan'   => 'Apotik Palmeriam',
            'alamat'            => 'Jl. Palmeriam No. 8a',
            'telepon'           => '(021) 8580958',
            'tipe_nota'         => 1, //kecil 
            'diskon'            => 5,
            'path_logo'         => public_path('image/logo.png'),
            'path_kartu_member' => public_path('image/user.jpg'),
        ]);
    }
}
