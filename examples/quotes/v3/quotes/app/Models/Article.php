<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
