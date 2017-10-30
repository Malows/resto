<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pedido;
use App\Plato;
use App\Events\nuevoPedido;
use App\Events\editarPedido;
use App\Events\cancelarPedido;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pedidos = $request->user()->pedidos()->orderBy('created_at')->get();
        $pedidos = $this->hidratarPedidos($pedidos);
        return $pedidos;
    }


    public function store(Request $request)
    {
        $pedido = new Pedido();
        $pedido->mesa = $request->mesa;
        $arreglo_aux = array_map(function($v) { return intval($v); }, $request->platos);
        sort( $arreglo_aux );
        $pedido->platos = $arreglo_aux;
        $pedido->user_id = $request->user()->id;
        $pedido->save();
        unset($arreglo_aux);

        // avisar a la cocina
        event(new nuevoPedido($pedido));

        return $this->hidratarPedidos($pedido, true);
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
        return $this->hidratar($pedido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->mesa = $request->mesa;

        $array_filtrado = array_filter( $request->platos, function ($elem) { return $elem; } );
        $array_intval =  array_map( function ($elem) {return intval($elem); }, $array_filtrado );
        sort( $array_intval );
        $array_ordenado = $array_intval;

        if ( $array_ordenado != $pedido->platos) {
            event(new editarPedido($pedido, $array_ordenado));
        }

        $pedido->platos = $array_ordenado;

        unset($array_filtrado, $array_intval, $array_ordenado);
        $pedido->save();

        return $this->hidratar($pedido);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        event(new cancelarPedido($id));

        return $this->hidratar($pedido);
    }


    public function cobrar( $id ) {
        $pedido = Pedido::findOrFail($id);
        $pedido->cobrado_at = \Carbon\Carbon::now();
        $pedido->save();
        $pedido->delete();

        return $this->hidratar($pedido);
    }

    private function hidratar ($pedido)
    {
        $platos = Plato::whereIn('id',array_unique($pedido->platos) )->select('id', 'nombre', 'precio')->get();
        $pedido = $this->parsearPlatos($pedido, $platos);
        $pedido = $this->agregarRutas($pedido);
        $pedido = $this->agregarTotales($pedido);

        return $pedido;
    }

    private function agregarRutas ($pedido)
    {
        $pedido->url_editar = route('mesas.update', $pedido->id);
        $pedido->url_cobrar = route('mesas.cobrar', $pedido->id);
        $pedido->url_borrar = route('mesas.destroy', $pedido->id);
        $pedido->url_completar = route('pedidos.dispatch', $pedido->id);

        return $pedido;
    }

    private function agregarTotales ($pedido)
    {
        $pedido->total_cosas = array_reduce($pedido->platos, function ($acc, $item) {return $acc + $item->cantidad;}, 0);
        $pedido->total = array_reduce($pedido->platos, function ($acc, $item) {return $acc + ($item->cantidad * $item->precio);}, 0);

        return $pedido;
    }

    private function parsearPlatos ($pedido, $platos)
    {
        $cantidades = array_reduce($pedido->platos, function ($acc, $item) {
            if (array_key_exists($item, $acc)) $acc[$item] += 1;
            else $acc[$item] = 1;
            return $acc;
        }, []);

        $parsedPlatos = [];

        foreach ($cantidades as $key => $value) {
            $plato = $platos->filter(function ($x) use ($key) { return $x->id === $key; })->first();
            $plato->cantidad = $value;
            $parsedPlatos[] = $plato;
        }
        $pedido->platos = $parsedPlatos;

        return $pedido;
    }

    private function hidratarPedidos ($pedidos)
    {
        $pedidos = $pedidos->map( function ($item) { return $this->hidratar($item); });

        return $pedidos;
    }

}
