<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedDocument extends Model
{
    /** @use HasFactory<\Database\Factories\ScannedDocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'size',
        'content',
    ];
}
