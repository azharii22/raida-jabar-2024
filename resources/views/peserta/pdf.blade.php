3
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF Peserta &mdash; {{ config('settings.main.1_app_name') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384=Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcjlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
            @if (count($data))
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
                <table class="table table-bordered">
                    <thead class="thead-dark" align="center">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i =>$dt)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td class="text-uppercase">{{ $dt->nama_lengkap }}</td>
                            <td>
                                @if ($dt->jenis_kelamin == 1)
                                <span>Laki - Laki</span>
                                @else
                                <span>Perempuan</span>
                                @endif
                            </td>
                            <td>{{ $dt->kategori?->name }}</td>
                            <td>{{ $dt->status?->name }}</td>
                            <td> {{ $dt->catatan }} </td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>