<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function __invoke()
    {
        $latestBooks = Book::with(['author', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $popularAuthors = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(10)
            ->get();

        $categories = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->get();

        $totalBooks = Book::count();
        $totalAuthors = Author::count();

        return view('index', compact(
            'latestBooks',
            'popularAuthors',
            'categories',
            'totalBooks',
            'totalAuthors'
        ));
    }
}
