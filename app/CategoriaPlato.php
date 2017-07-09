<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaPlato extends Model
{
    protected $table = 'categorias_platos';

    protected $fillable = [
        'nombre'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function platos() {
        return $this->hasMany('App\Plato');
    }
}
