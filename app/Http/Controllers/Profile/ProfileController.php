<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $userBooks = $user->books()->with('author')->get();

        return view('profile.show', compact('user', 'userBooks'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.show')->with('success', 'Профиль обновлён');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Пароль обновлён');
    }

    public function addBookToLibrary(Request $request, Book $book)
    {
        $user = Auth::user();

        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $user->books()->attach($book->id, [
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Книга добавлена в библиотеку');
    }

    public function removeBookFromLibrary(Book $book)
    {
        Auth::user()->books()->detach($book->id);
        return back()->with('success', 'Книга удалена из библиотеки');
    }
}
