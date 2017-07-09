<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => ['personal.update', 0], 'method' => 'PUT']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar personal</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre completo', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Correo electrónico') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo electrónico', 'required']) !!}
                </div>
                <div class="form-group">
                    <div class="alert alert-info" role="alert">
                        Si desea dejar la contraseña como está, deje los campos vacíos.
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            {!! Form::label('password', 'Contraseña') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña']) !!}
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmar contraseña']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('tipo_usuario_id','Categoría') !!}
                    {!! Form::select('tipo_usuario_id', $tipos_de_usuarios, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo de usuario', 'required']) !!}
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