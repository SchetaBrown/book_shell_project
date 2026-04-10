@extends('layouts.app-layout')

@section('title', 'Мой профиль')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">👤 Мой профиль</h1>
            <a href="{{ route('profile.edit') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                ✏️ Редактировать профиль
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full mx-auto flex items-center justify-center text-white text-4xl font-bold mb-4">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ Auth::user()->email }}</p>

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Дата регистрации:</span>
                                <span class="text-gray-700">{{ Auth::user()->created_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-500">Роль:</span>
                                <span class="text-gray-700">{{ Auth::user()->role->title ?? 'Пользователь' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $userBooks->count() }}</div>
                        <div class="text-gray-500 text-sm">Всего книг</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $userBooks->where('pivot.created_at', '>=', now()->subDays(30))->count() }}</div>
                        <div class="text-gray-500 text-sm">За 30 дней</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">📚 Моя библиотека</h3>
                    </div>

                    @if ($userBooks->count())
                        <div class="divide-y">
                            @foreach ($userBooks as $book)
                                <div class="p-4 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <a href="{{ route('books.show', $book) }}"
                                                    class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                                                    {{ $book->title }}
                                                </a>

                                            </div>

                                            <p class="text-gray-600 text-sm mt-1">
                                                Автор: <a href="{{ route('authors.show', $book->author) }}"
                                                    class="text-blue-500 hover:text-blue-700">{{ $book->author->fullName() }}</a>
                                            </p>

                                            @if ($book->category)
                                                <p class="text-gray-500 text-xs mt-1">Категория:
                                                    {{ $book->category->title }}</p>
                                            @endif

                                            <div class="flex gap-4 mt-3">
                                                <form method="POST" action="{{ route('profile.destroy', $book) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Удалить книгу из библиотеки?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                                        🗑️ Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <p class="text-gray-500">У вас пока нет книг в библиотеке</p>
                            <a href="{{ route('books.index') }}"
                                class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                                📚 Добавить книги
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="notesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-4 border-b">
                <h3 class="text-lg font-bold">📝 Заметки о книге</h3>
            </div>
            <form id="notesForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-4">
                    <textarea name="notes" id="notesText" rows="5"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Ваши заметки о книге..."></textarea>
                </div>
                <div class="p-4 border-t flex justify-end gap-2">
                    <button type="button" onclick="closeNotesModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Отмена</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function closeNotesModal() {
            const modal = document.getElementById('notesModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('notesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNotesModal();
            }
        });
    </script>
@endsection
