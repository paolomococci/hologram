<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * getRelatedArticles
     *
     * this is a workaround
     *
     * @param  int  $authorId
     * @return array
     */
    public function getRelatedArticles()
    {
        $articles = [];
        $merits = Merit::where('author_id', $this->id)->get();
        foreach ($merits as $article) {
            $articles[] = Article::findOrFail($article['article_id']);
        }

        return $articles;
    }
}
