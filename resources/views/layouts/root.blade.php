<li @if (Route::currentRouteName() == 'root.dashboard') class="active" @endif>
    <a href="{{ route('root.dashboard') }}">
        <i class="fa fa-home"></i> Dashboard
    </a>
</li>

<li @if (Route::currentRouteName() == 'root.mahasiswa') class="active" @endif>
    <a href="{{ route('root.mahasiswa') }}">
        <i class="fa fa-list"></i> Daftar Mahasiswa
    </a>
</li>

<li @if (Route::currentRouteName() == 'root.admin') class="active" @endif>
    <a href="{{ route('root.admin') }}">
        <i class="fa fa-list"></i> Kelola Admin
    </a>
</li>

<li @if (Route::currentRouteName() == 'root.voting') class="active" @endif>
    <a href="{{ route('root.voting') }}">
        <i class="fa fa-list"></i> Voting
    </a>
</li>

<li @if (Route::currentRouteName() == 'root.reset') class="active" @endif>
    <a href="{{ route('root.reset') }}">
        <i class="fa fa-refresh"></i> Reset
    </a>
</li>