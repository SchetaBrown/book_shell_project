@extends('layouts.app-layout')

@section('title', $book->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>
            <div class="flex space-x-2">
                @auth
                    @php
                        $userBook = Auth::user()->books()->where('book_id', $book->id)->first();
                    @endphp

                    @if ($userBook)
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg flex items-center gap-2">
                            ✓ В моей библиотеке
                        </span>
                    @else
                        <form method="POST" action="{{ route('profile.add-book', $book) }}">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                                📚 В библиотеку
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
                        🔒 Войдите, чтобы добавить
                    </a>
                @endauth

                @if (auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('books.edit', $book) }}"
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">✏️
                        Редактировать</a>
                    <form method="POST" action="{{ route('books.destroy', $book) }}"
                        onsubmit="return confirm('Точно удалить книгу?')">
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if ($book->cover_url)
                    <div>
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow">
                    </div>
                @endif

                <div class="{{ $book->cover_url ? 'md:col-span-2' : 'md:col-span-3' }}">
                    <div class="space-y-3">
                        <p><span class="font-semibold">Автор:</span> <a href="{{ route('authors.show', $book->author) }}"
                                class="text-blue-600 hover:text-blue-800">{{ $book->author->fullName() }}</a></p>

                        @if ($book->category)
                            <p><span class="font-semibold">Категория:</span> {{ $book->category->title }}</p>
                        @endif

                        @if ($book->year)
                            <p><span class="font-semibold">Год издания:</span> {{ $book->year }}</p>
                        @endif

                        @if ($book->total_pages)
                            <p><span class="font-semibold">Страниц:</span> {{ $book->total_pages }}</p>
                        @endif
                    </div>
                </div>
            </div>

            @if ($book->description)
                <div class="mt-6 pt-6 border-t">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">📖 Описание</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
