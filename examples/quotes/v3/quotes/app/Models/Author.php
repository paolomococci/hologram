<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $connection = 'quotesdb';

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
     * @param  int  $authorId
     * @return array
     */
    public function getRelatedArticles()
    {
        $contributions = [];
        $merits = Merit::where('author_id', $this->id)->get();
        foreach ($merits as $merit) {
            // $articles[] = Article::findOrFail($article['article_id']);
            $contribution = [
                'article' => Article::findOrFail($merit['article_id']),
                'isMain' =>($merit['is_main_author']) ? true : false
            ];
            $contributions[] = $contribution;
        }
        // dd($contributions);

        return $contributions;
    }
}
