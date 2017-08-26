<?php

namespace App\Http\Controllers;

use App\CategoriaPlato;
use App\Events\deshabilitarPlatos;
use App\Events\habilitarPlatos;
use App\Http\Requests\PlatoRequest;
use App\Plato;
use Illuminate\Http\Request;

class PlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = CategoriaPlato::pluck('nombre', 'id');
        $platos = Plato::orderBy('id')->paginate(20);
        return view('administrador.platos.index',['platos' => $platos, 'categorias' => $categorias]);
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
     * @param  \App\Http\Requests\PlatoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlatoRequest $request)
    {
        $plato = new Plato( $request->all() );
        $categoria = CategoriaPlato::find($request->categoria_plato_id);
//        dd($request->foto);
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nombre_imagen = str_replace(' ', '_', $categoria->nombre) . '__';
            $nombre_imagen .= str_replace(' ', '_',$request->nombre) . '.' . $file->getClientOriginalExtension();
            $nombre_imagen = strtolower($nombre_imagen);
            $plato->foto = $request->foto->storeAs('platos', $nombre_imagen, 'public');
            $plato->save();
            flash('Plato agregado correctamente')->success();
        } else {
            flash('No se incluyó ninguna imagen asociada al plato que desea crear')->error();
        }
        return redirect()->route('platos.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PlatoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlatoRequest $request, $id)
    {
        $plato = Plato::findOrFail($id);
        $plato->fill( $request->all() );
        if ( $request->hasFile('imagen') ) {
            $request->foto->storeAs('platos', $plato->foto, 'public');
        }
        flash('Plato actualizado correctamente')->success();
        return redirect()->route('platos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Plato::findOrFail($id)->delete();
        flash('Plato eliminado')->info();
        return redirect()->route('platos.index');
    }

    public function disponibilidad()
    {
        $categorias = CategoriaPlato::with('platos')->get();
        return view('disponibilidad.platos',['categorias' => $categorias]);
    }

    public function actualizar_disponibilidad(Request $request)
    {
        $platos = Plato::pluck('habilitado', 'id')->toArray();

        $payload = $request->all();
        unset( $payload['_method'], $payload['_token'] );

        $deshabilitar = [];
        $habilitar = [];

        foreach ($platos as $key => $value) {
            $fromDB = $value;
            if(array_key_exists($key,$payload) and $payload[$key] == "1") $fromPayload = true;
            else $fromPayload = false;

            if ($fromDB != $fromPayload) {
                if ($fromDB == false and $fromPayload == true) { //reactivo el plato
                    $habilitar[] = $key;
                } else if ($fromDB == true and $fromPayload == false) { //desactivo el plato
                    $deshabilitar[] = $key;
                }
            }
        }

        Plato::whereIn('id', $habilitar)->update(['habilitado' => true]);
        Plato::whereIn('id', $deshabilitar)->update(['habilitado' => false]);

//        return ['deshabilitar' => $deshabilitar, 'habilitar' => $habilitar];

        broadcast(new habilitarPlatos($habilitar) )->toOthers();
        broadcast(new deshabilitarPlatos($deshabilitar) )->toOthers();

        flash('Platos disponibles actualizados')->success();
        return redirect()->route('disponibilidad');
    }
}
