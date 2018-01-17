@extends('layouts.global')

@section('title')
    Voting BEM
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
        <b>{{ \App\Pengaturan::getStatusVoting() }}</b>
        @if(session()->has('message'))
            <br><br>
            {{ session()->get('message') }}
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <div class="title">

            </div>
        </div>
    </div>
    <form method="post">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        <input type="hidden" id="datetimepicker13">
    </form>
@endsection

@push('js')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker13').datetimepicker({
                inline: true,
                sideBySide: true,
                locale: 'id'
            });
        });
    </script>
@endpush