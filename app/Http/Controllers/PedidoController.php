<?php

namespace App\Http\Controllers;

use App\CategoriaPlato;
use App\Events\cancelarPedido;
use App\Events\despacharPedido;
use App\Events\editarPedido;
use App\Events\nuevoPedido;
use App\Pedido;
use App\User;
use Auth;
use App\Plato;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = CategoriaPlato::with(['platos' => function ($query) {
            $query->select('nombre', 'categoria_plato_id', 'id')->where('habilitado', TRUE)->orderBy('categoria_plato_id');
        }])->select('nombre', 'id')->get();
        $pedidos_pendientes = Auth::user()->pedidos()->orderBy('created_at')->get();

        // si traigo solo los disponibles, lanza un error, porque no encuentra los datos de un plato previamente registrado
        $platos = Plato::pluck('nombre', 'id')->toArray();
        return view('pedidos.index', ['pedidos' => $pedidos_pendientes, 'categorias' => $categorias, 'platos' => $platos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_cocina()
    {
        $mozos = User::where('tipo_usuario_id', 3)->pluck('name', 'id');
        $pedidos_pendientes = Pedido::orderBy('created_at')->whereNull('listo_at')->get();
        $platos_disponibles = Plato::where('habilitado', TRUE)->pluck('nombre', 'id');
        return view('cocina.index', ['mozos' => $mozos, 'pedidos' => $pedidos_pendientes, 'platos' => $platos_disponibles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_digest()
    {
        $pedidos_pendientes = Pedido::whereNull('listo_at')->whereNull('cobrado_at')->pluck('platos')->collapse()->sort()->toArray();
        $purged_array = array_values( array_unique( $pedidos_pendientes ) );
        $contados = array_count_values( $pedidos_pendientes );

        $categorias = CategoriaPlato::with(['platos' => function ($query) use ($purged_array) {
            $query->select('id', 'nombre', 'categoria_plato_id')->whereIn('platos.id', $purged_array);
        }])->get();

        return view('cocina.lista', ['categorias' => $categorias, 'pedidos_contados' => $contados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_target_digest( $categoria )
    {
        $pedidos_pendientes = Pedido::whereNull('listo_at')->whereNull('cobrado_at')->pluck('platos')->collapse()->sort()->toArray();
        $purged_array = array_values( array_unique( $pedidos_pendientes ) );
        $contados = array_count_values( $pedidos_pendientes );

        $categoria = CategoriaPlato::with(['platos' => function ($query) use ($purged_array) {
            $query->select('id', 'nombre', 'categoria_plato_id')->whereIn('platos.id', $purged_array);
        }])->find($categoria);

        return view('cocina.lista-target', ['categoria' => $categoria, 'pedidos_contados' => $contados]);
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
        $arreglo_aux = array_map(function($v) { return intval($v); }, $request->platos);
        sort( $arreglo_aux );
        $pedido->platos = $arreglo_aux;
        $pedido->user_id = Auth::user()->id;
        $pedido->save();
        unset($arreglo_aux);

        // avisar a la cocina
        event(new nuevoPedido($pedido));

        flash('Pedido registrado')->success();
        return redirect()->route('mesas.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->mesa = $request->mesa;

        $array_filtrado = array_filter( $request->platos, function ($elem) { return $elem; } );
        $array_intval =  array_map( function ($elem) {return intval($elem); }, $array_filtrado );
        sort( $array_intval );
        $array_ordenado = $array_intval;

        if ( $array_ordenado != $pedido->platos) {
            // avisar a la cocina
            event(new editarPedido($pedido, $array_ordenado));
        }

        $pedido->platos = $array_ordenado;

        unset($array_filtrado, $array_intval, $array_ordenado);
        $pedido->save();
        flash('Pedido modificado.')->success();
        return redirect()->route('mesas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pedido::findOrFail($id)->delete();

//        avisar en la cocina
        event(new cancelarPedido($id));

        flash('Pedido cancelado')->success();
        return redirect()->route('mesas.index');
    }

    /**
     * Set the paid-time and remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cobrar( $id ) {
        $pedido = Pedido::findOrFail($id);
        $pedido->cobrado_at = \Carbon\Carbon::now();
        $pedido->save();
        $pedido->delete();
        flash('Pedido cobrado')->success();
        return redirect()->route('mesas.index');
    }


    /**
     * Set the paid-time and remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function despachar( $id ) {
        $pedido = Pedido::findOrFail($id);
        $pedido->listo_at = \Carbon\Carbon::now();
        $pedido->save();

//        avisar al mozo del pedido listo
        event(new despacharPedido($pedido));

        return Response()->json(['mensaje' => 'Pedido despachado'], 200);
    }
}
