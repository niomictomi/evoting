<li @if(Route::currentRouteName() == 'admin.dashboard') class="active" @endif>
    <a href="{{ route('admin.dashboard') }}">
        <i class="fa fa-home"></i>
        Dashboard
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.panitia') class="active" @endif>
    <a href="{{ route('admin.panitia') }}">
        <i class="fa fa-users"></i>
        Panitia
    </a>
</li>