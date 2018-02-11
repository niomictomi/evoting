<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pemira Fakultas Ekonomi {{ Carbon\Carbon::now()->year }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-image: url('{{ asset('images/landing.jpg') }}');
                background-position: center;
                background-size: 100% 100%;
                color: #fff;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                background-color: rgba(0, 0, 0, .3);
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title h1 {
                font-size: 84px;
                margin: 0;
            }

            .title h2 {
                font-size: 50px;
                margin: 0;
            }

            .links {
                margin-top: 20px;
            }

            .links > a {
                color: #fff;
                padding: 15px;
                font-size: 15px;
                border-radius: 30px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                transition: all ease 0.2s;
            }

            .links > a:hover {
                background-color: #fff;
                color: #000;
            }

            .m-b-md {
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    <h1>Pemira</h1>
                    <h2>- Fakultas Ekonomi -</h2>
                    <h3>Universitas Negeri Surabaya</h3>
                    <p>Tahun {{ Carbon\Carbon::now()->year }}</p>
                </div>

                <div class="links">
                    <a href="{{ route('admin.login.form') }}">Masuk Admin & Panitia</a>
                    <a href="{{ route('mahasiswa.login') }}">Masuk Mahasiswa</a>
                </div>
            </div>
        </div>
    </body>
</html>
