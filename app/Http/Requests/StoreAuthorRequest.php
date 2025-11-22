<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Retornamos true porque la autenticación ya la maneja el Middleware 'auth:api' del controlador
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
        ];
    }

    /**
     * Mensajes de error personalizados (Opcional)
     */
    public function messages()
    {
        return [
            'first_name.required' => 'El nombre del autor es obligatorio.',
            'last_name.required'  => 'El apellido del autor es obligatorio.',
        ];
    }
}
