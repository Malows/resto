<div class="modal fade" id="modal-cobrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => ['mesas.cobrar', 1], 'method' => 'PUT']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cobrar pedido</h4>
            </div>
            <div class="modal-body">
                <p><strong>Platos</strong></p>
                <ul></ul>
                <hr>
                <p>Total:<strong id="total" class="pull-right"></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default col-xs-5 pull-left" data-dismiss="modal">Cerrar</button>
                {!! Form::submit('Cobrar', ['class' => 'btn btn-primary col-xs-5 pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>