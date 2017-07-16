<?php

namespace App\Http\Controllers\api;

use App\CategoriaPlato;
use App\Pedido;
use App\Plato;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    private function hidratar( $pedido )
    {
        $platos = Plato::select('id', 'nombre', 'precio')->whereIn('id',$pedido->platos)->get();


        $platos->each( function ($plato) use ($pedido) {
                $plato->cantidad = array_reduce($pedido->platos, function($carry, $item) use ($plato) {if ($item == $plato->id) $carry += 1; return $carry; }, 0 );
            });

        $pedido->total_cosas = count($pedido->platos);
        $pedido->total_cobrar = 0;
        $pedido->platos_ids = $pedido->platos;
        $pedido->platos = $platos;

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

    private function hidratar_muchos ($pedidos) {
        $platos = Plato::select('id', 'nombre', 'precio')->get();
        $pedidos->each( function( $pedido ) use( $platos ) {
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
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platos = Plato::where('habilitado',TRUE)->select('id', 'nombre', 'precio')->get()->toArray();
//        return Pedido::with(['mozo' => function ($query) {
//            $query->select('id','name');
//        }])->whereNull('cobrado_at')->orderBy('created_at')->select('id', 'mesa','platos', 'user_id')->get()
//        ->each( function($pedido) use($platos) {
//            $total = count( $pedido->platos );
//            $contados = array_count_values($pedido->platos);
//            $purgado =  array_unique($pedido->platos);
//            $pedido->platos = array_values( array_filter( array_map(
//                function ( $elem ) use ( $purgado, $contados ) {
//                    if ( in_array($elem['id'], $purgado) ) $elem['cantidad'] = $contados[ $elem['id'] ]; else return;
//                    return $elem;
//                }, $platos ),
//                function( $elem ) { return boolval($elem); } ) );
//            $pedido->total_cosas = $total;
//            unset($pedido->user_id);
//            $pedido->url = route('api.pedidos.show', $pedido->id);
//        });

        $pedidos = Pedido::with(['mozo' => function ($query) { $query->select('id','name'); }])->whereNull('cobrado_at')
            ->orderBy('created_at')->select('id', 'mesa','platos', 'user_id')->get();
        return $this->hidratar_muchos($pedidos);
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

        $categorias = CategoriaPlato::with(['platos' => function ($query) use ($purged_array, $contados) {
            $query->select('id', 'nombre', 'categoria_plato_id')->whereIn('platos.id', $purged_array)->get()->toArray();
        }])->select('id','nombre')->get()->toArray();

        for ( $i = 0; $i < count($categorias); $i++ ) {
            $count = 0;
            for ( $j = 0; $j < count( $categorias[$i]['platos'] ); $j++ ) {
                $categorias[$i]['platos'][$j]['cantidad']  = $contados[ $categorias[$i]['platos'][$j]['id'] ];
                $count += $contados[ $categorias[$i]['platos'][$j]['id'] ];
                unset( $categorias[$i]['platos'][$j]['categoria_plato_id'] );
            }
            $categorias[$i]['total'] = $count;
        }

        return $categorias;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_digest_target($id)
    {
        $pedidos_pendientes = Pedido::whereNull('listo_at')->whereNull('cobrado_at')->pluck('platos')->collapse()->sort()->toArray();
        $purged_array = array_values( array_unique( $pedidos_pendientes ) );
        $contados = array_count_values( $pedidos_pendientes );

        $categoria = CategoriaPlato::with(['platos' => function ($query) use ($purged_array) {
            $query->select('id', 'nombre', 'categoria_plato_id')->whereIn('platos.id', $purged_array);
        }])->where('id',$id)->select('id', 'nombre')->get()->toArray()[0];


        $count = 0;
        for ( $j = 0; $j < count( $categoria['platos'] ); $j++ ) {
            $categoria['platos'][$j]['cantidad']  = $contados[ $categoria['platos'][$j]['id'] ];
            $count += $contados[ $categoria['platos'][$j]['id'] ];
            unset( $categoria['platos'][$j]['categoria_plato_id'] );
        }
        $categoria['total'] = $count;


        return $categoria;
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
        $pedido = Pedido::with(['mozo' => function ($query) {$query->select('id', 'name');}])->findOrFail($id);

        return $this->hidratar($pedido);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index_mozo($id)
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
}
