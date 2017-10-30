<?php

namespace App\Http\Controllers\api;

use App\Pedido;
use App\Plato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pedido::whereNull('cobrado_at')->orderBy('created_at')->select('id', 'mesa', 'user_id', 'platos')->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->url_editar = route('mesas.update', $pedido->id);
        $pedido->url_cobrar = route('mesas.cobrar', $pedido->id);
        $pedido->url_borrar = route('mesas.destroy', $pedido->id);
        $pedido->url_completar = route('pedidos.dispatch', $pedido->id);
        $pedido->total = 0;
        $platos = Plato::whereIn('id',array_unique($pedido->platos) )->select('id', 'nombre', 'precio')->get();
        $aux = [];
        foreach ( array_unique($pedido->platos) as $value ) {
            $plato = $platos->filter(function($elem) use($value) { return $elem->id === $value; })->first();
            $plato->cantidad = count( array_filter($pedido->platos, function ($elem) use($value) {return $elem === $value;}));
            $aux[] = $plato;
            $pedido->total += ($plato->precio * $plato->cantidad);
        }
        $pedido->platos = $aux;
        return $pedido;
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

    public function mesasAbiertas (Request $request) {

    }
}
