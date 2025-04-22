<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author');

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('isbn')) {
            $query->where('isbn', 'like', '%' . $request->isbn . '%');
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        $itemsPerPage = $request->get('itemsPerPage', 10);
        $books = $query->paginate($itemsPerPage);

        $authors = Author::all();

        return view('books.index', compact('books', 'authors'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:book,isbn',
            'author_id' => 'required|exists:author,id',
        ]);

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:book,isbn,' . $book->id,
            'author_id' => 'required|exists:author,id',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
