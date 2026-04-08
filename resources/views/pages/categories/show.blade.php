@extends('layouts.app-layout')

@section('title', $category->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-start mb-6 flex-wrap">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $category->title }}</h1>
                @if ($category->description)
                    <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                @endif
            </div>
            <div class="flex space-x-2">
                @if (auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('categories.edit', $category) }}"
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">✏️
                        Редактировать</a>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}"
                        onsubmit="return confirm('Точно удалить категорию?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">🗑️
                            Удалить</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📚 Книги в этой категории ({{ $category->books->count() }})
            </h2>

            @if ($category->books->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($category->books as $book)
                        <div class="border rounded-lg p-4 hover:shadow transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <a href="{{ route('books.show', $book) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-lg">
                                        {{ $book->title }}
                                    </a>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Автор: <a href="{{ route('authors.show', $book->author) }}"
                                            class="text-blue-500 hover:text-blue-700">{{ $book->author->fullName() }}</a>
                                    </p>
                                    @if ($book->year)
                                        <p class="text-gray-500 text-sm">Год: {{ $book->year }}</p>
                                    @endif
                                </div>

                                <div class="ml-4">
                                    @auth
                                        @php
                                            $userBook = Auth::user()->books()->where('book_id', $book->id)->first();
                                        @endphp

                                        @if ($userBook)
                                            <span class="text-green-600 text-sm flex items-center gap-1 whitespace-nowrap">
                                                ✓ В библиотеке
                                            </span>
                                        @else
                                            <form method="POST" action="{{ route('profile.store', $book) }}"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700 transition whitespace-nowrap">
                                                    📚 В библиотеку
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login.create') }}"
                                            class="text-gray-500 text-sm hover:text-blue-600 transition whitespace-nowrap">
                                            🔒 Войдите
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">В этой категории пока нет книг</p>
            @endif
        </div>
    </div>
@endsection
