<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kartu Member</title>

    <style>
        .box {
            position: relative;
            width: 85.60mm;
            height: 53.98mm;
            border: 1px solid #000;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            padding: 5px;
        }

        .card {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .logo {
            position: absolute;
            top: 5px;
            right: 10px;
            text-align: right;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .logo p {
            font-size: 10pt;
            font-weight: bold;
            color: #fff;
            margin: 0;
            text-align: right;
        }

        .logo img {
            width: 30px;
            height: 30px;
        }

        .info {
            position: absolute;
            bottom: 10px;
            left: 20px;
            text-align: left;
            color: #fff;
        }

        .nama {
            position: absolute;
            top: 100pt;
            right: 16pt;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #fff !important;
        }

        .telepon {
            position: absolute;
            margin-top: 120pt;
            right: 16pt;
            color: #fff;
        }

        .barcode {
            position: absolute;
            top: 105pt;
            left: .860rem;
            border: 1px solid #fff;
            padding: .5px;
            background: #fff;
        }

        .barcode img {
            width: 50px;
            height: 50px;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>



</head>

<body>
    <section>
        <table>
            @foreach ($datamember as $key => $data)
                <tr>
                    @foreach ($data as $item)
                        <td class="text-center">
                            <div class="box">
                                <img class="card" src="{{ public_path($setting->path_kartu_member) }}" alt="card">
                                <div class="logo">
                                    <p>{{ $setting->nama_perusahaan }}</p>
                                    <img src="{{ public_path($setting->path_logo) }}" alt="logo">
                                </div>
                                <div class="nama">{{ $item->nama }}</div>
                                <div class="telepon">{{ $item->telepon }}</div>
                                <div class="barcode">
                                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$item->kode_member", 'QRCODE') }}"
                                        alt="qrcode">
                                </div>
                            </div>
                        </td>

                        @if (count($datamember) == 1)
                            <td class="text-center" style="width: 50%;"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </section>
</body>

</html>
