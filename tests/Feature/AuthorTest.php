<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Author;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

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
    }

    public function test_anyone_can_view_authors_list()
    {
        Author::create([
            'surname' => 'Пушкин',
            'name' => 'Александр',
            'patronymic' => 'Сергеевич',
            'biography' => 'Великий русский поэт.',
            'birth_date' => '1799-06-06',
        ]);

        $response = $this->get(route('authors.index'));

        $response->assertStatus(200);
    }

    public function test_anyone_can_view_single_author()
    {
        $author = Author::create([
            'surname' => 'Пушкин',
            'name' => 'Александр',
            'patronymic' => 'Сергеевич',
            'biography' => 'Великий русский поэт.',
            'birth_date' => '1799-06-06',
        ]);

        $response = $this->get(route('authors.show', $author));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_author()
    {
        $this->actingAs($this->admin);

        $authorData = [
            'surname' => 'Гоголь',
            'name' => 'Николай',
            'patronymic' => 'Васильевич',
            'biography' => 'Русский прозаик и драматург.',
            'birth_date' => '1809-04-01',
        ];

        $response = $this->post(route('authors.store'), $authorData);

        $response->assertRedirect(route('authors.index'));
        $this->assertDatabaseHas('authors', ['surname' => 'Гоголь']);
    }

    public function test_regular_user_cannot_create_author()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('authors.create'));

        $response->assertStatus(302);
    }

    public function test_admin_can_edit_author()
    {
        $this->actingAs($this->admin);

        $author = Author::create([
            'surname' => 'Чехов',
            'name' => 'Антон',
            'patronymic' => 'Павлович',
            'biography' => 'Русский писатель.',
            'birth_date' => '1860-01-29',
        ]);

        $response = $this->put(route('authors.update', $author), [
            'surname' => 'Чехов',
            'name' => 'Антон',
            'patronymic' => 'Павлович',
            'biography' => 'Великий русский писатель и драматург.',
            'birth_date' => '1860-01-29',
        ]);

        $response->assertRedirect(route('authors.index'));
        $this->assertDatabaseHas('authors', ['biography' => 'Великий русский писатель и драматург.']);
    }

    public function test_admin_can_delete_author()
    {
        $this->actingAs($this->admin);

        $author = Author::create([
            'surname' => 'Тургенев',
            'name' => 'Иван',
            'patronymic' => 'Сергеевич',
            'biography' => 'Русский писатель.',
            'birth_date' => '1818-11-09',
        ]);

        $response = $this->delete(route('authors.destroy', $author));

        $response->assertRedirect(route('authors.index'));
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
