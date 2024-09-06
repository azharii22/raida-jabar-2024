<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta</title>
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
            height: 30rem;
            width: 380px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            display: flex;
            /* padding: 20px; */
        }

        .card-photo {
            background-color: #FFCC00;
            width: 10rem;
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
            width: 60px;
        }

        .card-body {
            display: flex;
        }

        .side-banner {
            width: 25%;
            background-color: #FFD23F;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 2rem;
            text-transform: uppercase;
            writing-mode: vertical-lr;
            transform: rotate(0deg);
            height: 17rem
        }

        .side-banner h3 {
            font-size: 20px;
            color: white;
            font-weight: bold;
        }

        .info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex-grow: 1;
            padding: 20px;
        }

        .info-box {
            background-color: #FFCC00;
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
    <div class="card">
        <div class="card-header">
            <div class="card-photo">
                <img src="{{ asset('assets/images/logo-raida.png') }}" alt="Logo" class="logo">
            </div>
            {{-- <div class="photo">
                <img src="path/to/photo.jpg" alt="Peserta Photo">
            </div> --}}
            <div class="header-text" style="margin-left: auto;">
                <div class="m-5">
                    <img src="{{ asset('assets/viewUser/img/raida/cakaran-1.1.png') }}" alt="Logo" class="logo">
                    <img src="{{ asset('assets/images/logo-raida.png') }}" alt="Logo"
                        style="width:100px; margin: 5px">
                </div>
                <div class="m-5">
                    <img src="{{ asset('assets/viewUser/img/raida/berdampak serentak.png') }}" alt="Logo"
                        style="width:100px; margin: 5px">
                </div>
            </div>
            <div class="header-text">
                <div class="m-5">
                    <img src="{{ asset('assets/viewUser/img/raida/cakaran-1.1.png') }}" alt="Logo" class="logo">
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="side-banner">
                <h3>Peserta</h3>
            </div>
            <div class="info">
                <div class="info-box">Nama</div>
                <div class="info-box">Kwarcab</div>
                <div class="info-box">Kwarran</div>
            </div>
        </div>
    </div>
</body>

</html>
