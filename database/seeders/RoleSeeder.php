<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private array $roles = [
        [
            'title' => 'пользователь',
            'slug' => 'user',
        ],
        [
            'title' => 'администратор',
            'slug' => 'admin',
        ],
    ];
    
    public function run(): void
    {
        foreach ($this->roles as $role) {
            Role::create($role);
        }
    }
}
