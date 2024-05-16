<?php

namespace App\Models;

use App\Utils\SanitizerUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $connection = 'quotesdb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'subject', 'summary', 'content', 'deprecated',
    ];

    /**
     * getRelatedAuthors
     *
     * @param  int  $authorId
     * @return array
     */
    public function getRelatedAuthors()
    {
        $authors = [];
        $merits = Merit::where('article_id', $this->id)->get();
        foreach ($merits as $merit) {
            $authors[] = Author::findOrFail($merit['author_id']);
        }

        return $authors;
    }

    public static function rehydrate(mixed &$articles) {
        foreach ($articles as $article) {
            $article['title'] = SanitizerUtil::rehydrate($article['title']);
            $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
            $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
            $article['content'] = SanitizerUtil::rehydrate($article['content']);
            $article['deprecated'] = $article['deprecated'];
        }
    }
}
