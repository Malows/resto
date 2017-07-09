@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="text-uppercase">Platos Disponibles</h2>
        {!! Form::open(['route' => 'guardar_disponibilidad', 'method' => 'PUT']) !!}
        @forelse($categorias as $categoria)
            <h3 class="text-center text-uppercase">{{ $categoria->nombre }}</h3>
            <div class="row">
        @forelse($categoria->platos as $plato)
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <label>{!! Form::checkbox($plato->id, true, $plato->habilitado) !!} {{$plato->nombre}}</label>
                </div>
            @empty
                <div class="row">
                    <p class="text-center bg-info col-xs-6 col-xs-offset-3" style="padding: 1.75em 0;">La categoría <strong>{{$categoria->nombre}}</strong> no tiene platos agregados, agregue algunos</p>
                </div>
            @endforelse
            </div>
            <hr>
        @empty
            <p class="text-center well">No hay categorías, agregue algunas</p>
        @endforelse
        <div class="row text-center">
            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection