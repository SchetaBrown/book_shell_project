<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    private array $books = [
        [
            'title' => 'Война и мир',
            'description' => 'Роман-эпопея о жизни русского общества в эпоху Наполеоновских войн.',
            'year' => 1869,
            'total_pages' => 1300,
            'cover_url' => null,
            'author_id' => 1,
            'category_id' => 3,
        ],
        [
            'title' => 'Преступление и наказание',
            'description' => 'Роман о моральных дилеммах и психологии убийцы.',
            'year' => 1866,
            'total_pages' => 600,
            'cover_url' => null,
            'author_id' => 2,
            'category_id' => 3,
        ],
        [
            'title' => 'Ночной Дозор',
            'description' => 'Фантастический роман о противостоянии Света и Тьмы.',
            'year' => 1998,
            'total_pages' => 400,
            'cover_url' => null,
            'author_id' => 3,
            'category_id' => 1,
        ],
    ];

    public function run(): void
    {
        foreach($this->books as $book) {
            Book::create($book);
        }
    }
}
