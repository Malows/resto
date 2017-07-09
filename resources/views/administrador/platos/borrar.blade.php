<div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => ['platos.destroy', 0], 'method' => 'DELETE']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar plato</h4>
            </div>
            <div class="modal-body">
                <p>Está a punto de eliminar el plato <strong>este valor no se va a ver</strong>.</p>
                <p>
                    ¿Está seguro que desea eliminar permanentemente este plato?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>