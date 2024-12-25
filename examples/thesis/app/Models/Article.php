<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'content',
        'deprecated',
        'published',
        'notifications',
        'image_path',
        'sortable_token',
    ];

    protected $casts = [
        'published' => 'boolean',
        'notifications' => 'array',
    ];

    /**
     * getRelatedAuthors
     *
     * @param  int  $authorId
     */
    public function getRelatedAuthors(): array
    {
        $contributors = [];
        $increases = Contributor::where('article_id', $this->id)->get();
        foreach ($increases as $increase) {
            $contributor = [
                'author' => Author::findOrFail($increase['author_id']),
                'isMain' => ($increase['is_main_author']) ? true : false,
            ];
            $contributors[] = $contributor;
        }

        return $contributors;
    }
}