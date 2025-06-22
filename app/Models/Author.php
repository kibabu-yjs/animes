<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    public function animes(): HasMany
    {
        return $this->hasMany(Anime::class);
    }
}
