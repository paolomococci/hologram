<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
