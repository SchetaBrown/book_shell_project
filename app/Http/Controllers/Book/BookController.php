<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('author')) {
            $query->where('author_id', $request->author);
        }

        $books = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::orderBy('title')->get();
        $authors = Author::orderBy('surname')->get();

        return view('pages.books.index', compact('books', 'categories', 'authors'));
    }

    public function create()
    {
        $authors = Author::orderBy('surname')->get();
        $categories = Category::orderBy('title')->get();
        return view('pages.books.create', compact('authors', 'categories'));
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
        return view('pages.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy('surname')->get();
        $categories = Category::orderBy('title')->get();
        return view('pages.books.edit', compact('book', 'authors', 'categories'));
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
