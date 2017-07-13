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
        if ( $request->has('data' ) ) {
            $user = User::where('QRpassword', $request->data )->first();
            if ( $user ) {
                Auth::login($user);
                return 1;
            }
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