<div class="modal fade" id="modal-crear" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'personal.store', 'method' => 'POST']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar personal</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre completo',]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Correo electrónico') !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo electrónico',]) !!}
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            {!! Form::label('password', 'Contraseña') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', ]) !!}
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmar contraseña',]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('tipo_usuario_id','Categoría') !!}
                    {!! Form::select('tipo_usuario_id', $tipos_de_usuarios, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo de usuario', ]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!! Form::submit('Crear', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>