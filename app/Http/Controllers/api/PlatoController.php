<?php

namespace App\Http\Controllers\api;

use App\Plato;
use App\CategoriaPlato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Events\habilitarPlatos;
use App\Events\deshabilitarPlatos;

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
     * @return mixed
     */
    public function store(Request $request)
    {
        $plato = new Plato( $request->all() );
        $categoria = CategoriaPlato::find($request->categoria_plato_id);


        if (!$request->hasFile('foto'))
            return Response()->json(
                ['message' => 'No se incluyó ninguna imagen asociada al plato que desea crear', 'success' => false],
                Response::HTTP_FAILED_DEPENDENCY
            );

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
        $plato = Plato::find($id);
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
        $plato = Plato::find($id);
        $plato->fill( $request->all() );
        if ($request->hasFile('imagen')) $request->foto->storeAs('platos', $plato->foto, 'public');

        $plato->save();
        return $this->hidratar($plato);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plato = Plato::find($id);
        $plato->delete();

        return $this->hidratar($plato);
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

    public function disponibilidad(Request $request)
    {
        $platos = Plato::pluck('habilitado', 'id')->toArray();

        $payload = $request->all();
        if (array_key_exists('_method', $payload)) unset($payload['_method']);
        if (array_key_exists('_token', $payload)) unset($payload['_token']);

        $separados = $this->separarDiferencias($payload, $platos);

        Plato::whereIn('id', $separados['habilitar'])->update(['habilitado' => true]);
        Plato::whereIn('id', $separados['deshabilitar'])->update(['habilitado' => false]);

        broadcast(new habilitarPlatos($separados['habilitar']) )->toOthers();
        broadcast(new deshabilitarPlatos($separados['deshabilitar']) )->toOthers();

        return Response()->json($separados);
    }

    public function permutarDisponibildad($id)
    {
        $plato = Plato::find($id);
        $plato->habilitado = !$plato->habilitado;
        $plato->save();
        return $plato;
    }

    private function hidratar ($platos)
    {
        if (!$platos) return null;
        if ($platos->count() === 1) {
            $platos->foto = asset(Storage::url($platos->foto));
        } else {
            $platos->each( function ($plato) {
                $plato->foto = asset(Storage::url( $plato->foto ));
            });
        }

        return $platos;
    }

    private function separarDiferencias($payload, $platos)
    {
        $habilitar = [];
        $deshabilitar = [];

        foreach ($platos as $key => $value) {
            $fromDB = $value;
            $fromPayload = array_key_exists($key, $payload) and $payload[$key] == "1";
            if ($fromDB and !$fromPayload) $deshabilitar[] = $key;
            else if (!$fromDB and $fromPayload) $habilitar[] = $key;
        };

        return ['habilitar' => $habilitar, 'deshabilitar' => $deshabilitar];
    }

}
