<?php

namespace App\Http\Controllers;

use App\CategoriaPlato;
use App\Pedido;
use App\User;
use Auth;
use App\Plato;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class PedidoController extends Controller
{

    private function hidratar_muchos ($pedidos) {
        $platos = Plato::select('id', 'nombre', 'precio')->get();
        $user = Auth::user();
        $pedidos->each( function( $pedido ) use( $platos, $user ) {

            $pedido->mozo = $user;
            unset($pedido->user_id);

            $pedido->total_cosas = count( $pedido->platos );
            $pedido->total_cobrar = 0;

            $ids = $pedido->platos;
            $aux = $platos->filter( function ( $plato ) use ( $ids ) { return  in_array($plato->id, $ids); } ); //platos en mi pedido
            $aux->each( function ($elem) use ($ids) {
                $elem->cantidad = array_reduce($ids, function($carry, $item) use ($elem) {if ($item == $elem->id) $carry += 1; return $carry; }, 0 );
            });
            $pedido->platos_ids = $ids;
            $pedido->platos = $aux->values();

            foreach ($pedido->platos as $plato) {
                $pedido->total_cobrar += $plato->cantidad * $plato->precio;
            }
            $pedido->url = route('api.pedidos.show', $pedido->id);
            $pedido->url_editar = route('mesas.update', $pedido->id);
            $pedido->url_cobrar = route('mesas.cobrar', $pedido->id);
            $pedido->url_borrar = route('mesas.destroy', $pedido->id);
            $pedido->url_completar = route('pedidos.dispatch', $pedido->id);
        });

        return $pedidos;
    }

    private function hidratar ($pedido)
    {
        $platos = Plato::select('id', 'nombre', 'precio')->whereIn('id',$pedido->platos)->get()
            ->each( function ($plato) use($pedido) {
                $plato->cantidad = array_reduce($pedido->platos, function($carry, $item) use ($plato) {if ($item == $plato->id) $carry += 1; return $carry; }, 0 );
            });

        $pedido->total_cosas = count($pedido->platos);
        $pedido->total_cobrar = 0;
        $pedido->platos_ids = $pedido->platos;
        $pedido->platos = $platos;

        $pedido->mozo = Auth::user();
        unset($pedido->user_id);

        $pedido->url = route('api.pedidos.show', $pedido->id);
        $pedido->url_editar = route('mesas.update', $pedido->id);
        $pedido->url_cobrar = route('mesas.cobrar', $pedido->id);
        $pedido->url_borrar = route('mesas.destroy', $pedido->id);
        $pedido->url_completar = route('pedidos.dispatch', $pedido->id);


        foreach ($pedido->platos as $plato ){
            $pedido->total_cobrar += $plato->cantidad * $plato->precio;
        }

        return $pedido;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platos_disponibles = Plato::where('habilitado', TRUE)->pluck('nombre', 'id')->toArray();
        $categorias = CategoriaPlato::with(['platos' => function ($query) {
            $query->select('nombre', 'categoria_plato_id', 'id')->where('habilitado', TRUE)->orderBy('categoria_plato_id');
        }])->select('nombre', 'id')->get();
        $pedidos_pendientes = Auth::user()->pedidos()->orderBy('created_at')->get();
        return view('pedidos.index', ['pedidos' => $pedidos_pendientes, 'categorias' => $categorias, 'platos' => $platos_disponibles]);
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

        // avisar a la cocina

        $pedido = $this->hidratar($pedido);

        return $pedido;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function api_index_mozo()
    {
        $pedidos = Auth::user()->pedidos()->whereNull('cobrado_at')->orderBy('created_at')->get();

        return $this->hidratar_muchos($pedidos);
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

//        if ( $array_ordenado != $pedido->platos) {
//            avisar a la cocina
//        }

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

//        avisar en la cocina

//        flash('Pedido cancelado')->success();
//        return redirect()->route('mesas.index');
        return $this->hidratar($pedido);
    }

    /**
     * Set the paid-time and remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cobrar( $id ) {
        $pedido = Pedido::findOrFail($id);
        $pedido->cobrado_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $pedido->save();
        $pedido->delete();

        $pedido = $this->hidratar($pedido);

        return $pedido;
    }


    /**
     * Set the paid-time and remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function despachar( $id ) {
        $pedido = Pedido::findOrFail($id);
        $pedido->listo_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $pedido->save();

//        avisar al mozo del pedido listo


        return $this->hidratar($pedido);
    }
}
