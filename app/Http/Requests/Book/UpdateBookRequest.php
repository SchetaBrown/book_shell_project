<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'total_pages' => 'nullable|integer|min:1',
            'cover_url' => 'nullable|url',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }
}
