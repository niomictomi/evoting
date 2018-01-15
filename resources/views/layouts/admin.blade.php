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
<li @if(Route::currentRouteName() == 'admin.voting.hmj') class="active" @endif>
    <a href="{{ route('admin.voting.hmj', ['jurusan' => \App\Jurusan::all()->first()->nama]) }}">
        <i class="fa fa-thermometer-half"></i>&nbsp;&nbsp;
        Voting HMJ
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.paniti') class="active" @endif>
    <a href="{{ route('admin.panitia') }}">
        <i class="fa fa-thermometer-three-quarters"></i>&nbsp;&nbsp;
        Voting DPM
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.panita') class="active" @endif>
    <a href="{{ route('admin.panitia') }}">
        <i class="fa fa-thermometer-full"></i>&nbsp;&nbsp;
        Voting BEM
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.paniia') class="active" @endif>
    <a href="{{ route('admin.panitia') }}">
        <i class="fa fa-gears"></i>
        Pengaturan Voting
    </a>
</li>