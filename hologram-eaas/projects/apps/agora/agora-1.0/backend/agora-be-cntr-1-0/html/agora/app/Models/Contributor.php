<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contributor extends Pivot
{
    protected $connection = 'agora-db-cntr-1-0';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_main_author',
        'article_id',
        'author_id',
    ];

    /**
     * authors
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * articles
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
