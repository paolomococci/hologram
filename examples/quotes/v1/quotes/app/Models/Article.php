<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;
    protected $connection = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'subject', 'summary', 'content', 'deprecated',
    ];

    /**
     * authors
     *
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class)->using(AuthorArticle::class);
    }

    /**
     * getRelatedAuthors
     *
     * this is a workaround
     *
     * @param  int $authorId
     * @return array
     */
    public function getRelatedAuthors()
    {
        $authors = [];
        $contributors = Contributor::where('article_id', $this->id)->get();
        foreach ($contributors as $contributor) {
            $authors[] = Author::findOrFail($contributor['author_id']);
        }
        return $authors;
    }
}
