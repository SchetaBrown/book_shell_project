<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['name', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Связи
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_user')
            ->withPivot('rating')
            ->withTimestamps();
    }
}
