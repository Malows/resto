@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if( Auth::guest() )
                <video width="480px" height="320px" id="video" autoplay></video>
                <div class="row">
                    <div class="text-center">
                        <span id="message">Escaneando...</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <div class="row text-center">
        <p class="text-muted text-left">Puede no funcionar. Depende de cada dispositivo.</p>
        <a href="{{ route('view_qr_login_2') }}" class="btn btn-primary btn-lg">Otras opciones</a>
    </div>
@endsection

@section('extra-styles')
    <script type="text/javascript" src="{{ URL::asset('/js/qr_login/qrcode.js') }}"></script>
@endsection

@section('extra-scripts')
    @if( Auth::guest() )
        <script type="text/javascript">
            function onSucess (data) {
                document.getElementById('video').setAttribute("style", "border: 3px solid #52e250");
                console.log('Sucess:', data);
                axios.post('{{route('attempt_qr_login')}}', {data: data}).then( response => {
                    if ( response.data === 1 )
                        $(location).attr('href', '{{route('home')}}');
                    else {
                        document.querySelector('#message').classList.remove('text-primary').add('text-danger').innerHTML = "El código QR ingresado no pertenece a ningun usuario habilitado.";
                    }
                })
            }

            function onError (err) {
                console.log(err);
                document.querySelector('#message').classList.remove('text-danger').add('text-primary').innerHTML = "Escaneando ...";
            }

            QrReader.getBackCamera().then(function(device) {
                new QrReader({
                    sucessCallback: onSucess,
                    errorCallback: onError, // Required
                    videoSelector: '#video', // If not provided creates an invisible element and decode in background
                    stopOnRead: true, // Default false, When true the video will stop once the first QR is read.
                    deviceId: device.deviceId, // Id of the device used for recording video.
                });
            });
        </script>
    @endif
@endsection
