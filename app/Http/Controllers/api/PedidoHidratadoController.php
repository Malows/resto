<?php

namespace App\Http\Controllers\api;

use App\Pedido;
use App\Plato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedidoHidratadoController extends Controller
{
    public function index()
    {
        $platos = Plato::select('id', 'nombre', 'precio')->get();
        $pedidos = Pedido::with(['mozo' => function ($query) {
            $query->select('id', 'name');
        }])
        ->whereNull('cobrado_at')->orderBy('created_at')->select('id', 'mesa', 'platos', 'user_id')->get()
        ->each(function ($pedido) use ($platos) {
            unset($pedido->user_id);
            $pedido->url = route('api.pedidos.show', $pedido->id);
            $pedido->url_editar = route('mesas.update', $pedido->id);
            $pedido->url_cobrar = route('mesas.cobrar', $pedido->id);
            $pedido->url_borrar = route('mesas.destroy', $pedido->id);
            $pedido->url_completar = route('pedidos.dispatch', $pedido->id);
            $pedido->total_cosas = count($pedido->platos);
            $pedido->total_cobrar = 0;
            $ids = $pedido->platos;
            $aux = $platos->filter(function($plato) use ($ids) { return  in_array($plato->id, $ids); } );
            $aux->each(function ($elem) use ($ids) {
                $elem->cantidad = array_reduce($ids, function($carry, $item) use ($elem) {if ($item == $elem->id) $carry += 1; return $carry; }, 0 );
            });
            $pedido->platos_ids = $ids;
            $pedido->platos = $aux;
            foreach ($pedido->platos as $plato) {
                $pedido->total_cobrar += $plato->cantidad * $plato->precio;
            }
        });
        return $pedidos;
    }
}
