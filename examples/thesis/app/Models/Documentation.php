<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentationFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];
}
