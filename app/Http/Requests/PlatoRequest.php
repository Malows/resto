<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       switch ($this->method()) {
           case 'POST':
               return [
                   'nombre' => 'required',
                   'descripcion' => 'nullable',
                   'precio' => 'required|numeric',
                   'categoria_plato_id' => 'required|exists:categorias_platos,id',
                   'habilitado' => 'boolean|nullable',
                   'foto' => 'required|image'
               ];
           case 'PUT':
           case 'PATCH':
               return [
                   'nombre' => 'required',
                   'descripcion' => 'nullable',
                   'precio' => 'required|numeric',
                   'categoria_plato_id' => 'required|exists:categorias_platos,id',
                   'habilitado' => 'required|boolean|nullable',
                   'foto' => 'image'
               ];
           case 'DELETE':
           default:
               return [];
       }
    }
}
