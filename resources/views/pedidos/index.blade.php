@extends('layouts.app')
@section('content')
    <div class="text-center">
        <div class="container-fluid">
            <div class="row col-md-4 col-md-offset-4">
                <button class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#modal-crear">
                    Agregar pedido
                </button>
            </div>
        </div>
        @if($pedidos->count() !== 0)
            <hr>
            <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
                @foreach($pedidos as $pedido)
                    <div class="well" id="pedido-{{$pedido->id}}" data-id="{{$pedido->id}}">
                        <p><strong>Mesa {{$pedido->mesa}}</strong> - {{count($pedido->platos)}} {{(count($pedido->platos)> 1 )? 'cosas' : ' cosa'}} </p>
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
    @include('pedidos.crear', ['categorias' => $categorias])
    @include('pedidos.acciones')
    @include('pedidos.cobrar')
    @include('pedidos.editar', ['categorias' => $categorias])
    @include('pedidos.borrar')

@endsection

@section('extra-scripts')
    <script>
        (function () {
            const modal_crear = $('#modal-crear');
            const modal_acciones = $('#modal-acciones');
            const modal_cobrar = $('#modal-cobrar');
            const modal_editar = $('#modal-editar');
            const modal_borrar = $('#modal-borrar');

            const lista_crear = modal_crear.find('ul');
            const select_crear = modal_crear.find('#select_platos');
            const codigo_crear = modal_crear.find('#id_plato');

            const lista_editar = modal_editar.find('ul');
            const form_editar = modal_editar.find('form');
            const select_editar = modal_editar.find('#select_platos_edit');
            const codigo_editar = modal_editar.find('#id_plato_edit');

            const lista_cobrar = modal_cobrar.find('ul');
            const form_cobrar = modal_cobrar.find('form');
            const total_cobrar = modal_cobrar.find('#total');

            let url = "{{route('api.pedidos.index')}}";
            let pedido_payload = {};
            let contador_crear = 0;
            let contador_editar = 0;

            function popular_lista_cobro (payload, nodo) {
                nodo.empty();
                payload.forEach( plato => {
                    if ( plato.cantidad > 1 )
                        nodo.append(`<li><p><strong class="text-danger">X${plato.cantidad}</strong> ${plato.nombre} - $${plato.precio} ($${plato.cantidad * plato.precio})</p></li>`);
                    else
                        nodo.append(`<li><p>${plato.nombre} - $${plato.precio}</p></li>`);
                });
            }

            function popular_lista_edicion (payload, nodo) {
                nodo.empty();
                payload.forEach( plato => {
                    for ( let i = 0; i < plato.cantidad; i++ ) {
                        nodo.append( `<input value="${plato.id}" name="platos[${contador_editar}]" type="hidden" />` );
                        nodo.append( `<li data-elem="${contador_editar}">${plato.nombre}</li>`);
                        contador_editar++;
                    }
                });
            }

            function doble_click_borrar_elemento (event, nodo) {
                nodo.find( `input[name="platos[${event.currentTarget.dataset.elem}]"]` ).remove();
                event.currentTarget.remove();
            }

            function handle_agregar (select, codigo, contador, nodo) {
                if ( codigo.val() !== '' ) {
                    let seleccionado = select.find( 'option[value="' + codigo.val() + '"]' );
                    if ( seleccionado.val() )  {
                        nodo.append( `<input value="${seleccionado.val()}" name="platos[${contador}]" type="hidden" />` );
                        nodo.append( `<li>${seleccionado.text()}</li>` );
                        contador++;
                    }
                } else if ( select.val() ) {
                    nodo.append( `<input value="${+select.val()}" name="platos[${contador}]" type="hidden" />` );
                    nodo.append( `<li>${select.find('option:selected').text()}</li>` );
                    contador++;
                }
                codigo.val('');
                select.val('');
                return contador;
            }



            $('#btn-cobrar').click(() => { modal_acciones.modal('hide'); modal_cobrar.modal('show')});
            $('#btn-editar').click(() => { modal_acciones.modal('hide'); modal_editar.modal('show')});
            $('#btn-borrar').click(() => { modal_acciones.modal('hide'); modal_borrar.modal('show')});
            modal_crear.find('#add-plato').click(event => { event.preventDefault(); contador_crear = handle_agregar(select_crear, codigo_crear, contador_crear, lista_crear)});

            $('.well').click( (event) => {
                let request_id = event.currentTarget.dataset.id;
                url =  "{{route('api.pedidos.index')}}" + '/' + request_id;
                $.getJSON(url, null, (response) => {pedido_payload = response});
                $('#btn-cobrar, #btn-editar, #btn-borrar').attr('data-id', request_id);
                modal_acciones.modal('show');
            });


            modal_cobrar.on('show.bs.modal', () => {
                total_cobrar.empty();
                form_cobrar.attr('action', pedido_payload.url_cobrar);
                popular_lista_cobro(pedido_payload.platos, lista_cobrar);
                total_cobrar.text('$'+pedido_payload.total);
            })

            modal_editar.on('show.bs.modal', () => {
                let contador = popular_lista_edicion(pedido_payload.platos, lista_editar);
                form_editar.attr('action', pedido_payload.url_editar);
                form_editar.find('input[name="mesa"]').val( pedido_payload.mesa );
                modal_editar.find('#add-plato-editar').click(event => { event.preventDefault();contador_editar = handle_agregar(select_editar, codigo_editar, contador_editar, lista_editar);});
                lista_editar.find('li').dblclick(event => {doble_click_borrar_elemento(event, lista_editar);});

            })


            modal_borrar.on('show.bs.modal', () => {modal_borrar.find('form').attr('action', pedido_payload.url_borrar);});



            modal_crear.on('hidden.bs.modal', () => {contador_crear = 0;lista_crear.empty()});
            modal_cobrar.on('hidden.bs.modal', () => {lista_cobrar.empty();});
            modal_editar.on('hidden.bs.modal', () => {contador_editar = 0;lista_editar.empty();});
        })();
    </script>
@endsection