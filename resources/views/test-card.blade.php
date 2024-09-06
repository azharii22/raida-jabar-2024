<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Peserta | {{ config('settings.main.1_app_name') }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .card {
            background-image: url('{{ asset('assets/images/idCard/background.png') }}');
            height: 32rem;
            width: 300px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card-header {
            display: flex;
            /* padding: 20px; */
        }

        .card-photo {
            width: 20rem;
            height: 13rem;
            object-fit: cover;
            /* border-radius: 10px; */
            border-bottom-right-radius: 35px
        }

        .photo img {
            background-color: #FFCC00;
            width: 100px;
            height: 130px;
            object-fit: cover;
            border-radius: 10px;
        }

        .header-text {

            text-align: center;
        }

        .header-text h2 {
            font-size: 16px;
            color: #FFCC00;
        }

        .header-text p {
            font-size: 12px;
            color: gray;
        }

        .logo {
            width: 100%;
            height: 13rem;
            border-bottom-right-radius: 35px

        }

        .card-body {
            display: flex;
        }

        .side-banner {
            width: 65%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 2rem;
            text-transform: uppercase;
            writing-mode: vertical-lr;
            transform: rotate(0deg);
            height: 19rem
        }

        .side-banner h3 {
            font-size: 20px;
            color: white;
            font-weight: bold;
        }

        .info {
            flex-direction: column;
            justify-content: center;
            flex-grow: 1;
            padding: 20px;
        }

        .info-box {
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    @foreach ($peserta as $data)
    <?php
    if ($data->kategori?->name == 'Peserta') {
        $color = '#FFD23F';
    }
    if ($data->kategori?->name == 'Bindamping') {
        $color = '#8F378D';
    }
    if ($data->kategori?->name == 'Staff Kontingen') {
        $color = '#58B0BC';
    }
    if ($data->kategori?->name == 'Pinkonran') {
        $color = '#D5318A';
    }
    
    ?>
    <div class="card">
        <div class="card-header">
            <div class="card-photo" style="background-color: {{ $color }};">
                <img src="{{ asset(Storage::url('public/img/peserta/foto/').$data->foto) }}" alt="Logo" class="logo">
            </div>
            <div class="header-text" style="margin-left: auto;">
                
                <div class="m-5">
                    <img src="{{ asset('assets/images/idCard/logo dkd kwarda.png') }}" alt="Logo"
                        style="width:70%; margin-top: 1rem;">
                    </div>
                    <img src="{{ asset('assets/images/idCard/logo.png') }}" alt="Logo"
                        style="width:50%; margin-top: 2rem;">
                    <img src="{{ asset('assets/images/idCard/berdampak serentak.png') }}" alt="Logo"
                        style="width:50%; margin-top: 1rem;">
            </div>
        </div>
        <div class="card-body">
            <div class="side-banner" style="background-color: {{ $color }};">
                <h3>{{ $data->kategori->name }}</h3>
            </div>
            <div class="info">
                <div class="info-box" style="background-color: {{ $color }};">{{ $data->nama_lengkap }}</div>
                <div class="info-box" style="background-color: {{ $color }};">{{ $data->villages?->name }}</div>
                <div class="info-box" style="background-color: {{ $color }};">{{ $data->regency?->name }}</div>
                <img src="{{ asset('assets/images/idCard/mascot.png') }}" alt="Logo"
                        style="width:100%; margin-top: -2rem;">
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>
