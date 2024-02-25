@extends('install::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('install.name') !!}</p>
@endsection
