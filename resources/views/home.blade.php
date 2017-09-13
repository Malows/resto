@extends('layouts.app')

@section('content')
    <div class="container-fluid center-block">
        @if(Auth::user()->tipo_usuario_id === 1)
            <div class="well col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 ">
                <div class="row">
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('platos.index')}}" class="btn btn-primary btn-lg btn-block">Administrar platos</a>
                    </div>
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('disponibilidad')}}" class="btn btn-primary btn-lg btn-block">Platos disponibles</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('personal.index')}}" class="btn btn-primary btn-lg btn-block">Administrar personal</a>
                    </div>
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="" class="btn btn-primary btn-lg btn-block">Resumenes</a>
                    </div>
                </div>
            </div>
        @elseif(Auth::user()->tipo_usuario_id === 2)
            <div class="well col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 ">
                <div class="row">
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('pedidos.index')}}" class="btn btn-primary btn-lg btn-block">Pedidos</a>
                    </div>
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('pedidos.digest')}}" class="btn btn-primary btn-lg btn-block">Pedidos listados</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('disponibilidad')}}" class="btn btn-primary btn-lg btn-block">Platos disponibles</a>
                    </div>
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="#" class="btn btn-default btn-lg btn-block">Ingredientes disponibles</a>
                    </div>
                </div>
            </div>
        @elseif(Auth::user()->tipo_usuario_id === 3)
            <div class="well col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 ">
                <div class="row">
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('mesas.index')}}" class="btn btn-primary btn-lg btn-block">Mesas</a>
                    </div>
                    <div class="col-xs-12 col-md-6 padding-all-1em">
                        <a href="{{route('mesas.index')}}" class="btn btn-primary btn-lg btn-block">Pedidos listos</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
