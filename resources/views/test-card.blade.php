<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Peserta | {{ config('settings.main.1_app_name') }}</title>
    <style>
        @page { margin-top: 100px; }

        body {
            padding: 0;
            margin: 0px;
        }
        .id-card-container {
            padding: 0;
            margin: 0;
            height: 100%;
            max-width: 100%;
        }

        .id-card {
            padding: 0;
            display: inline-block;
            margin:  0 10px;
        }

    </style>
</head>

<body>
    <div class="id-card-container">
    @foreach ($peserta as $index => $data)
    @php
        $color = '#FFFFFF';
        $fotoUrl = public_path('assets/images/no-images.png');
        $fotoBackground = public_path('assets/images/idCard/background.png');
        $kategoriName = 'Kategori Tidak Ditemukan';
        $namaLengkap = 'Nama Tidak Ditemukan';
        $villagesName = 'Informasi Tidak Ditemukan';
        $regencyName = 'Informasi Tidak Ditemukan';

        if ($data && is_object($data)) {
            if ($data->kategori) {
                $colors = [
                    'Bindamping' => '#8F378D',
                    'Panitia' => '#FA602C',
                    'Peserta' => '#FFD23F',
                    'Pinkoncab' => '#28D3C0',
                    'Staff Kontingen' => '#58B0BC',
                    'Petugas Anjungan' => '#E73C3A',
                    'Pinkonran' => '#EB76A3',
                ];
                $color = $colors[$data->kategori->name] ?? '#FFFFFF';
                $kategoriName = $data->kategori->name;
            }

            // $fotoUrl = $data->foto
            //     ? public_path('storage/img/peserta/foto/' . $data->foto)
            //     : public_path('assets/images/no-images.png');
            $fotoUrl = public_path('assets/images/no-images.png');

            $namaLengkap = $data->nama_lengkap ?? $namaLengkap;
            $villagesName = optional($data->villages)->name ?? (optional($data->regency)->name ?? $villagesName);

            if ($data->kategori && ($data->kategori->name === 'Peserta' || $data->kategori->name === 'Pinkonran')) {
                $regencyName = optional($data->regency)->name ?? $regencyName;
            }
        }
        $fotoData = base64_encode(file_get_contents($fotoUrl));
    @endphp
        <div class="id-card" style="background-image: url('{{ public_path('assets/images/idCard/background.png') }}'); height:30rem; width: 250px; background-color: white; border-radius: 15px; overflow: hidden; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); ; background-position: 75% 40%; background-repeat: no-repeat;">
            <div style="">
                <div
                    style=" width:100px; height: 11rem; background-color: orange; border-bottom-right-radius: 35px;">
                    <img src="data:image/png;base64,{{ $fotoData }}" alt="Foto"
                        style="height: 11rem; width:100px; object-fit: cover; border-bottom-right-radius: 35px; ">
                </div>
                <div style="margin-left: auto; text-align: center;">
                    <div style="margin: 5px; " >
                        <img src="{{ public_path('assets/images/idCard/logo dkd kwarda.png') }}" alt="Logo" style="width:100px; margin-top:-170px; margin-left:100px">
                    </div>
                <div style="">
                    <img src="{{ public_path('assets/images/idCard/logo.png') }}" alt="Logo" style="width:80px; margin-top: -140px; margin-left:90px; ">
                    <img src="{{ public_path('assets/images/idCard/berdampak serentak.png') }}" alt="Logo" style="width:100px; margin-left:90px; margin-top:-100px">
                </div>
                </div>
            </div>
            <div style="margin-top:-67px">
                <div style="position: relative; width: 50px; height: 280px; background-color: orange; color: #fff;">
                    <h3 style="font-size: 20px; font-weight: bold; position: absolute; top: 50%; left: 50%; transform: rotate(90deg) translate(-50%, -50%); transform-origin: left center; text-transform: uppercase;">
                        {{ $kategoriName }}
                    </h3>
                </div>
                <div>
                    <div
                        style="width:180px; float:right;  margin-top:-260px; color: white; font-weight: bold; text-align: center; padding: 6px; margin-bottom: 5px; border-radius: 10px; text-transform: uppercase; background-color: orange;">
                        {{ $namaLengkap }}
                    </div>
                    <div
                        style="width:180px; float:right;  margin-top:-200px;  color: white; font-weight: bold; text-align: center; padding: 6px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: orange;">
                        {{ $villagesName }}
                    </div>
                    @if (is_object($data) &&
                            $data->kategori &&
                            ($data->kategori->name === 'Peserta' || $data->kategori->name === 'Pinkonran'))
                        <div
                            style="width:180px; float:right;  margin-top:-160px;  color: white; font-weight: bold; text-align: center; padding: 6px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: orange;">
                            {{ $data->regency->name }}
                        </div>
                    @endif
                    <img src="{{ public_path('assets/images/idCard/mascot.png') }}" alt="Logo" style="width:150px; margin-top:-119px; margin-left:70px; ">
                </div>
            </div>
        </div>
    @endforeach
    </div>
</body>
</html>
