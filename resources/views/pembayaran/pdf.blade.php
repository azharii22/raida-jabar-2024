3
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF Pembayaran &mdash; {{ config('settings.main.1_app_name') }}</title>
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
            @if (count($pembayaran))
                <div class="card-body">
                    <table style="width: 100%;">
                        <tr>
                            <td align="center">
                                <span>
                                    LAPORAN DATA PEMBAYARAN
                                    <br>{{ config('settings.main.1_app_name') }}
                                </span>
                            </td>
                        </tr>
                    </table>
                    <hr class="line-title">
                    <p align="center">
                        Laporan Data Pembayaran
                    </p>
                    </hr>
                    <table class="table table-bordered">
                        <thead class="thead-dark" align="center">
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Nama Cabang</th>
                                <th>Jumlah Terdaftar</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Tanggal Upload</th>
                                <th>Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $i => $dt)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td class="text-capitalize">{{ $dt->user->name }}</td>
                                    <td class="text-capitalize">{{ $dt->jumlah_terdaftar }} Orang</td>
                                    <td class="text-capitalize">@currency($dt->nominal)</td>
                                    <td class="text-capitalize">{{ $dt->status?->name }}</td>
                                    <td class="text-capitalize">{{ date('d-F-Y', strtotime($dt->tanggal_upload)) }}</td>
                                    @if ($dt->file == null)
                                        <td>-</td>
                                    @else
                                        <td class="text-capitalize"><img
                                                src="{{ public_path(Storage::url('public/pembayaran/') . $dt->file) }}"
                                                style="height: 100px; width: 100px" /></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <b>Laporan Data Pembayaran Belum tersedia</b>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
