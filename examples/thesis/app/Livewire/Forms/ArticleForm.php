<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleForm extends Form
{
    public ?Article $article;

    #[Locked]
    public int $id;

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('max:255')]
    public string $subject = '';

    #[Validate('required')]
    public string $content = '';

    public bool $isPublished = false;

    public bool $isDeprecated = false;

    public $notifications = [];

    public bool $allowNotifications = false;

    public $image_path = [];

    // multiple images upload
    #[Validate(['imageObject.*' => 'image|max:1024'])]
    public $imageObject = [];

    public string $sortable_token = '';

    public function save()
    {
        $this->validate();

        if ($this->allowNotifications == false) {
            $this->notifications = [];
        }

        $this->sortable_token = Str::ulid()->toBase32();
        $this->title .= ' (' . $this->sortable_token . ')';

        // multiple image upload
        $lastAssignedId = Article::orderBy('id', 'DESC')->first()->id;
        $lastAssignedIdIncremented = $lastAssignedId + 1;
        if ($this->imageObject) {
            foreach ($this->imageObject as $imgObj) {
                $this->image_path[] = $imgObj->storePublicly(
                    // path: /var/www/html/thesis/storage/app/public/article_images/{id}
                    'article_images/' . $lastAssignedIdIncremented,
                    ['disk' => 'public']
                );
            }
        }

        try {
            Article::create($this->only(
                'title',
                'subject',
                'content',
                'isPublished',
                'isDeprecated',
                'notifications',
                'image_path',
                'sortable_token',
            ));
        } catch (\Exception $e) {
            //throw $e;
        }
    }

    public function setArticleFields(Article $article)
    {
        $this->id = $article->id;
        $this->title = $article->title;
        $this->subject = $article->subject;
        $this->content = $article->content;
        $this->isPublished = $article->isPublished;
        $this->isDeprecated = $article->isDeprecated;
        $this->notifications = $article->notifications;
        $this->image_path = $article->image_path;
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

        // multiple image upload
        if ($this->imageObject) {
            foreach ($this->imageObject as $imgObj) {
                $this->image_path[] = $imgObj->storePublicly(
                    // path: /var/www/html/thesis/storage/app/public/article_images/{id}
                    "article_images/{$this->article->id}",
                    ['disk' => 'public']
                );
            }
        }

        try {
            $this->article->update($this->only(
                'title',
                'subject',
                'content',
                'isPublished',
                'isDeprecated',
                'notifications',
                'image_path',
            ));
        } catch (\Exception $e) {
            //throw $e;
        }
    }
}
