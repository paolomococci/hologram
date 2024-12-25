<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Illuminate\Support\Str;
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

    public bool $published = false;

    public bool $deprecated = false;

    public $notifications = [];

    public bool $allowNotifications = false;

    public string $image_path = '';

    public string $sortable_token = '';

    public function save()
    {
        $this->validate();

        if ($this->allowNotifications == false) {
            $this->notifications = [];
        }

        $this->sortable_token = Str::ulid()->toBase32();
        $this->title .= ' (' . $this->sortable_token . ')';

        try {
            Article::create($this->only(
                'title',
                'subject',
                'content',
                'published',
                'deprecated',
                'notifications',
                'sortable_token',
            ));
        } catch (\Exception $e) {
            //throw $e;
        }
    }

    public function setArticleFields(Article $article)
    {
        $this->title = $article->title;
        $this->subject = $article->subject;
        $this->content = $article->content;
        $this->published = $article->published;
        $this->deprecated = $article->deprecated;
        $this->notifications = $article->notifications;
        $this->sortable_token = $article->sortable_token;

        $this->article = $article;
    }

    public function update()
    {
        $this->validate();

        if ($this->allowNotifications == false) {
            $this->notifications = [];
        }

        $this->title .= ' (' . $this->sortable_token . ')';

        try {
            $this->article->update($this->only(
                'title',
                'subject',
                'content',
                'published',
                'deprecated',
                'notifications',
            ));
        } catch (\Exception $e) {
            //throw $e;
        }
    }
}
