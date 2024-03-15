<?php

namespace App\Livewire\Paper;

use App\Models\Paper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class UpdatePaper extends Component
{
    #[Validate('max:255')]
    public $title = '';

    #[Validate('max:255')]
    public $name = '';

    #[Validate('required|min:20')]
    public $content;

    public ?Paper $paper;

    protected $listeners = [
        'toModify' => 'retrievePaper',
    ];

    /**
     * retrievePaper
     *
     * @param  int $referringTo
     * @return void
     */
    public function retrievePaper($referringTo): void
    {
        $this->paper = Paper::findOrFail($referringTo);
        $this->title = $this->paper->title;
        $this->name = $this->paper->name;
        $this->content = $this->paper->content;
    }

    /**
     * update
     *
     * @return RedirectResponse
     */
    public function update(): RedirectResponse | Redirector
    {
        $operator = ['email' => Auth::user()->email];
        try {
            $this->paper->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
            $jsonArrayDataLog = [
                'operator' => $operator,
                'paper' => $this->paper,
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/paper_update_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return redirect()->to('/paper')->with('status', 'Updated paper id: ' . $this->paper->id . ' by the operator ' . $operator['email']);
        } catch (\Exception $e) {$jsonArrayDataLog = [
            'operator' => $operator,
            'paper' => $this->paper,
            'performed' => 'update',
            'error_message' => $e->getMessage(),
        ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/paper_update_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            return redirect()->to('/paper')->with('status', $e->getMessage());
        }
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.paper.update-paper');
    }
}
