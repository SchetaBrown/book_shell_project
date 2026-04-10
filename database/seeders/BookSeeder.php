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
            'title' => 'Анна Каренина',
            'description' => 'Трагическая история любви замужней женщины к офицеру Вронскому.',
            'year' => 1877,
            'total_pages' => 864,
            'cover_url' => null,
            'author_id' => 1,
            'category_id' => 3,
        ],
        [
            'title' => 'Преступление и наказание',
            'description' => 'Роман о моральных дилеммах и психологии убийцы.',
            'year' => 1866,
            'total_pages' => 672,
            'cover_url' => null,
            'author_id' => 2,
            'category_id' => 3,
        ],
        [
            'title' => 'Идиот',
            'description' => 'Роман о князе Мышкине, столкнувшемся с пороками общества.',
            'year' => 1869,
            'total_pages' => 640,
            'cover_url' => null,
            'author_id' => 2,
            'category_id' => 3,
        ],
        [
            'title' => 'Бесы',
            'description' => 'Политический роман о революционерах и нигилистах в России.',
            'year' => 1872,
            'total_pages' => 768,
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
        [
            'title' => 'Дневной Дозор',
            'description' => 'Продолжение истории о противостоянии магических сил.',
            'year' => 2000,
            'total_pages' => 448,
            'cover_url' => null,
            'author_id' => 3,
            'category_id' => 1,
        ],
        [
            'title' => 'Сумеречный Дозор',
            'description' => 'Третья книга культового цикла «Дозоры».',
            'year' => 2004,
            'total_pages' => 480,
            'cover_url' => null,
            'author_id' => 3,
            'category_id' => 1,
        ],
        [
            'title' => '1984',
            'description' => 'Роман-антиутопия о тоталитарном режиме и потере личности.',
            'year' => 1949,
            'total_pages' => 328,
            'cover_url' => null,
            'author_id' => 4,
            'category_id' => 1,
        ],
        [
            'title' => 'Скотный двор',
            'description' => 'Сатирическая притча о революции и тоталитаризме.',
            'year' => 1945,
            'total_pages' => 152,
            'cover_url' => null,
            'author_id' => 4,
            'category_id' => 1,
        ],
        [
            'title' => 'Мастер и Маргарита',
            'description' => 'Мистический роман о дьяволе, посетившем советскую Москву.',
            'year' => 1967,
            'total_pages' => 480,
            'cover_url' => null,
            'author_id' => 5,
            'category_id' => 3,
        ],
        [
            'title' => 'Собачье сердце',
            'description' => 'Повесть о превращении бездомного пса в человека.',
            'year' => 1925,
            'total_pages' => 160,
            'cover_url' => null,
            'author_id' => 5,
            'category_id' => 1,
        ],
        [
            'title' => 'Роковые яйца',
            'description' => 'Фантастическая повесть о необычном эксперименте профессора Персикова.',
            'year' => 1925,
            'total_pages' => 144,
            'cover_url' => null,
            'author_id' => 5,
            'category_id' => 1,
        ],
        [
            'title' => 'Гарри Поттер и Философский камень',
            'description' => 'Первый роман о мальчике-волшебнике Гарри Поттере.',
            'year' => 1997,
            'total_pages' => 432,
            'cover_url' => null,
            'author_id' => 6,
            'category_id' => 1,
        ],
        [
            'title' => 'Гарри Поттер и Тайная комната',
            'description' => 'Вторая книга о приключениях Гарри в Хогвартсе.',
            'year' => 1998,
            'total_pages' => 480,
            'cover_url' => null,
            'author_id' => 6,
            'category_id' => 1,
        ],
        [
            'title' => 'Гарри Поттер и Узник Азкабана',
            'description' => 'Третья часть саги о юном волшебнике.',
            'year' => 1999,
            'total_pages' => 528,
            'cover_url' => null,
            'author_id' => 6,
            'category_id' => 1,
        ],
    ];

    public function run(): void
    {
        foreach ($this->books as $book) {
            Book::create($book);
        }
    }
}
