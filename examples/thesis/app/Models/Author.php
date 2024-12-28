<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'nickname',
        'email',
        'isSuspended',
        'email_checked_at',
        'temporary_token',
    ];

    protected $casts = [
        'isSuspended' => 'boolean',
    ];

    /**
     * getRelatedArticles
     *
     * @param  int  $authorId
     */
    public function getRelatedArticles(): array
    {
        $contributions = [];
        $increases = Contributor::where('author_id', $this->id)->get();
        foreach ($increases as $increase) {
            $contribution = [
                'article' => Article::findOrFail($increase['article_id']),
                'isMain' => ($increase['is_main_author']) ? true : false,
            ];
            $contributions[] = $contribution;
        }

        return $contributions;
    }
}
