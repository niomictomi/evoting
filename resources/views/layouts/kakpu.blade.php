<li @if (Route::currentRouteName() == 'kakpu.dashboard') class="active" @endif>
    <a href="{{route('kakpu.dashboard')}}">
        <i class="fa fa-home"></i>
        Dashboard
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.voting.hmj') class="active" @endif>
    <a href="{{ route('admin.voting.hmj', ['jurusan' => \App\Jurusan::all()->first()->nama, 'tipe' => 'Memiliki hak suara']) }}">
        <i class="fa fa-thermometer-half"></i>&nbsp;&nbsp;
        Voting HMJ
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.voting.dpm') class="active" @endif>
    <a href="{{ route('admin.voting.dpm', ['jurusan' => \App\Jurusan::all()->first()->nama, 'tipe' => 'Memiliki hak suara']) }}}">
        <i class="fa fa-thermometer-three-quarters"></i>&nbsp;&nbsp;
        Voting DPM
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.voting.bem') class="active" @endif>
    <a href="{{ route('admin.voting.bem', ['tipe' => 'Memiliki hak suara']) }}">
        <i class="fa fa-thermometer-full"></i>&nbsp;&nbsp;
        Voting BEM
    </a>
</li>
<li @if (Route::currentRouteName() == 'kakpu.buka') class="active" @endif>
    <a href="{{route('kakpu.buka')}}">
        <i class="fa fa-key"></i>
        Buka Kotak Suara
    </a>
</li>
<li @if(Route::currentRouteName() == 'admin.voting.pengaturan') class="active" @endif>
    <a href="{{ route('admin.voting.pengaturan') }}">
        <i class="fa fa-gears"></i>
        Pengaturan Voting
    </a>
</li>