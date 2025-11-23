<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name, // Ejemplo de campo calculado
            'books_count' => (int) $this->books_count,
            
            // Solo incluimos los libros si se cargaron explícitamente con 'with()'
            // Esto evita cargar todos los libros en la lista general de autores
            'books' => BookResource::collection($this->whenLoaded('books')),
            
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}