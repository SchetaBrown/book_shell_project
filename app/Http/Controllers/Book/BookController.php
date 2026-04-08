<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category'])->latest()->paginate(20);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::orderBy('surname')->get();
        $categories = Category::orderBy('title')->get();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Книга создана');
    }

    public function show(Book $book)
    {
        $book->with(['author', 'category', 'users'])->get();
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy('surname')->get();
        $categories = Category::orderBy('title')->get();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Книга обновлена');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Книга удалена');
    }
}
