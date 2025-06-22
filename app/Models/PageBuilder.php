<?php

namespace App\Models;

use App\Enums\PageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageBuilder extends Model
{
    use SoftDeletes;

    protected $table = 'pages';
    protected $guarded = ['id'];

    public function resource()
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'relationships' => 'array',
            'status' => PageStatus::class,
        ];
    }
}
