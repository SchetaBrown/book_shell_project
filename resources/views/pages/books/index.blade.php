@extends('layouts.app-layout')

@section('title', 'Книги')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📚 Книги</h1>
        @auth
            @if (Auth::user()->isAdmin())
                <a href="{{ route('books.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Добавить книгу
                </a>
            @endif
        @endauth
    </div>

    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Поиск по названию..." value="{{ request('search') }}"
                class="px-3 py-2 border border-gray-300 rounded-lg">

            <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Все категории</option>
                @foreach ($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>

            <select name="author" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Все авторы</option>
                @foreach ($authors ?? [] as $author)
                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                        {{ $author->fullName() }}
                    </option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Фильтровать
                </button>

                <a href="{{ route('books.index') }}"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition text-center">
                    Сбросить
                </a>
            </div>
        </form>

        @if (request()->anyFilled(['search', 'category', 'author']))
            <div class="mt-3 pt-3 border-t flex flex-wrap gap-2 items-center">
                <span class="text-sm text-gray-600">Активные фильтры:</span>

                @if (request('search'))
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full flex items-center gap-1">
                        Поиск: "{{ request('search') }}"
                        <a href="{{ route('books.index', array_merge(request()->except('search'), ['search' => null])) }}"
                            class="hover:text-blue-600">&times;</a>
                    </span>
                @endif

                @if (request('category'))
                    @php
                        $categoryName =
                            $categories->firstWhere('id', request('category'))?->title ?? request('category');
                    @endphp
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full flex items-center gap-1">
                        Категория: {{ $categoryName }}
                        <a href="{{ route('books.index', array_merge(request()->except('category'), ['category' => null])) }}"
                            class="hover:text-blue-600">&times;</a>
                    </span>
                @endif

                @if (request('author'))
                    @php
                        $authorName = $authors->firstWhere('id', request('author'))?->fullName() ?? request('author');
                    @endphp
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full flex items-center gap-1">
                        Автор: {{ $authorName }}
                        <a href="{{ route('books.index', array_merge(request()->except('author'), ['author' => null])) }}"
                            class="hover:text-blue-600">&times;</a>
                    </span>
                @endif
            </div>
        @endif
    </div>

    @if ($books->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($books as $book)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col">
                    <div class="flex-grow">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">
                            <a href="{{ route('books.show', $book) }}" class="hover:text-blue-600">{{ $book->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-2">
                            Автор: <a href="{{ route('authors.show', $book->author) }}"
                                class="text-blue-500 hover:text-blue-700">{{ $book->author->fullName() }}</a>
                        </p>
                        @if ($book->category)
                            <p class="text-gray-500 text-xs mb-2">Категория: {{ $book->category->title }}</p>
                        @endif
                        @if ($book->year)
                            <p class="text-gray-500 text-xs">Год: {{ $book->year }}</p>
                        @endif
                        @if ($book->description)
                            <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ Str::limit($book->description, 100) }}
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mt-3 pt-3 border-t">
                        @auth
                            @php
                                $userBook = Auth::user()->books()->where('book_id', $book->id)->first();
                            @endphp

                            @if ($userBook)
                                <span class="text-green-600 text-sm flex items-center gap-1">
                                    ✓ В моей библиотеке
                                </span>
                            @else
                                <form method="POST" action="{{ route('profile.add-book', $book) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700 transition flex items-center gap-1">
                                        📚 В библиотеку
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login.create') }}" class="text-gray-500 text-sm hover:text-blue-600 transition">
                                🔒 Войдите, чтобы добавить
                            </a>
                        @endauth

                        @auth
                            @if (Auth::user()->isAdmin())
                                <div class="flex space-x-2">
                                    <a href="{{ route('books.edit', $book) }}"
                                        class="text-yellow-600 hover:text-yellow-800">✏️</a>
                                    <form method="POST" action="{{ route('books.destroy', $book) }}"
                                        onsubmit="return confirm('Точно удалить книгу?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">По вашему запросу ничего не найдено</p>
            <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                🔄 Сбросить фильтры
            </a>
        </div>
    @endif
@endsection
