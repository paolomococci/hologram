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

    /**
     * save
     *
     * @return RedirectResponse
     */
    public function save(): RedirectResponse | Redirector
    {
        $timestamp = time();
        $nameDocumentToUpload = self::prepareName($this->nameDocumentToUpload, $timestamp);
        $this->titleDocumentToUpload .= (' ' . $timestamp);
        dd($this->documentToUpload, $this->documentToUpload->temporaryUrl());
        $performed = 'upload';
        $this->validate();
        $operator = ['email' => Auth::user()->email];
        try {
            $this->documentToUpload->storeAs(path: 'papers', name: $nameDocumentToUpload);
            if (!empty($this->titleDocumentToUpload)) {
                $paper = Paper::create([
                    'title' => $this->titleDocumentToUpload,
                    'name' => $this->nameDocumentToUpload,
                    'size' => $this->sizeDocumentToUpload,
                ]);
                $performed = 'creation and upload';
            }
            $jsonArrayDataLog = [
                'operator' => $operator,
                'paper' => $paper,
                'performed' => $performed,
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

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.paper.upload-paper');
    }

    /**
     * prepareName
     *
     * @param string $tempName
     * @return string
     */
    private function prepareName($tempName, $timestamp): string {
        $subName = explode('.', $tempName);
        $indexOfLastElementOfSubName = count($subName) - 1;
        $name = $subName[0];
        $name = preg_replace('/\s+/', '_', $name);
        $name .= ('_' . $timestamp);
        $name .= ('_.' . $subName[$indexOfLastElementOfSubName]);
        return $name;
    }
}
