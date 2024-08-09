<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF Unsur Kontingen &mdash; {{ config('settings.main.1_app_name') }}</title>
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
            @if (count($entries))
                <div class="card-body">
                    @if ($isFirstChunk)
                        <table style="width: 100%;">
                            <tr>
                                <td align="center">
                                    <span>
                                        LAPORAN DATA UNSUR KONTINGEN
                                        <br>{{ config('settings.main.1_app_name') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <hr class="line-title">
                        <p align="center">
                            Laporan Data Unsur Kontingen
                        </p>
                        </hr>
                        @php
                            $progressFile = storage_path('app/pdf-progress.json');
                            $progressData = json_decode(File::get($progressFile), true);
                            $totalEntries = $progressData['totalEntries'] ?? 0;
                        @endphp
                        <p>Total Peserta : {{ $totalEntries }}</p>
                    @endif
                    <table class="table table-bordered">
                        <thead class="thead-dark" align="center">
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Wilayah Cabang</th>
                                <th>Kategori</th>
                                <th>Nama Lengkap</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Ukuran Kaos</th>
                                <th>No HP</th>
                                <th>Agama</th>
                                <th>Golongan Darah</th>
                                <th>Riwayat Penyakit</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $index => $dt)
                                <tr>
                                    <td>{{ $currentRowNumber + $index }}</td>
                                    <td class="text-capitalize">{{ $dt->regency->name }}</td>
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
                                    <td>{{ $dt->status?->name }}</td>
                                    <td> {{ $dt->catatan }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <b>Laporan Data Unsur Kontingen Belum tersedia</b>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
