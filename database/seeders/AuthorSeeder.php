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
            'biography' => 'Великий русский писатель и мыслитель.',
            'birth_date' => '1828-09-09',
        ],
        [
            'surname' => 'Достоевский',
            'name' => 'Фёдор',
            'patronymic' => 'Михайлович',
            'biography' => 'Русский писатель, мыслитель и публицист.',
            'birth_date' => '1821-11-11',
        ],
        [
            'surname' => 'Лукьяненко',
            'name' => 'Сергей',
            'patronymic' => 'Васильевич',
            'biography' => 'Советский и российский писатель-фантаст.',
            'birth_date' => '1968-04-11',
        ],
    ];
    
    public function run(): void
    {
        foreach($this->authors as $author) {
            Author::create($author);
        }
    }
}
