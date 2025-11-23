<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Resources\AuthorResource; // <-- Importamos el Resource
use App\Exports\AuthorsExport;
use Maatwebsite\Excel\Facades\Excel;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // Usamos collection para listas
        // No cargamos 'books' aquí para mantener la lista ligera
        return AuthorResource::collection(Author::all());
    }

    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());
        
        // Devolvemos el recurso individual
        return new AuthorResource($author);
    }

    public function show($id)
    {
        // Aquí SÍ cargamos la relación 'books' porque estamos viendo el detalle
        $author = Author::with('books')->find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        // El Resource detectará automáticamente que 'books' está cargado y lo incluirá
        return new AuthorResource($author);
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->update($request->all());

        return new AuthorResource($author);
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->delete();
        
        return response()->json(['message' => 'Author deleted'], 200);
    }

    public function export()
    {
        return Excel::download(new AuthorsExport, 'authors.xlsx');
    }
}