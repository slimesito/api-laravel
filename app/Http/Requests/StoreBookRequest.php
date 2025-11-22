<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        return [
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'published_date' => 'required|date',
            'author_id'      => 'required|integer|exists:authors,id',
        ];
    }

    public function messages()
    {
        return [
            'author_id.exists' => 'El autor seleccionado no existe en nuestra base de datos.',
            'published_date.date' => 'La fecha de publicación debe ser una fecha válida.',
        ];
    }
}
