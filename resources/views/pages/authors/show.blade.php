@extends('layouts.app-layout')

@section('title', $author->full_name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $author->full_name }}</h1>
                <p class="text-gray-600 mt-1">Дата рождения: {{ $author->birth_date->format('d.m.Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('authors.edit', $author) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">✏️ Редактировать</a>
                <form method="POST" action="{{ route('authors.destroy', $author) }}"
                    onsubmit="return confirm('Точно удалить?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">🗑️ Удалить</button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-3">📖 Биография</h2>
            <p class="text-gray-700 leading-relaxed">{{ $author->biography }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📚 Книги автора ({{ $author->books->count() }})</h2>

            @if ($author->books->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($author->books as $book)
                        <div class="border rounded-lg p-4 hover:shadow transition">
                            <a href="{{ route('books.show', $book) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium text-lg">
                                {{ $book->title }}
                            </a>
                            @if ($book->category)
                                <p class="text-gray-500 text-sm mt-1">Категория: {{ $book->category->title }}</p>
                            @endif
                            @if ($book->year)
                                <p class="text-gray-500 text-sm">Год: {{ $book->year }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">У этого автора пока нет книг</p>
            @endif
        </div>
    </div>
@endsection
