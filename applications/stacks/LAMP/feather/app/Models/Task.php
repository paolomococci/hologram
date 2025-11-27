<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Task
 */
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['tag', 'description', 'is_done', 'resources', 'spreadsheet_path'];

    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'is_done'   => 'boolean',
        'resources' => 'array',
    ];
}
