<?php

use Carbon\Carbon;

function format_uang($angka)
{
    return number_format($angka, 0, ',', '.');
}

function terbilang($angka)
{
    $angka = abs($angka);
    $baca  = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $terbilang = '';

    if ($angka < 12) { // 0 - 11
        $terbilang = ' ' . $baca[$angka];
    } elseif ($angka < 20) { // 12 - 19
        $terbilang = terbilang($angka - 10) . ' belas';
    } elseif ($angka < 100) { // 20 - 99
        $terbilang = terbilang((int) ($angka / 10)) . ' puluh' . terbilang($angka % 10);
    } elseif ($angka < 200) { // 100 - 199
        $terbilang = ' seratus' . terbilang($angka - 100);
    } elseif ($angka < 1000) { // 200 - 999
        $terbilang = terbilang((int) ($angka / 100)) . ' ratus' . terbilang($angka % 100);
    } elseif ($angka < 2000) { // 1.000 - 1.999
        $terbilang = ' seribu' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) { // 2.000 - 999.999
        $terbilang = terbilang((int) ($angka / 1000)) . ' ribu' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) { // 1.000.000 - 999.999.999
        $terbilang = terbilang((int) ($angka / 1000000)) . ' juta' . terbilang($angka % 1000000);
    }

    return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    if (!$tgl) {
        return '-'; // Jika tanggal kosong, kembalikan tanda strip
    }

    $nama_hari = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jum\'at',
        'Sabtu'
    ];
    $nama_bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    // Convert ke objek Carbon
    $tanggal = Carbon::parse($tgl);

    // Ambil hari, bulan, dan tahun
    $hari      = $nama_hari[$tanggal->dayOfWeek]; // Ambil nama hari berdasarkan index
    $bulan     = $nama_bulan[(int) $tanggal->format('m')];
    $tahun     = $tanggal->format('Y');
    $tanggal_hari = $tanggal->format('d');

    // Format hasil
    if ($tampil_hari) {
        return "$hari, $tanggal_hari $bulan $tahun";
    } else {
        return "$tanggal_hari $bulan $tahun";
    }
}

function tambah_nol_didepan($value, $threshold = null)
{
    return sprintf("%0" . $threshold . "s", $value);
}

function getIconPath($kategori)
{
    $kategori = strtolower($kategori);

    if (str_contains($kategori, 'bebas terbatas')) {
        return 'image/icon_bebas_terbatas.png';
    } elseif (str_contains($kategori, 'bebas')) {
        return 'image/icon_bebas.png';
    } elseif (str_contains($kategori, 'narkotika')) {
        return 'image/icon_narkotika.png';
    } elseif (str_contains($kategori, 'keras') || str_contains($kategori, 'tidak bebas')) {
        return 'image/icon_keras.png';
    } elseif (str_contains($kategori, 'jamu')) {
        return 'image/icon_jamu.png';
    } elseif (str_contains($kategori, 'herbal')) {
        return 'image/icon_herbal.png';
    } elseif (str_contains($kategori, 'fitofarmaka')) {
        return 'image/icon_fitofarmaka.png';
    }

    return 'image/default.png'; // fallback
}
