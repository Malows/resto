@extends('layouts.app-without-login')

@section('content')
    {{ Request::getHost() }}
    <menu-resto url={{route('api.categorias.index')}}></menu-resto>
@endsection
