<li @if (Route::currentRouteName() == '') class="active" @endif>
    <a href="{{route('')}}">
        <i class="fa fa-home"></i> Dashboard </a>
</li>
<li @if (Route::currentRouteName() == '') class="active" @endif>
    <a href="{{route('')}}">
        <i class="fa fa-key"></i> Buka Kotak Suara </a>
</li>