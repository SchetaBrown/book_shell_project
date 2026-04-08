<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    private array $authors = [
        [
            'surname' => 'Толстой',
            'name' => 'Лев',
            'patronymic' => 'Николаевич',
            'biography' => 'Великий русский писатель и мыслитель. Автор романов «Война и мир», «Анна Каренина» и других.',
            'birth_date' => '1828-09-09',
        ],
        [
            'surname' => 'Достоевский',
            'name' => 'Фёдор',
            'patronymic' => 'Михайлович',
            'biography' => 'Русский писатель, мыслитель и публицист. Автор «Преступления и наказания», «Идиота», «Братьев Карамазовых».',
            'birth_date' => '1821-11-11',
        ],
        [
            'surname' => 'Лукьяненко',
            'name' => 'Сергей',
            'patronymic' => 'Васильевич',
            'biography' => 'Советский и российский писатель-фантаст. Автор цикла «Дозоры».',
            'birth_date' => '1968-04-11',
        ],
        [
            'surname' => 'Оруэлл',
            'name' => 'Джордж',
            'patronymic' => null,
            'biography' => 'Английский писатель и публицист, автор культовых антиутопий «1984» и «Скотный двор».',
            'birth_date' => '1903-06-25',
        ],
        [
            'surname' => 'Булгаков',
            'name' => 'Михаил',
            'patronymic' => 'Афанасьевич',
            'biography' => 'Русский писатель, драматург и театральный режиссёр. Автор «Мастера и Маргариты», «Собачьего сердца».',
            'birth_date' => '1891-05-15',
        ],
        [
            'surname' => 'Роулинг',
            'name' => 'Джоан',
            'patronymic' => null,
            'biography' => 'Британская писательница, автор серии романов о Гарри Поттере.',
            'birth_date' => '1965-07-31',
        ],
    ];

    public function run(): void
    {
        foreach ($this->authors as $author) {
            Author::create($author);
        }
    }
}
