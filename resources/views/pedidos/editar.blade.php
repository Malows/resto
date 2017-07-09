<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => ['mesas.update', 1], 'method' => 'PUT']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar pedido</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('mesa', 'Mesa') !!}
                    {!! Form::number('mesa', null, ['class' => 'form-control', 'placeholder' => 'Número de mesa',]) !!}
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-9">
                            {!! Form::label('select_platos', 'Platos') !!}
                            <select id="select_platos_edit" name="select_platos" class="form-control">
                                <option selected="selected" disabled="disabled" value="" hidden="hidden">Elija un plato</option>
                                @foreach($categorias as $categoria)
                                    @if($categoria->platos->count())
                                        <optgroup label="{{$categoria->nombre}}">
                                            @foreach($categoria->platos as $plato)
                                                <option value="{{$plato->id}}">{{$plato->nombre}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            {!! Form::label('id_plato_edit', 'Código') !!}
                            {!! Form::number('id_plato_edit', null, ['class' => 'form-control', 'placeholder' => 'Código',]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button id="add-plato-editar" class="btn btn-default btn-block btn-lg">Añadir</button>
                </div>
                <hr>
                <p><strong>Platos</strong></p>
                <ul></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default col-xs-5 pull-left" data-dismiss="modal">Cerrar</button>
                {!! Form::submit('Crear', ['class' => 'btn btn-primary col-xs-5 pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>