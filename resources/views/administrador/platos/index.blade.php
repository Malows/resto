@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-crear"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th class="hidden-xs">Descripcion</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Habilitado</th>
                <th class="text-center">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($platos as $plato)
                <tr>
                    <td>{{$plato->id}}</td>
                    <td>{{$plato->nombre}}</td>
                    <td class="hidden-xs">{{$plato->descripcion}}</td>
                    <td class="text-center">${{$plato->precio}}</td>
                    <td class="text-center"><span class="glyphicon glyphicon-{{($plato->habilitado) ? 'ok' : 'remove'}}"></span></td>
                    <td class="text-center">
                        <div class="btn-group hidden-xs hidden-sm">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-editar" data-id="{{$plato->id}}" data-action="{{Route('platos.update',$plato->id)}}">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-eliminar" data-nombre="{{$plato->nombre}}" data-action="{{Route('platos.destroy', $plato->id)}}">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </div>
                        <div class="btn-group-vertical visible-xs visible-sm">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-editar" data-id="{{$plato->id}}" data-action="{{Route('platos.update',$plato->id)}}">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-eliminar" data-nombre="{{$plato->nombre}}" data-action="{{Route('platos.destroy', $plato->id)}}">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('administrador.platos.crear', ['categorias' => $categorias])
    @include('administrador.platos.editar', ['categorias' => $categorias])
    @include('administrador.platos.borrar')
@endsection

@section('extra-scripts')
    <script>
        $('#modal-eliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('form').attr('action',  button.data('action') );
            modal.find('.modal-body p strong').text( button.data('nombre') );
        });
        $('#modal-editar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('form').attr('action',  button.data('action') );
            var url = '{{route('api.platos.index')}}/' + button.data('id');
            $.getJSON(url, function ( response ) {
                modal.find('#nombre').val(response.nombre);
                modal.find('#descripcion').val(response.descripcion);
                modal.find('#precio').val(response.precio);
                modal.find('#categoria_plato_id').val(response.categoria_plato_id);
                modal.find('[type="checkbox"]').prop('checked', response.habilitado);
                modal.find('#div-de-imagen').prepend('<img src="'+ response.foto + '" class="img-responsive" />');
            })
        }).on('hidden.bs.modal', function () {
            $(this).find('#div-de-imagen').empty();
        })
    </script>
@endsection