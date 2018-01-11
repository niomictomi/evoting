<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> ModularAdmin - Free Dashboard Theme | HTML Version </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <!-- Theme initialization -->
    <link rel="stylesheet" href="{{asset('modular/css/vendor.css')}}">
    <link rel="stylesheet" href="{{asset('modular/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('modular/css/app-blue.css')}}">

</head>
<body>
<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <h1 class="auth-title">
                    <div class="logo">
                        <span class="l l1"></span>
                        <span class="l l2"></span>
                        <span class="l l3"></span>
                        <span class="l l4"></span>
                        <span class="l l5"></span>
                    </div>Mahasiswa</h1>
            </header>
            <div class="auth-content">

                @if(Session::has('message'))
                <p class="alert alert-danger">
                    {{ Session::get('message') }}
                </p>
                @endif

                <p class="text-center">Silahkan Masuk</p>
                {{ \Carbon\Carbon::today()->toDateString() }}
                <form id="login-form" action="{{ route('mahasiswa.login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username">NIM</label>
                        <input type="text" class="form-control underlined" name="id" id="username" placeholder="Masukkan NIM anda" required> </div>
                    <div class="form-group">
                        <label for="password">Kata sandi</label>
                        <input type="password" class="form-control underlined" name="password" id="password" placeholder="Kata Sandi" required> </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Reference block for JS -->
<div class="ref" id="ref">
    <div class="color-primary"></div>
    <div class="chart">
        <div class="color-primary"></div>
        <div class="color-secondary"></div>
    </div>
</div>

<script src="{{asset('modular/js/vendor.js')}}"></script>
<script src="{{asset('modular/js/app.js')}}"></script>
</body>
</html>