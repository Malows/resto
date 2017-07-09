<div class="modal fade" id="modal-borrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => ['mesas.destroy', 1], 'method' => 'DELETE']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancelar pedido</h4>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro de desea cancelar el pedido completo?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default col-xs-5 pull-left" data-dismiss="modal">No</button>
                {!! Form::submit('Sí', ['class' => 'btn btn-danger col-xs-5 pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>