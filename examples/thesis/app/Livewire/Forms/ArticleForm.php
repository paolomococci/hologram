<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Article;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

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

    public $notifications = [];

    public bool $allowNotifications = false;

    // field image_path
    public string $imagePath = '';

    // field sortable_token
    public string $sortableToken = '';

    public function set(Article $article)
    {
        $this->title = $article->title;
        $this->subject = $article->subject;
        $this->content = $article->content;
        $this->published = $article->published;
        $this->notifications = $article->notifications;

        $this->article = $article;
    }

    public function save()
    {
        $this->validate();

        if ($this->allowNotifications == false) {
            $this->notifications = [];
        }

        $this->sortableToken = Str::ulid()->toBase32();

        try {
            Article::create($this->only(
                'title',
                'subject',
                'content',
                'published',
                'notifications',
                'sortable_token',
            ));
        } catch (\Exception $e) {
            //throw $e;
        }
    }

    public function update()
    {
        $this->validate();

        if ($this->allowNotifications == false) {
            $this->notifications = [];
        }

        try {
            $this->article->update($this->only(
                'title',
                'subject',
                'content',
                'published',
                'notifications',
            ));
        } catch (\Exception $e) {
            //throw $e;
        }
    }
}
