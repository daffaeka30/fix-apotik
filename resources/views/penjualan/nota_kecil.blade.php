<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Kecil</title>

    <style>
        * {
            font-family: "consolas", sans-serif;
        }

        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }

        table td {
            font-size: 9pt;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm 150mm;
                /* 75mm lebar, 150mm tinggi */
            }

            html,
            body {
                width: 70mm;
                margin: 0 auto;
                padding: 0;
                box-sizing: border-box;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <button class="btn-print" onclick="window.print()">Print</button>

    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($setting->nama_perusahaan) }}</h3>
        <p style="font-size: 9pt;">{{ strtoupper($setting->alamat) }}</p>
        <p style="margin-bottom: 5px;">No. Nota:
            INV/{{ date('Ymd') }}/{{ str_pad($penjualan->id_penjualan, 5, '0', STR_PAD_LEFT) }}</p>
        <p>{{ tanggal_indonesia(date('Y-m-d'), false) }} {{ date('H:i') }} - Kasir:
            {{ strtoupper(auth()->user()->name) }}</p>
    </div>

    <p class="text-center">------------------------------</p>

    <table width="100%" style="border: none;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="3">{{ $item->produk->nama_produk }}</td>
            </tr>
            <tr>
                <td style="width: 40%">{{ $item->jumlah }} x {{ format_uang($item->harga_jual) }}</td>
                <td></td>
                <td class="text-right">Rp. {{ format_uang($item->jumlah * $item->harga_jual) }}</td>
            </tr>
        @endforeach
    </table>

    <p class="text-center">------------------------------</p>

    <table width="100%" style="border: none;">
        <tr>
            <td>Total Item</td>
            <td class="text-right">{{ $penjualan->total_item }}</td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td class="text-right">Rp. {{ format_uang($penjualan->total_harga) }}</td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td class="text-right">{{ format_uang($penjualan->diskon) }}%</td>
        </tr>
        <tr>
            <td>Total Bayar</td>
            <td class="text-right">Rp. {{ format_uang($penjualan->bayar) }}</td>
        </tr>
        <tr>
            <td>Diterima</td>
            <td class="text-right">Rp. {{ format_uang($penjualan->diterima) }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp. {{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
        </tr>
    </table>

    <p class="text-center">------------------------------</p>
    <p class="text-center">TERIMA KASIH TELAH BERBELANJA</p>
    <p class="text-center">DI {{ strtoupper($setting->nama_perusahaan) }}</p>
</body>

</html>
