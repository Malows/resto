<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    protected $fillable = [
        'nombre', 'precio', 'descripcion', 'foto', 'habilitado', 'categoria_plato_id'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function categoria() {
        return $this->belongsTo('App\CategoriaPlato');
    }
}
