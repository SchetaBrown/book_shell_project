<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    private array $categories = [
        'Фантастика',
        'Детектив',
        'Классика',
        'Научная литература',
        'Психология',
        'Бизнес',
        'Программирование',
    ];

    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::create([
                'title' => $category,
                'slug' => Str::slug($category),
                'description' => "Книга категории: $category"
            ]);
        }
    }
}
