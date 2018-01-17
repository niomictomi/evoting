<li @if (Route::currentRouteName() == 'kakpu.dashboard') class="active" @endif>
    <a href="{{route('kakpu.dashboard')}}">
        <i class="fa fa-home"></i> Dashboard </a>
</li>
<li @if (Route::currentRouteName() == 'kakpu.buka') class="active" @endif>
    <a href="{{route('kakpu.buka')}}">
        <i class="fa fa-key"></i> Buka Kotak Suara </a>
</li>