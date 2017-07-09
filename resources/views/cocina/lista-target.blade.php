@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h3>Pedidos</h3>
        <hr>
        @if($categoria->platos->count())
            <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
               <div class="well">
                   <h4>{{strtoupper($categoria->nombre)}}</h4>
                   <hr>
                   <div class="row">
                       @foreach($categoria->platos as $plato)
                           <div class="col-xs-6 col-md-4 pedido-item">
                               {{$plato->nombre}}
                               @if( $pedidos_contados[$plato->id] >= 2 )
                                   <strong class="text-danger">X{{$pedidos_contados[$plato->id]}}</strong>
                               @endif
                           </div>
                       @endforeach
                   </div>
               </div>
            </div>
        @else
            <div style="padding: 20vh;">
                <p>No quedan pedidos pendientes.</p>
            </div>
        @endif
    </div>
@endsection