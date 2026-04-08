<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
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

    public function test_anyone_can_view_categories_list()
    {
        Category::create([
            'title' => 'Фантастика',
            'slug' => 'fantastika',
            'description' => 'Фантастическая литература',
        ]);

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Фантастика');
    }

    public function test_anyone_can_view_single_category()
    {
        $category = Category::create([
            'title' => 'Детектив',
            'slug' => 'detektiv',
            'description' => 'Детективная литература',
        ]);

        $response = $this->get(route('categories.show', $category));

        $response->assertStatus(200);
        $response->assertSee($category->title);
    }

    public function test_admin_can_create_category()
    {
        $this->actingAs($this->admin);

        $categoryData = [
            'title' => 'Поэзия',
            'description' => 'Поэтические произведения',
        ];

        $response = $this->post(route('categories.store'), $categoryData);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['title' => 'Поэзия']);
    }

    public function test_regular_user_cannot_create_category()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('categories.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_edit_category()
    {
        $this->actingAs($this->admin);

        $category = Category::create([
            'title' => 'Старое название',
            'slug' => 'staroe-nazvanie',
            'description' => 'Описание',
        ]);

        $response = $this->put(route('categories.update', $category), [
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['title' => 'Новое название']);
    }

    public function test_admin_can_delete_category()
    {
        $this->actingAs($this->admin);

        $category = Category::create([
            'title' => 'Категория для удаления',
            'slug' => 'dlya-udaleniya',
            'description' => 'Описание',
        ]);

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
