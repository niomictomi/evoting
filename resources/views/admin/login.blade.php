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
                    </div>
                    Admin & Panitia
                </h1>
            </header>
            <div class="auth-content">
                @if(Session::has('error'))
                    <p class="alert alert-danger">
                        {{ Session::get('error') }}
                    </p>
                @endif
                <p class="text-center"></p>
                <form id="login-form" action="{{ route('admin.login.process') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username">NIP/NIM</label>
                        <input type="text" class="form-control underlined" name="id" id="username"
                               placeholder="Masukkan NIM Anda" required></div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control underlined" name="password" id="password"
                               placeholder="Masukan Password Anda" required></div>
                    <div class="form-group">
                        <label for="remember">
                            <input class="checkbox" name="remember" id="remember" type="checkbox">
                            <span>Remember me</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Login</button>
                    </div>
                    <div class="form-group">
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
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-80463319-4', 'auto');
    ga('send', 'pageview');
</script>

<script src="{{asset('modular/js/vendor.js')}}"></script>
<script src="{{asset('modular/js/app.js')}}"></script>
</body>
</html>