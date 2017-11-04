<?php

namespace App\Http\Controllers\api;

use App\CategoriaPlato;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoriaPlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = CategoriaPlato::with('platos')->orderBy('id')->select('id', 'nombre')->get();
        $categorias->each(function ($categoria) {
           $categoria->platos->each(function ($plato) {
              $plato->foto = asset(Storage::url($plato->foto));
           });
        });
        return $categorias;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new CategoriaPlato($request->all());
        $categoria->save();
        return $categoria;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = CategoriaPlato::with('platos')->select('id', 'nombre')->find($id);
        $categoria->platos->each(function ($plato) {
            $plato->foto = asset(Storage::url($plato->foto));
        });
        return $categoria;
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
        $categoria = CategoriaPlato::find($id);
        $categoria->fill($request->all());
        $categoria->save();
        return $categoria;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CategoriaPlato::find($id)->delete();
    }
}
