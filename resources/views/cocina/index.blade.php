@extends('layouts.app')
@section('content')
    <div class="text-center">
        <h3>Pedidos</h3>
        <hr>
        @if($pedidos->count() !== 0)
            <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
            @foreach($pedidos as $pedido)
                <div class="well" data-id="{{$pedido->id}}" data-toggle="modal" data-target="#modal-completar" data-mozo="{{$mozos[$pedido->user_id]}}">
                    <p><strong>Mozo {{dd($mozos)}}</strong></p>
                    <p><strong>Mozo {{$mozos[$pedido->user_id]}}</strong> - {{count($pedido->platos)}} {{(count($pedido->platos)> 1 )? 'cosas' : ' cosa'}} </p>
                    <div class="row">
                        @foreach( array_unique( $pedido->platos ) as $plato)
                            <div class="col-xs-6 col-sm-4 pedido-item">
                                {{$platos[$plato]}}
                                @if(( $cuenta = count( array_filter($pedido->platos, function ($elem) use ($plato) { return $elem == $plato;}) ) ) >= 2 )
                                    <strong class="text-danger">X{{$cuenta}}</strong>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            </div>
        @else
            <div style="padding: 20vh;">
                <p>No quedan pedidos pendientes.</p>
            </div>
        @endif
    </div>
    @include('cocina.completar')
@endsection

@section('extra-scripts')
<script>
    (function(){

        let well = {};
        let url = '';

        const modal = $('#modal-completar');
        const mozo = modal.find('#mozo');
        const lista = modal.find('ul');
        const boton_completar = modal.find('.modal-footer button:contains("Despachar")');

        boton_completar.click(() => {
           $.ajax({
               url: url,
               type: 'PUT',
               data: { _token: "{{ csrf_token() }}" }
           }).done((response) => {
               $('div.container-fluid').prepend(`<div role="alert" class="alert alert-success">${response.mensaje}</div>`);
               modal.modal('hide');
               $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
               well.remove();
           });
        });

        modal.on('show.bs.modal',(event) => {
            well = event.relatedTarget;
            lista.empty();
            $.getJSON('{{route("api.pedidos.index")}}/'+ $(event.relatedTarget).data('id'),null,(response) => {
                url = response.url_completar;
                mozo.text($(event.relatedTarget).data('mozo'));
                response.platos.forEach( plato => {
                    if ( plato.cantidad > 1 )
                        lista.append(`<li><p><strong class="text-danger">X${plato.cantidad}</strong> ${plato.nombre}</p></li>`);
                    else
                        lista.append(`<li><p>${plato.nombre}</p></li>`);
                });
            });
        }).on('hidden.bs.modal',() => {
            lista.empty();
        });
    })();
</script>
@endsection
