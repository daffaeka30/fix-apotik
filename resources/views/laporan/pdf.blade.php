<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .kop {
            text-align: center;
            margin-bottom: 0;
        }

        .kop h2 {
            margin: 0;
        }

        .kop p {
            margin: 0;
            font-size: 12px;
        }

        hr {
            border: 1px solid #000;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table thead {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .footer .left {
            float: left;
            width: 50%;
            font-size: 13px;
        }

        .footer .right {
            float: right;
            width: 40%;
            text-align: center;
        }

        .signature-space {
            margin-top: 80px;
        }
    </style>
</head>
<body>
    {{-- Kop Surat --}}
    <div class="kop">
        <h2>{{ $setting->nama_perusahaan }}</h2>
        <p>{{ $setting->alamat }}</p>
        <p>Telp: {{ $setting->telepon }} | Email: apotek@sehat.com</p>
    </div>
    <hr>

    {{-- Judul --}}
    <h3 style="text-align:center; margin-bottom: 0;">Laporan Pendapatan</h3>
    <p style="text-align:center; margin-top: 2px;">
        Tanggal {{ tanggal_indonesia($awal, false) }} s/d {{ tanggal_indonesia($akhir, false) }}
    </p>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        {{-- Informasi User yang Cetak --}}
        <div class="left">
            Dicetak oleh: <strong>{{ auth()->user()->name }}</strong><br>
            Tanggal Cetak: {{ tanggal_indonesia(now()->format('Y-m-d'), false) }}
        </div>

        {{-- Tanda Tangan --}}
        <div class="right">
            <p>Jakarta, {{ tanggal_indonesia($akhir, false) }}</p>
            <p><strong>Mengetahui,</strong></p>
            <div class="signature-space"></div>
            <p><strong><u>Nama Penanggung Jawab</u></strong></p>
            <p>Owner Apotik</p>
        </div>
    </div>
</body>
</html>
