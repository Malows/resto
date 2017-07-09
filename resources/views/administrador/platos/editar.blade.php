<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => ['platos.update', 0], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar plato</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('nombre', 'Nombre del plato') !!}
                    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del plato']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('descripcion', 'Descripción') !!}
                    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción (opcional)']) !!}
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            {!! Form::label('precio', 'Precio') !!}
                            {!! Form::number('precio', null, ['class' => 'form-control', 'placeholder' => 'Precio']) !!}
                        </div>
                        <div class="col-xs-6">
                            {!! Form::label('categoria_plato_id','Categoría') !!}
                            {!! Form::select('categoria_plato_id', $categorias, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una categoría']) !!}
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-3">
                            <label>
                                Habilitado <input class="form-control" name="habilitado" type="checkbox" value="1">
                            </label>
                        </div>
                        <div id="div-de-imagen" class="col-xs-3">

                        </div>
                        <div class="col-xs-6">
                            <div class="alert alert-info" role="alert">
                                Si no desea cambiar la imagen, deje esto vacío
                            </div>
                            {!! Form::label('foto', 'Imagen') !!}
                            {!! Form::file('foto') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>