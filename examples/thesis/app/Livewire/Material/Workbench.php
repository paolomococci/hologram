<?php

namespace App\Livewire\Material;

use App\Models\Article;
use App\Utils\CleaningUtility;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
#[Layout('components.layouts.material')]
class Workbench extends Component
{
    public string $title = 'Workbench';

    public string $content = 'My example of material design used as a paradigm to create immediately recognizable interfaces without being too tied to physical objects from the past.';

    public string $jsonDataItems = '';

    public function mount()
    {
        $items = [];
        // in testing phase: to limit the tuples obtained by the query
        $approvedArticles = Article::where('isDeprecated', false)->take(5)->get();
        // $approvedArticles = Article::where('isDeprecated', false)->get();
        foreach ($approvedArticles as $approvedArticle) {
            $approvedArticle['title'] = CleaningUtility::cleanTitle($approvedArticle['title']);
            $items[] = $approvedArticle;
        }
        $this->jsonDataItems = json_encode($items);
    }

    public function render()
    {
        return view('livewire.material.workbench');
    }
}
