<li @if (Route::currentRouteName() == '') class="active" @endif>
    <a href="{{route('')}}">
        <i class="fa fa-home"></i> Dashboard
    </a>
</li>
<li @if (Route::currentRouteName() == '') class="active" @endif>
    <a href="{{route('')}}">
        <i class="fa fa-th-list"></i> Data Paslon
    </a>
</li>
@if (\Illuminate\Support\Facades\Auth::user()->helper=='kps')
    <li @if (Route::currentRouteName() == '') class="active" @endif>
        <a href="{{route('')}}">
            <i class="fa fa-th-list"></i> Resepsionis
        </a>
    </li>
@endif