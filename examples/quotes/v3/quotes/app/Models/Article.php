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
        $contributors = [];
        $merits = Merit::where('article_id', $this->id)->get();
        foreach ($merits as $merit) {
            $contributor = array(
                'author' => Author::findOrFail($merit['author_id']),
                'isMain' => ($merit['is_main_author']) ? true : false,
            );
            $contributors[] = $contributor;
        }
        // dd($contributors);
        // TODO: the value indicating whether or not the following is the main one must also return
        return $contributors;
    }

    /**
     * translates entities into readable characters contained in articles by reference rather than by value
     *
     * @param mixed $articles
     * @return void
     */
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
