<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаём роль перед тестами
        $role = Role::create([
            'title' => 'Пользователь',
            'slug' => 'user',
        ]);

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role_id' => $role->id,
        ]);
    }

    public function test_user_can_view_login_page()
    {
        $response = $this->get(route('login.create'));
        $response->assertStatus(200);
        $response->assertSee('Вход');
    }

    public function test_user_cannot_login_with_wrong_password()
    {
        $response = $this->post(route('login.store'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_view_register_page()
    {
        $response = $this->get(route('register.create'));
        $response->assertStatus(200);
        $response->assertSee('Регистрация');
    }

    /** @test */
    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post(route('register.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => 'New User',
        ]);
    }

    /** @test */
    public function test_user_cannot_register_with_existing_email()
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function test_user_can_logout()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login.create'));
        $this->assertGuest();
    }

    /** @test */
    public function test_authenticated_user_can_view_profile()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('profile.show'));

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }
}
