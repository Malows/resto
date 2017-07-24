<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class QrLoginController extends Controller
{
    public function index ()
    {
        return view('auth.QrLogin');
    }

    public function indexoption2 ()
    {
        return view('auth.QrLogin2');
    }


    public function checkUser (Request $request)
    {
        // Login por sesión
        // QR pensado para ser un json de user y pass plano, para login de OAuth
        if ( $request->has('data' ) ) {
            $payload = json_decode( $request->data );
            $payload['email'] = $payload['username'];
            unset( $payload['username'] );
            Auth::attempt( $payload );
            return 1;
        }
        return 0;
    }

    public function QrAutoGenerate(Request $request)
    {
        if ( $request->action = 'updateqr' ) {
            $user = Auth::user();
            if ( $user ) {
                $user->QRpassword = bcrypt($user->email . $user->password );
                $user->update();
                return 1;
            }
        }
        return 0;
    }
}