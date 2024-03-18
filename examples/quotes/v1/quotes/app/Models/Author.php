<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;
    protected $connection = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'surname', 'nickname', 'email', 'suspended',
    ];

    /**
     * articles
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->using(AuthorArticle::class);
    }

    /**
     * getRelatedArticles
     *
     * this is a workaround
     *
     * @param  int $authorId
     * @return array
     */
    public function getRelatedArticles()
    {
        $articles = [];
        $contributions = Contributor::where('author_id', $this->id)->get();
        foreach ($contributions as $article) {
            $articles[] = Article::findOrFail($article['article_id']);
        }
        return $articles;
    }
}
