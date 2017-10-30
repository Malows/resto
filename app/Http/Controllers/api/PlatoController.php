<?php

namespace App\Http\Controllers\api;

use App\Plato;
use App\CategoriaPlato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Plato[]
     */
    public function index()
    {
        $platos = Plato::all();
        $this->hidratar($platos);
        return $platos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Plato;
     */
    public function store(Request $request)
    {
        $plato = new Plato( $request->all() );
        $categoria = CategoriaPlato::find($request->categoria_plato_id);

        if (!$request->hasFile('foto')) return ['message' => 'No se incluyó ninguna imagen asociada al plato que desea crear', 'success' => false];

        $file = $request->file('foto');
        $nombre_imagen = str_replace(' ', '_', $categoria->nombre) . '__';
        $nombre_imagen .= str_replace(' ', '_',$request->nombre) . '.' . $file->getClientOriginalExtension();
        $nombre_imagen = strtolower($nombre_imagen);

        $plato->foto = $request->foto->storeAs('platos', $nombre_imagen, 'public');

        $plato->save();

        return $plato;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Plato
     */
    public function show($id)
    {
        $plato = Plato::findOrFail($id);
        $plato = $this->hidratar($plato);

        return $plato;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category($id)
    {
        $platos = Plato::where('categoria_plato_id', $id)->select('id', 'nombre', 'precio', 'descripcion', 'foto', 'habilitado')->get();
        $platos = $this->hidratar($platos);

        return $platos;
    }

    private function hidratar ($platos)
    {
        if ($platos->count() === 1) {
            $platos->foto = asset(Storage::url($platos->foto));
        } else {
            $platos->each( function ($plato) {
                $plato->foto = asset(Storage::url( $plato->foto ));
            });
        }

        return $platos;
    }
}
