<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private array $users = [
        [
            'name' => 'Ivan Ivanov',
            'email' => 'ivan@example.com',
            'password' => 'password',
            'role_id' => 1,
        ],
        [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role_id' => 2,
        ],
    ];
    public function run(): void
    {
        foreach ($this->users as $user) {
            User::create($user);
        }
    }
}
