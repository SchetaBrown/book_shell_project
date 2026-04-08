<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;
    protected $author;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаём роли
        $userRole = Role::create(['title' => 'Пользователь', 'slug' => 'user']);
        $adminRole = Role::create(['title' => 'Администратор', 'slug' => 'admin']);

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $userRole->id,
        ]);

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        $this->author = Author::create([
            'surname' => 'Толстой',
            'name' => 'Лев',
            'patronymic' => 'Николаевич',
            'biography' => 'Великий русский писатель.',
            'birth_date' => '1828-09-09',
        ]);

        $this->category = Category::create([
            'title' => 'Классика',
            'slug' => 'klassika',
            'description' => 'Классическая литература',
        ]);
    }

    /** @test */
    public function test_anyone_can_view_books_list()
    {
        Book::create([
            'title' => 'Test Book',
            'author_id' => $this->author->id,
            'category_id' => $this->category->id,
            'year' => 2020,
        ]);

        $response = $this->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Book');
    }

    /** @test */
    public function test_anyone_can_view_single_book()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'author_id' => $this->author->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->get(route('books.show', $book));

        $response->assertStatus(200);
        $response->assertSee($book->title);
    }

    /** @test */
    public function test_admin_can_create_book()
    {
        $this->actingAs($this->admin);

        $bookData = [
            'title' => 'New Book',
            'description' => 'Book description',
            'year' => 2024,
            'total_pages' => 300,
            'author_id' => $this->author->id,
            'category_id' => $this->category->id,
        ];

        $response = $this->post(route('books.store'), $bookData);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'New Book']);
    }

    /** @test */
    public function test_admin_can_edit_book()
    {
        $this->actingAs($this->admin);

        $book = Book::create([
            'title' => 'Old Title',
            'author_id' => $this->author->id,
        ]);

        $response = $this->put(route('books.update', $book), [
            'title' => 'Updated Title',
            'author_id' => $this->author->id,
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'Updated Title']);
    }

    /** @test */
    public function test_admin_can_delete_book()
    {
        $this->actingAs($this->admin);

        $book = Book::create([
            'title' => 'Book to Delete',
            'author_id' => $this->author->id,
        ]);

        $response = $this->delete(route('books.destroy', $book));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /** @test */
    public function test_user_can_add_book_to_library()
    {
        $this->actingAs($this->user);

        $book = Book::create([
            'title' => 'Book to Add',
            'author_id' => $this->author->id,
        ]);

        $response = $this->post(route('profile.store', $book));

        $response->assertRedirect();
        $this->assertDatabaseHas('book_user', [
            'user_id' => $this->user->id,
            'book_id' => $book->id,
        ]);
    }

    /** @test */
    public function test_user_cannot_add_same_book_twice()
    {
        $this->actingAs($this->user);

        $book = Book::create([
            'title' => 'Book to Add',
            'author_id' => $this->author->id,
        ]);

        $this->post(route('profile.store', $book));
        $response = $this->post(route('profile.store', $book));

        $response->assertSessionHas('error');
    }

    /** @test */
    public function test_user_can_remove_book_from_library()
    {
        $this->actingAs($this->user);

        $book = Book::create([
            'title' => 'Book to Remove',
            'author_id' => $this->author->id,
        ]);

        // Сначала добавляем
        $this->post(route('profile.store', $book));

        // Потом удаляем
        $response = $this->delete(route('profile.destroy', $book));

        $response->assertRedirect();
        $this->assertDatabaseMissing('book_user', [
            'user_id' => $this->user->id,
            'book_id' => $book->id,
        ]);
    }
}
