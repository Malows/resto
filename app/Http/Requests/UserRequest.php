<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                return  [
                    'name' => 'required|min:4|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|confirmed',
                    'tipo_usuario_id' => 'required|exists:tipos_usuarios,id'
                ];
            case 'PUT':
            case 'PATCH':
                return  [
                    'name' => 'required|min:4|max:255',
                    'email' => 'required|email',
                    'password' => 'confirmed',
                    'tipo_usuario_id' => 'required|exists:tipos_usuarios,id'
                ];
            case 'DELETE':
            default:
                return [];
        }

    }
}
