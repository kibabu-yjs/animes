<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Anime extends Model
{
    
    public function author():BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}

