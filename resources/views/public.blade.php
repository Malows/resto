@extends('layouts.app-without-login')

@section('content')
    <menu-resto url={{route('api.categorias.index')}}></menu-resto>
@endsection
