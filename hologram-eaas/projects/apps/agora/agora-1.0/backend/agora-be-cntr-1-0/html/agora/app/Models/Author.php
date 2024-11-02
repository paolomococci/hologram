<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    protected $connection = 'agora-db-cntr-1-0';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'email_checked_at',
        'temporary_token',
        'suspended',
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
        $merits = Contributor::where('author_id', $this->id)->get();
        foreach ($merits as $merit) {
            $contribution = [
                'article' => Article::findOrFail($merit['article_id']),
                'isMain' =>($merit['is_main_author']) ? true : false
            ];
            $contributions[] = $contribution;
        }

        return $contributions;
    }
}
