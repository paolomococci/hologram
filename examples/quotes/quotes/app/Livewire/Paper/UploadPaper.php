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
use Livewire\WithFileUploads;

class UploadPaper extends Component
{
    use WithFileUploads;

    #[Validate('max:255')]
    public $titleDocumentToUpload = '';

    #[Validate('max:255')]
    public $nameDocumentToUpload = '';

    #[Validate('max:255')]
    public $sizeDocumentToUpload = '';

    #[Validate('required|max:2048')]
    public mixed $documentToUpload = '';

    /**
     * resetFields
     *
     * @return void
     */
    public function resetFields(): void
    {
        $this->titleDocumentToUpload = '';
        $this->nameDocumentToUpload = '';
        $this->sizeDocumentToUpload = '';
        $this->documentToUpload = '';
    }

    public function save(): RedirectResponse | Redirector
    {
        dd($this->titleDocumentToUpload, $this->nameDocumentToUpload, $this->sizeDocumentToUpload, $this->documentToUpload);
        $this->validate();
        $operator = ['email' => Auth::user()->email];
        try {
            $this->documentToUpload->store(path: 'documents');
            if (!empty($this->titleDocumentToUpload)) {
                $paper = Paper::create([
                    'title' => $this->titleDocumentToUpload,
                    'name' => $this->nameDocumentToUpload,
                    'size' => $this->sizeDocumentToUpload,
                ]);
            }
            $jsonArrayDataLog = [
                'operator' => $operator,
                'paper' => $paper,
                'performed' => 'creation',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/paper_create_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return redirect()->to('/paper')->with('status', 'Upload a new paper');
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'creation',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/paper_create_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            $this->resetFields();
            return redirect()->to('/paper')->with('status', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.paper.upload-paper');
    }
}
