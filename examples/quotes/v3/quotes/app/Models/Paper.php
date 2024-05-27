<?php

namespace App\Models;

use App\Utils\SanitizerUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paper extends Model
{
    use HasFactory;

    protected $connection = 'quotesdb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'name', 'size', 'content',
    ];

    /**
     * translates entities into readable characters contained in papers by reference rather than by value
     *
     * @param mixed $papers
     * @return void
     */
    public static function rehydrate(mixed &$papers) {
        foreach ($papers as $paper) {
            $paper['title'] = SanitizerUtil::rehydrate($paper['title']);
            $paper['content'] = SanitizerUtil::rehydrate($paper['content']);
        }
    }
}
