<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\TipoUsuario;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payload = [];
        $payload['personal'] = User::orderBy('id')->get();
        $payload['tipos_de_usuarios'] = TipoUsuario::orderBy('id')->pluck('nombre', 'id');
        return view('administrador.personal.index', $payload );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $personal = new User( $request->all() );
        $personal->password = bcrypt($request->password);
        $personal->QRpassword = json_encode([ 'username' => $personal->email, 'password' => $personal->password ]);
        $personal->save();
        flash('Personal creado correctamente')->success();
        return redirect()->route('personal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $persona = User::findOrFail($id);
        $persona->name = $request->name;
        $persona->email = $request->email;
        $persona->tipo_usuario_id = $request->tipo_usuario_id;
        if ( $request->has('password') and $request->password != null ) {
            $persona->password = bcrypt($request->password);
        }
        $persona->save();
        flash('Datos del personal modificados')->success();
        return redirect()->route('personal.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        flash('Personal eliminado')->success();
        return redirect()->route('personal.index');
    }
}
