@extends('layouts.app-layout')

@section('title', 'Главная')

@section('content')
    <div class="space-y-12">

        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl text-white p-8">
            <h1 class="text-4xl font-bold mb-4">
                Добро пожаловать в BookLibrary
            </h1>
            <p class="text-xl opacity-90">
                Ваша персональная библиотека книг. Добавляйте книги, оценивайте их и делитесь впечатлениями.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Всего книг</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalBooks ?? 0 }}</p>
                    </div>
                    <div class="text-4xl">📚</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Всего авторов</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalAuthors ?? 0 }}</p>
                    </div>
                    <div class="text-4xl">✍️</div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">📖 Последние добавленные книги</h2>
                <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-700">Все книги →</a>
            </div>

            @if (isset($latestBooks) && $latestBooks->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($latestBooks as $book)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                            <h3 class="font-bold text-lg text-gray-800 mb-2">
                                <a href="{{ route('books.show', $book) }}" class="hover:text-blue-600">
                                    {{ $book->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-2">
                                Автор: {{ $book->author->full_name ?? 'Неизвестен' }}
                            </p>
                            @if ($book->category)
                                <p class="text-gray-500 text-xs">
                                    Категория: {{ $book->category->title }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Пока нет книг...</p>
            @endif
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">🏆 Популярные авторы</h2>

            @if (isset($popularAuthors) && $popularAuthors->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($popularAuthors as $author)
                        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                            <div>
                                <a href="{{ route('authors.show', $author) }}"
                                    class="font-semibold text-gray-800 hover:text-blue-600">
                                    {{ $author->fullName() }}
                                </a>
                                <p class="text-gray-500 text-sm">Книг: {{ $author->books_count }}</p>
                            </div>
                            <div class="text-2xl">📕</div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Пока нет авторов...</p>
            @endif
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📑 Категории</h2>

            @if (isset($categories) && $categories->count())
                <div class="flex flex-wrap gap-2">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category) }}"
                            class="bg-gray-200 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-full text-gray-700 transition">
                            {{ $category->title }} ({{ $category->books_count }})
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Пока нет категорий...</p>
            @endif
        </div>

    </div>
@endsection
