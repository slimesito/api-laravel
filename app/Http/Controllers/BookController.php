<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest; // Importamos el Request
use App\Events\BookCreated;
use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Book::with('author')->get(), 200);
    }

    // Inyectamos StoreBookRequest
    public function store(StoreBookRequest $request)
    {
        // Creamos el libro con los datos validados
        $book = Book::create($request->validated());

        // Disparamos el evento para el Job en cola
        event(new BookCreated($book));

        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['message' => 'Book not found'], 404);
        return response()->json($book, 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['message' => 'Book not found'], 404);

        $book->update($request->all());
        return response()->json($book, 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['message' => 'Book not found'], 404);

        $book->delete();
        return response()->json(['message' => 'Book deleted'], 200);
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }
}
