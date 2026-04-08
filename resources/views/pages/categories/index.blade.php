@extends('layouts.app-layout')

@section('title', 'Категории')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📑 Категории</h1>
        @if (auth()->user() && auth()->user()->isAdmin())
            <a href="{{ route('categories.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Добавить категорию
            </a>
        @endif
    </div>

    @if ($categories->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">
                                <a href="{{ route('categories.show', $category) }}" class="hover:text-blue-600">
                                    {{ $category->title }}
                                </a>
                            </h3>
                            @if (auth()->user() && auth()->user()->isAdmin())
                                <div class="flex space-x-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="text-yellow-600 hover:text-yellow-800">✏️</a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                        onsubmit="return confirm('Точно удалить категорию?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        @if ($category->description)
                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($category->description, 100) }}</p>
                        @endif

                        <div class="mt-3 pt-3 border-t text-sm text-gray-500">
                            Книг в категории: {{ $category->books_count }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">Пока нет категорий</p>
            <a href="{{ route('categories.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Добавить
                первую категорию</a>
        </div>
    @endif
@endsection
