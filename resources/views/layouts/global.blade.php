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

    @if(Auth::guard('mhs')->check())
        <style>
            .app {
                padding-left: 0;
            }

            .header {
                left: 0;
            }
        </style>
    @endif

</head>
<body>
<div class="main-wrapper">
    <div class="app" id="app">
        <header class="header">
            <div class="header-block header-block-collapse d-lg-none d-xl-none">
                <button class="collapse-btn" id="sidebar-collapse-btn">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="header-block header-block-search">
                <span class="name"><b>@yield('title')</b></span>
            </div>
            <div class="header-block header-block-buttons">
                <a href="https://fe.unesa.ac.id/" class="btn btn-sm header-btn" target="_blank">
                    <i class="fa fa-university"></i>
                    <span>Fakultas Ekonomi UNESA</span>
                </a>
            </div>
            <div class="header-block header-block-nav">
                <ul class="nav-profile">
                    <li class="profile dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="name">
                                @if(Auth::check())
                                    {{Auth::user()->nama }} </span>
                            @else
                                {{ Auth::guard('mhs')->user()->nama }}
                            @endif
                        </a>
                        <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                            @unless(Auth::guard('mhs')->check())
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-gear icon"></i>
                                    Pengaturan
                                </a>
                            @endunless
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); $('#keluar').submit()">
                                <i class="fa fa-power-off icon"></i>
                                Keluar
                            </a>
                            <form action="{{ route('logout') }}" method="post" style="display: none" id="keluar">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        @unless(Auth::guard('mhs')->check())
            <aside class="sidebar">
                <div class="sidebar-container">
                    <div class="sidebar-header">
                        <div class="brand">
                            <div class="logo">
                                <span class="l l1"></span>
                                <span class="l l2"></span>
                                <span class="l l3"></span>
                                <span class="l l4"></span>
                                <span class="l l5"></span>
                            </div>
                            @guest
                                Modular Admin
                            @else
                                {{ strtoupper(\Illuminate\Support\Facades\Auth::user()->role) }}
                            @endguest
                        </div>
                    </div>


                    <nav class="menu">
                        @if(Auth::check())
                            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                                @if(Auth::user()->isPanitia())
                                    @include('layouts.panitia')
                                @elseif(Auth::user()->isAdmin())
                                    @include('layouts.admin')
                                @elseif(Auth::user()->isKetuaKPU())
                                    @include('layouts.kakpu')
                                @elseif(Auth::user()->isDosen()||Auth::user()->isWD3())
                                    @include('layouts.wd3dosen')
                                @elseif(Auth::user()->isRoot())
                                    @include('layouts.root')
                                @endif
                                <li @if (Route::currentRouteName() == 'pengaturan') class="active" @endif>
                                    <a href="{{ route('admin.pengaturan') }}">
                                        <i class="fa fa-gear"></i> Pengaturan
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </nav>
                </div>
                <footer class="sidebar-footer">
                    <ul class="sidebar-menu metismenu" id="customize-menu">
                        <li>
                            <ul>
                                <li class="customize">
                                    <div class="customize-item">
                                        <div class="row customize-header">
                                            <div class="col-4"></div>
                                            <div class="col-4">
                                                <label class="title">fixed</label>
                                            </div>
                                            <div class="col-4">
                                                <label class="title">static</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="title">Sidebar:</label>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    <input class="radio" type="radio" name="sidebarPosition"
                                                           value="sidebar-fixed">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    <input class="radio" type="radio" name="sidebarPosition" value="">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="title">Header:</label>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    <input class="radio" type="radio" name="headerPosition"
                                                           value="header-fixed">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    <input class="radio" type="radio" name="headerPosition" value="">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="title">Footer:</label>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    <input class="radio" type="radio" name="footerPosition"
                                                           value="footer-fixed">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <label>
                                                    <input class="radio" type="radio" name="footerPosition" value="">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                            <a href="">
                                <i class="fa fa-cog"></i> Customize </a>
                        </li>
                    </ul>
                </footer>
            </aside>
            <div class="sidebar-overlay" id="sidebar-overlay"></div>
            <div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
            <div class="mobile-menu-handle"></div>
        @endunless

        <article class="content dashboard-page">
            <section class="section">
                @yield('content')
            </section>
        </article>

        <div class="modal fade" id="modal-media">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Media Library</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body modal-tab-container">
                        <ul class="nav nav-tabs modal-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="#gallery" data-toggle="tab" role="tab">Gallery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#upload" data-toggle="tab" role="tab">Upload</a>
                            </li>
                        </ul>
                        <div class="tab-content modal-tab-content">
                            <div class="tab-pane fade" id="gallery" role="tabpanel">
                                <div class="images-container">
                                    <div class="row"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade active in" id="upload" role="tabpanel">
                                <div class="upload-container">
                                    <div id="dropzone">
                                        <form action="/" method="POST" enctype="multipart/form-data"
                                              class="dropzone needsclick dz-clickable" id="demo-upload">
                                            <div class="dz-message-block">
                                                <div class="dz-message needsclick"> Drop files here or click to
                                                    upload.
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Insert Selected</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="modal fade" id="confirm-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fa fa-warning"></i> Alert</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to do this?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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

<script src="{{ asset('modular/js/vendor.js') }}"></script>
<script src="{{ asset('modular/js/app.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/datatables-setting.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.js') }}"></script>

<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
    $().ready(function () {
        tinymce.init({
            selector: '.use-tinymce',
            entity_encoding: "raw",
            height: 300,
            theme: 'modern',
            toolbar1: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
        });
    });
</script>

@stack('js')
</body>
</html>