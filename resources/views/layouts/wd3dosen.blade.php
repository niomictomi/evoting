<li @if (Route::currentRouteName() == 'dosen.dashboard') class="active" @endif>
    <a href="{{route('dosen.dashboard')}}">
        <i class="fa fa-home"></i> Dashboard </a>
</li>
{{--<li @if (Route::currentRouteName() == 'dosen.buka') class="active" @endif>--}}
    {{--<a href="{{route('dosen.buka')}}">--}}
        {{--<i class="fa fa-key"></i> Buka Kotak Suara </a>--}}
{{--</li>--}}