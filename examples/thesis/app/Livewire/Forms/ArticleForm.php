<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleForm extends Form
{
    public ?Article $article;

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('max:255')]
    public string $subject = '';

    #[Validate('required')]
    public string $content = '';

    public function set(Article $article)
    {
        $this->title = $article->title;
        $this->subject = $article->subject;
        $this->content = $article->content;
        $this->article = $article;
    }

    public function save()
    {
        $this->validate();
        Article::create($this->only(
            'title',
            'subject',
            'content',
        ));
    }

    public function update()
    {
        $this->validate();
        $this->article->update($this->only(
            'title',
            'subject',
            'content',
        ));
    }
}
