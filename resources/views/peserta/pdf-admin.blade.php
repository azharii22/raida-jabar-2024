3
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF Peserta &mdash; {{ config('settings.main.1_app_name') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384=Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcjlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body style="background-color: white;">
    <style>
        table.static {
            position: relative;
            border: 1px solid #543535;
        }

        .line-tittle {
            border: 0;
            border-style: inset;
            border-top: 1px solid #000;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            @if (count($peserta))
                <div class="card-body">
                    <table style="width: 100%;">
                        <tr>
                            <td align="center">
                                <span>
                                    LAPORAN DATA PESERTA
                                    <br>{{ config('settings.main.1_app_name') }}
                                </span>
                            </td>
                        </tr>
                    </table>
                    <hr class="line-title">
                    <p align="center">
                        Laporan Data Peserta
                    </p>
                    </hr>
                    <p>Total Peserta : {{ count($peserta) }}</p>
                    <table class="table table-bordered">
                        <thead class="thead-dark" align="center">
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Wilayah Cabang</th>
                                <th>Wilayah Ranting</th>
                                <th>Kategori</th>
                                <th>Nama Lengkap</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Ukuran Kaos</th>
                                <th>No HP</th>
                                <th>Agama</th>
                                <th>Golongan Darah</th>
                                <th>Riwayat Penyakit</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peserta as $index => $dt)
                                <?php
                                $fotoUrl = $dt->foto ? public_path('storage/img/peserta/foto/' . $dt->foto) : public_path('assets/images/no-images.png');
                                $fotoData = base64_encode(file_get_contents($fotoUrl));
                                ?>
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td class="text-capitalize">{{ $dt->regency->name }}</td>
                                    <td class="text-capitalize">{{ $dt->villages->name }}</td>
                                    <td class="text-capitalize">{{ $dt->kategori?->name }}</td>
                                    <td class="text-capitalize">{{ $dt->nama_lengkap }}</td>
                                    <td class="text-capitalize">{{ $dt->tempat_lahir }},
                                        {{ date('d-F-Y', strtotime($dt->tanggal_lahir)) }}</td>
                                    <td>
                                        @if ($dt->jenis_kelamin == 1)
                                            <span>Laki - Laki</span>
                                        @else
                                            <span>Perempuan</span>
                                        @endif
                                    </td>
                                    <td>{{ $dt->ukuran_kaos }}</td>
                                    <td>{{ $dt->no_hp }}</td>
                                    <td>{{ $dt->agama }}</td>
                                    <td>{{ $dt->golongan_darah }}</td>
                                    <td>{{ $dt->riwayat_penyakit }}</td>
                                    <td>
                                        <img src="data:image/png;base64,{{ $fotoData }}" alt="Foto"
                                            style="width: 50px; height: 50px;">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <b>Laporan Data Peserta Belum tersedia</b>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
