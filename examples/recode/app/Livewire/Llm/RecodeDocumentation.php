<?php

namespace App\Livewire\Llm;

use App\Models\Documentation;
use Livewire\Component;

class RecodeDocumentation extends Component
{
    public function render()
    {
        $paragraphOne = Documentation::where('title', 'Programming Tips')->first();

        return view('livewire.llm.recode-documentation')->with([
            'title' => $paragraphOne['title'],
            'content' => $paragraphOne['content'],
        ]);
    }
}
