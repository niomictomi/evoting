<li @if (Route::currentRouteName() == 'panitia.dashboard') class="active" @endif>
    <a href="{{route('panitia.dashboard')}}">
        <i class="fa fa-home"></i> Dashboard
    </a>
</li>
<li>
    <a href="">
        <i class="fa fa-th-list"></i> Data Paslon
        <i class="fa arrow"></i>
    </a>
    <ul class="sidebar-nav">
        <li @if (Route::currentRouteName() == 'panitia.paslon') class="active" @endif>
            <a href="{{route('panitia.paslon')}}"> HMJ </a>
        </li>
        <li>
            <a href="{{route('panitia.paslon.dpm')}}"> DPM </a>
        </li>
        <li>
            <a href="{{route('panitia.paslon.bem')}}"> BEMF </a>
        </li>
    </ul>
</li>
@if (\Illuminate\Support\Facades\Auth::user()->helper=='kps')
    <li @if (Route::currentRouteName() == 'panitia.resepsionis') class="active" @endif>
        <a href="{{route('panitia.resepsionis')}}">
            <i class="fa fa-th-list"></i> Resepsionis
        </a>
    </li>
@endif