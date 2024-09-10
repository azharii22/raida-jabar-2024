<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Peserta | {{ config('settings.main.1_app_name') }}</title>
</head>

<body>
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

            $fotoUrl = $data->foto
                ? public_path('storage/img/peserta/foto/' . $data->foto)
                : public_path('assets/images/no-images.png');

            $namaLengkap = $data->nama_lengkap ?? $namaLengkap;
            $villagesName = optional($data->villages)->name ?? (optional($data->regency)->name ?? $villagesName);

            if ($data->kategori && ($data->kategori->name === 'Peserta' || $data->kategori->name === 'Pinkonran')) {
                $regencyName = optional($data->regency)->name ?? $regencyName;
            }
        }
        $fotoData = base64_encode(file_get_contents($fotoUrl));
    @endphp
    <div
        style="background-image: url('{{ public_path('assets/images/idCard/background.png') }}'); height: 50rem; width: 600px; background-color: white; border-radius: 15px; overflow: hidden; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); ; background-position: center right; background-repeat: no-repeat; margin-top: 1rem">
        <div style="">
            <div
                style=" width:350px; height: 22rem; background-color: orange; border-bottom-right-radius: 35px;">
                <img src="data:image/png;base64,{{ $fotoData }}" alt="Foto"
                    style="height: 22rem; object-fit: cover; border-bottom-right-radius: 35px; ">
            </div>
            <div style="margin-left: auto; text-align: center;">
                <div style="margin: 5px; " >
                    <img src="{{ public_path('assets/images/idCard/logo dkd kwarda.png') }}" alt="Logo" style="width:200px; margin-top:-320px; margin-left:350px">
                </div>
            <div style="">
                <img src="{{ public_path('assets/images/idCard/logo.png') }}" alt="Logo" style="200px; margin-top: -250px; margin-left:350px; ">
                <img src="{{ public_path('assets/images/idCard/berdampak serentak.png') }}" alt="Logo" style="width:200px; margin-left:350px; margin-top:-100px">
            </div>
            </div>
        </div>
        <div style="margin-top:-67px">
            <div style="position: relative; width: 140px; height: 500px; background-color: orange; color: #fff;">
                <h3 style="font-size: 20px; font-weight: bold; position: absolute; top: 50%; left: 50%; transform: rotate(90deg) translate(-50%, -50%); transform-origin: left center; text-transform: uppercase;">
                    {{ $kategoriName }}
                </h3>
            </div>
            <div>
                <div
                    style="width:350px; float:right; margin-right:50px; margin-top:-450px; color: white; font-weight: bold; text-align: center; padding: 20px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: orange;">
                    {{ $namaLengkap }}
                </div>
                <div
                    style="width:350px; float:right; margin-right:50px; margin-top:-380px;  color: white; font-weight: bold; text-align: center; padding: 20px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: orange;">
                    {{ $villagesName }}
                </div>
                @if (is_object($data) &&
                        $data->kategori &&
                        ($data->kategori->name === 'Peserta' || $data->kategori->name === 'Pinkonran'))
                    <div
                        style="color: white; font-weight: bold; text-align: center; padding: 10px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: orange;">
                        {{ $data->regency->name }}
                    </div>
                @endif
                <img src="{{ public_path('assets/images/idCard/mascot.png') }}" alt="Logo" style="200px; margin-top:-350px; margin-left:80px; ">
            </div>
        </div>
    </div>
</body>

</html>
