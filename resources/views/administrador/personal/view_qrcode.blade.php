<div class="modal fade" id="modal-qr-{{$persona->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Código QR</h4>
            </div>
            <div class="modal-body text-center">
                <h4>Código QR de {{$persona->name}}</h4>
                <img
                    class="img-responsive"
                    style="width: 75%; margin: 0 auto;"
                    src="data:image/png+xml;base64,{!! base64_encode( QrCode::format('png')->size(500)->margin(1)->generate($persona->QRpassword) ) !!}" />
                <a
                    class="btn btn-primary"
                    href="data:image/png+xml;base64,{!! base64_encode( QrCode::format('png')->size(1000)->margin(1)->generate($persona->QRpassword) ) !!}"
                    download="QR__{{$persona->name}}__{{$persona->email}}.png">
                    Descargar
                </a>
            </div>
        </div>
    </div>
</div>