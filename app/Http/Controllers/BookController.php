<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
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
        // Cargamos 'author' para evitar el problema N+1 y que el Resource lo muestre
        $books = Book::with('author')->get();
        
        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        event(new BookCreated($book));

        // Opcional: Cargar el autor recién asignado para devolver la respuesta completa
        $book->load('author');

        return new BookResource($book);
    }

    public function show($id)
    {
        $book = Book::with('author')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return new BookResource($book);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        
        $book->update($request->all());
        
        // Recargamos la relación por si cambió el author_id
        $book->load('author');

        return new BookResource($book);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        
        $book->delete();

        return response()->json(['message' => 'Book deleted'], 200);
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }
}