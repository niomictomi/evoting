@extends('layouts.global')

@section('content')
    <img src="{{asset('storage/'.$test->dir)}}">
    {{--<img src="{{asset('storage/'.$test->dir)}}">--}}
@endsection
