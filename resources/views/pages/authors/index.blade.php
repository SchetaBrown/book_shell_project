@extends('layouts.app-layout')

@section('title', 'Авторы')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✍️ Авторы</h1>
        <a href="{{ route('authors.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Добавить автора
        </a>
    </div>

    @if ($authors->count())
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ФИО</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата
                            рождения</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Книг</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($authors as $author)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('authors.show', $author) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $author->fullName() }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $author->birth_date->format('d.m.Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $author->books_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('authors.edit', $author) }}"
                                        class="text-yellow-600 hover:text-yellow-800">✏️</a>
                                    <form method="POST" action="{{ route('authors.destroy', $author) }}"
                                        onsubmit="return confirm('Точно удалить автора? Все его книги тоже удалятся!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $authors->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">Пока нет авторов</p>
            <a href="{{ route('authors.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Добавить
                первого автора</a>
        </div>
    @endif
@endsection
