<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table = "pedidos";

    protected $fillable = ['mesa', 'user_id', 'platos'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getPlatosAttribute( $value ) {
        return json_decode($value);
    }

    public function setPlatosAttribute( $value ) {
        $this->attributes['platos'] = json_encode($value);
    }

    public function mozo () {
        $this->belongsTo('App\User');
    }

}
