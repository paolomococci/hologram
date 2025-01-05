<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleForm extends Form
{
    public ?Article $article;

    #[Locked]
    public int $id;

    #[Validate('required')]
    public string $title;

    #[Validate('required')]
    public string $content;

    public bool $deprecated;

    public function create(Article $article) {}

    public function read(int $id) {}

    public function index() {}

    public function update(int $id) {}

    public function delete(int $id) {}
}
