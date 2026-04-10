<?php

namespace App\Http\Controllers\SEO;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $books = Book::all();
        $authors = Author::all();
        $categories = Category::all();
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Статические страницы
        $staticPages = [
            ['loc' => '/', 'priority' => '1.0'],
            ['loc' => '/catalog', 'priority' => '0.9'],
            ['loc' => '/categories', 'priority' => '0.8'],
            ['loc' => '/authors', 'priority' => '0.8'],
        ];

        foreach ($staticPages as $page) {
            $xml .= '<url><loc>' . url($page['loc']) . '</loc>';
            $xml .= '<lastmod>' . now()->toDateString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority></url>';
        }

        // Страницы категорий
        foreach ($categories as $category) {
            $xml .= '<url><loc>' . url('/categories/' . $category->slug) . '</loc>';
            $xml .= '<lastmod>' . now()->toDateString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq><priority>0.7</priority></url>';
        }

        // Страницы авторов
        foreach ($authors as $author) {
            $xml .= '<url><loc>' . url('/authors/' . $author->id) . '</loc>';
            $xml .= '<lastmod>' . $author->updated_at->toDateString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq><priority>0.6</priority></url>';
        }

        // Страницы книг
        foreach ($books as $book) {
            $xml .= '<url><loc>' . url('/books/' . $book->id) . '</loc>';
            $xml .= '<lastmod>' . $book->updated_at->toDateString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq><priority>0.6</priority></url>';
        }

        $xml .= '</urlset>';
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
