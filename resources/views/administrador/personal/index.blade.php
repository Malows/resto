@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-crear">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personal as $persona)
                    <tr>
                        <td>{{$persona->id}}</td>
                        <td>{{$persona->name}}</td>
                        <td>{{$tipos_de_usuarios[$persona->tipo_usuario_id]}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-editar" data-id="{{$persona->id}}" data-action="{{route('personal.update', $persona->id)}}"><span class="glyphicon glyphicon-edit"></span></button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-borrar" data-action="{{route('personal.destroy', $persona->id)}}" data-nombre="{{$persona->name}}"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('administrador.personal.crear', ['tipos_de_usuarios' => $tipos_de_usuarios])
    @include('administrador.personal.editar', ['tipos_de_usuarios' => $tipos_de_usuarios])
    @include('administrador.personal.borrar')
@endsection

@section('extra-scripts')
    <script>
        $('#modal-borrar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('form').attr('action',  button.data('action') );
            modal.find('.modal-body p strong').text( button.data('nombre') );
        });
        $('#modal-editar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('form').attr('action',  button.data('action') );
            var url = '{{route('api.personal.index')}}/' + button.data('id');
            $.getJSON(url, function ( response ) {
                modal.find('#name').val(response.name);
                modal.find('#tipo_usuario_id').val(response.tipo_usuario_id);
                modal.find('#email').val(response.email);
            })
        })
    </script>
@endsection