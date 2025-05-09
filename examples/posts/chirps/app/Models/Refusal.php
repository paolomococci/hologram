<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refusal extends Model
{
    /** @use HasFactory<\Database\Factories\RefusalFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'original_created_at',
        'original_updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
