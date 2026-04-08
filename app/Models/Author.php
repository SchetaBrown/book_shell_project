<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['surname', 'name', 'patronymic', 'biography', 'birth_date'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function fullName()
    {
        $fullName = $this->surname . ' ' . $this->name;
        if ($this->patronymic) {
            $fullName .= ' ' . $this->patronymic;
        }
        return $fullName;
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
