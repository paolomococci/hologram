<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthorArticle extends Pivot
{
    protected $connection = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_main_author',
    ];

    /**
     * authors
     *
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * articles
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
