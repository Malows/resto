<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::select('id', 'name', 'tipo_usuario_id', 'email')->orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personal = new User( $request->all() );
        $personal->password = bcrypt($request->password);
        $personal->QRpassword = json_encode([ 'username' => $personal->email, 'password' => $personal->password ]);
        $personal->save();

        return $personal;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personal = User::find($id);
        $personal->name = $request->name;
        $personal->email = $request->email;
        $personal->tipo_usuario_id = $request->tipo_usuario_id;

        if ( $request->has('password') and $request->password != null ) {
            $personal->password = bcrypt($request->password);
            $personal->QRpassword = json_encode([ 'username' => $personal->email, 'password' => $personal->password ]);
        }

        $personal->save();

        return $personal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::find($id)->delete();
    }
}
