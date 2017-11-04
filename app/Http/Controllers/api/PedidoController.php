<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pedido;
use App\Plato;
use App\CategoriaPlato;
use App\Events\nuevoPedido;
use App\Events\editarPedido;
use App\Events\cancelarPedido;
use App\Events\despacharPedido;


class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $pedidos = ($user->tipo_usuario_id === 3) ?
            $user->pedidos()->orderBy('created_at')->get() :
            Pedido::orderBy('created_at')->whereNull('listo_at')->get();

        $pedidos = $this->hidratarPedidos($pedidos);
        return $pedidos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedido = new Pedido();
        $pedido->mesa = $request->mesa;
        $pedido->platos = $this->filtrar_tranformar_ordernar($request->platos);
        $pedido->user_id = $request->user()->id;
        $pedido->save();

        event(new nuevoPedido($pedido));

        return $this->hidratar($pedido);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);
        return $this->hidratar($pedido);
        return $pedido;
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
        $pedido = Pedido::find($id);
        $pedido->mesa = $request->mesa;

        $array_ordenado = $this->filtrar_tranformar_ordernar($request->platos);
        $platos_indexados = $this->unparsePlatos($pedido->platos);

        if ($array_ordenado != $platos_indexados)
            event(new editarPedido($pedido, $array_ordenado));

        $pedido->platos = $array_ordenado;
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
        $pedido = Pedido::find($id);
        $pedido->delete();

        event(new cancelarPedido($id));

        return $this->hidratar($pedido);
    }

    public function despachar ($id) {
        $pedido = Pedido::find($id);
        $pedido->listo_at = \Carbon\Carbon::now();

        event(new despacharPedido($pedido));

        $pedido->save();
        return Response()->json(['message' => 'Pedido despachado', 'success' => true]);
    }

    public function cobrar ($id) {
        $pedido = Pedido::find($id);
        $pedido->cobrado_at = \Carbon\Carbon::now();
        $pedido->save();
        $pedido->delete();

        return $this->hidratar($pedido);
    }

    public function digest ($id = null)
    {
        $pedidos = Pedido::whereNull('listo_at')->pluck('platos')->collapse()->sort()->toArray();

        $purged = array_values( array_unique( $pedidos ) );
        $contados = array_count_values( $pedidos );


        $categorias = CategoriaPlato::select('id', 'nombre')->with(['platos' => function ($q) use ($purged) {
            $q->select('id', 'nombre', 'categoria_plato_id')->whereIn('platos.id', $purged);
        }]);

        if ($id) $categorias = [ $categorias->find($id) ];
        else $categorias = $categorias->get();

        foreach ($categorias as $categoria) {
            foreach ($categoria->platos as $plato) {
                $plato->cantidad = $contados[$plato->id];
            }
        }

        return $categorias;
    }

    /**
     *
     *  HELPERS
     */

    /**
     * Filtra los espacios vacios de array, lo mapea a int y lo ordena
     */
     private function filtrar_tranformar_ordernar ($arreglo) {
        $aux = array_reduce($arreglo, function ($acc, $item) {
            if ($item) $acc[] = intval($item);
            return $acc;
        }, []);
        sort( $aux );
        return $aux;
    }

    /**
     *  Agrega las rutas al pedido
     */
    private function agregarRutas ($pedido)
    {
        $pedido->url = route('pedidos.show', $pedido->id);
        $pedido->url_editar = route('pedidos.update', $pedido->id);
        $pedido->url_cobrar = route('pedidos.cobrar', $pedido->id);
        $pedido->url_borrar = route('pedidos.destroy', $pedido->id);
        $pedido->url_completar = route('pedidos.despachar', $pedido->id);

        return $pedido;
    }

    /**
     *  Agrega los totales de precios y de cosas por pedido
     */
    private function agregarTotales ($pedido, $platos)
    {
        $pedido->total_cosas = array_reduce($platos, function ($c, $x) {return $c + $x->cantidad;}, 0);
        $pedido->total = array_reduce($platos, function ($c, $x) {return $c + ($x->cantidad * $x->precio);}, 0);

        return $pedido;
    }

    /**
     *  Parsea los platos, evitando la repetición y agregando cantidad
     */
    private function parsearPlatos ($pedido, $platos)
    {
        $cantidades = array_count_values($pedido->platos);

        $parsedPlatos = [];

        foreach ($cantidades as $key => $value) {
            $plato = $platos->filter(function ($x) use ($key) { return $x->id === $key; })->first();
            $plato->cantidad = $value;
            $parsedPlatos[] = $plato;
        }
        $pedido->platos = $parsedPlatos;

        return $pedido;
    }

    /**
     *  Devuelve a los platos de la colección de modelos a un array de indices
     */
    private function unparsePlatos ($pedido)
    {
        $indexPlatos = array_reduce($pedido->platos, function($c, $x) {
            for ($i = 0; $i < $x->cantidad; $i++) $c[] = $x->id;
            return $c;
        }, []);

        $pedido->platos = $indexPlatos;
        return $pedido;
    }

    /**
     *  Hidrata los datos de un pedido
     */
    private function hidratar ($pedido)
    {
        if (!$pedido) return null;
        
        $platos = Plato::whereIn('id',array_unique($pedido->platos) )->select('id', 'nombre', 'precio')->get();
        $pedido = $this->parsearPlatos($pedido, $platos);
        $pedido = $this->agregarRutas($pedido);
        $pedido = $this->agregarTotales($pedido, $pedido->platos);

        return $pedido;
    }

    /**
     *  Hidrata los datos de una lista de pedidos
     */
    private function hidratarPedidos ($pedidos)
    {
        $pedidos = $pedidos->map( function ($item) { return $this->hidratar($item); });

        return $pedidos;
    }
}
