<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> @yield('activity') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Place favicon.ico in the root directory -->
    <!-- Theme initialization -->
    <link rel="stylesheet" href="{{ asset('modular/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('modular/css/app-blue.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dataTables.responsive.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tempusdominus-bootstrap-4.css') }}" rel="stylesheet">
    @stack('css')

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5zm9sroyyw92mdbkdqpna5oo2r7vnf0e3exupkiguygzg097"></script>
    <script>
        tinymce.init(
            {
                selector: 'textarea',
                menubar: false,
                plugins: 'advlist',
                advlist_number_styles: 'lower-alpha'
            });
    </script>
</head>
<body>

<br><br><br><br><br><br>
<div>
    <div>
        <center>
            <img src="{{asset('images/logo.jpg')}}">
        </center>
    </div><br><br>

    <div>
        <center><h2>HASIL PEROLEHAN SUARA UNTUK TIAP
                PASANGAN KANDIDAT </h2><h2> KETUA DAN WAKIL KETUA {{$hasil}}
                FAKULTAS EKONOMI UNESA
                DI TEMPAT PEMUNGUTAN SUARA</h2>
        </center>
    </div>
    <br><br><br>
    <div>
        <center>
        <table class="table col-md-9" style="text-align: center">
            <tr>
                <td>No. Urut</td>
                <td>Nama Kandidat</td>
                <td>Jumlah Suara</td>
                <td>Presentase (%)</td>
            </tr>
            <tr>
                <td>No. Urut</td>
                <td>Nama Kandidat</td>
                <td>Jumlah Suara</td>
                <td>Presentase (%)</td>
            </tr>
            <tr>
                <td></td>
                <td>Tidak Memilih</td>
                <td>Jumlah Suara</td>
                <td>Presentase (%)</td>
            </tr>
            <tr>
                <td colspan="2">Total Suara dan Presentase</td>
                <td>82</td>
                <td>100%</td>
            </tr>
        </table>
        </center>
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

<script src="{{ asset('modular/js/vendor.js') }}"></script>
<script src="{{ asset('modular/js/app.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/datatables-setting.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.js') }}"></script>
@stack('js')
</body>
</html>