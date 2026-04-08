<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['title', 'slug'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                return mb_ucfirst($value);
            }
        );
    }
}
