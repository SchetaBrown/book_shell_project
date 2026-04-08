@extends('layouts.app-layout')

@section('title', 'Редактировать автора')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">✏️ Редактировать автора</h1>
            <a href="{{ route('authors.index') }}" class="text-gray-600 hover:text-gray-800">← Назад</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('authors.update', $author) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Фамилия *</label>
                        <input type="text" name="surname" value="{{ old('surname', $author->surname) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('surname') border-red-500 @enderror"
                            required>
                        @error('surname')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Имя *</label>
                        <input type="text" name="name" value="{{ old('name', $author->name) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Отчество</label>
                    <input type="text" name="patronymic" value="{{ old('patronymic', $author->patronymic) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Дата рождения *</label>
                    <input type="date" name="birth_date"
                        value="{{ old('birth_date', $author->birth_date->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('birth_date') border-red-500 @enderror"
                        required>
                    @error('birth_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Биография *</label>
                    <textarea name="biography" rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('biography') border-red-500 @enderror"
                        required>{{ old('biography', $author->biography) }}</textarea>
                    @error('biography')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
