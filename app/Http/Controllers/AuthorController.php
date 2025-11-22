<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthorRequest; // Importamos el Request
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
        return response()->json(Author::all(), 200);
    }

    // Inyectamos StoreAuthorRequest en lugar de Request
    public function store(StoreAuthorRequest $request)
    {
        // Si llegamos aquí, los datos ya son válidos.
        // Usamos $request->validated() para obtener solo los campos validados y limpios.
        $author = Author::create($request->validated());

        return response()->json($author, 201);
    }

    public function show($id)
    {
        $author = Author::with('books')->find($id);
        if (!$author) return response()->json(['message' => 'Author not found'], 404);
        return response()->json($author, 200);
    }

    public function update(Request $request, $id)
    {
        // Nota: Podrías crear un UpdateAuthorRequest similar si quisieras validar aquí también
        $author = Author::find($id);
        if (!$author) return response()->json(['message' => 'Author not found'], 404);

        $author->update($request->all());
        return response()->json($author, 200);
    }

    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) return response()->json(['message' => 'Author not found'], 404);
        $author->delete();
        return response()->json(['message' => 'Author deleted'], 200);
    }

    public function export()
    {
        return Excel::download(new AuthorsExport, 'authors.xlsx');
    }
}
