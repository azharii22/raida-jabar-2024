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
        style="background-image: url('{{ public_path('assets/images/idCard/background.png') }}'); height: 32rem; width: 300px; background-color: white; border-radius: 15px; overflow: hidden; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div style="display: flex;">
            <div
                style="width: 20rem; height: 13rem; background-color: {{ $color }}; border-bottom-right-radius: 35px;">
                <img src="data:image/png;base64,{{ $fotoData }}" alt="Foto"
                    style="width: 100%; height: 100%; object-fit: cover; border-bottom-right-radius: 35px;">
            </div>
            <div style="margin-left: auto; text-align: center;">
                <div style="margin: 5px;">
                    <img src="{{ public_path('assets/images/idCard/logo dkd kwarda.png') }}" alt="Logo" style="width:70%; margin-top: 1rem;">
                </div>
                <img src="{{ public_path('assets/images/idCard/logo.png') }}" alt="Logo" style="width:50%; margin-top: 2rem;">
                <img src="{{ public_path('assets/images/idCard/berdampak serentak.png') }}" alt="Logo" style="width:50%; margin-top: 1rem;">
            </div>
        </div>
        <div style="display: flex;">
            <div
                style="width: 65%; background-color: {{ $color }}; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #fff; font-size: 2rem; text-transform: uppercase; writing-mode: vertical-lr; height: 19rem;">
                <h3 style="font-size: 20px; font-weight: bold;">{{ $kategoriName }}</h3>
            </div>
            <div style="flex-grow: 1; padding: 20px;">
                <div
                    style="color: white; font-weight: bold; text-align: center; padding: 10px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: {{ $color }};">
                    {{ $namaLengkap }}
                </div>
                <div
                    style="color: white; font-weight: bold; text-align: center; padding: 10px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: {{ $color }};">
                    {{ $villagesName }}
                </div>
                @if (is_object($data) &&
                        $data->kategori &&
                        ($data->kategori->name === 'Peserta' || $data->kategori->name === 'Pinkonran'))
                    <div
                        style="color: white; font-weight: bold; text-align: center; padding: 10px; margin-bottom: 10px; border-radius: 10px; text-transform: uppercase; background-color: {{ $color }};">
                        {{ $data->regency->name }}
                    </div>
                @endif
                <img src="{{ public_path('assets/images/idCard/mascot.png') }}" alt="Logo" style="width:100%; margin-top: -2rem;">
            </div>
        </div>
    </div>
</body>

</html>
