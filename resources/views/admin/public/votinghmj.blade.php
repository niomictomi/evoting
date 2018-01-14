@extends('layouts.global')

@section('title')
    Voting HMJ
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info">
        <h5>{{ \App\Pengaturan::getStatusVoting() }}</h5>
        @if(session()->has('message'))
            <br><br>
            {{ session()->get('message') }}
        @endif
    </div>

    @if($cek)
        
    @endif
@endsection