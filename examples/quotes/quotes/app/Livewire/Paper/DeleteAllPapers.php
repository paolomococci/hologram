<?php

namespace App\Livewire\Paper;

use App\Models\Paper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class DeleteAllPapers extends Component
{
    const DIRECTORY_STORE = 'papers';

    /**
     * deleteAllPapers
     *
     * @return RedirectResponse
     */
    public function deleteAllPapers(): RedirectResponse | Redirector
    {
        try {
            $operator = ['email' => Auth::user()->email];
            $savedFiles = Storage::files(self::DIRECTORY_STORE);
            $papers = Paper::all();
            // dd($savedFiles, $papers);
            if (!empty($savedFiles) && !empty($papers)) {
                Storage::delete($savedFiles);
            }
            DB::statement("TRUNCATE TABLE `quotes_db`.`papers`");
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/reset_papers_table_info.log'),
            ])->info('Delete all data on papers table by the operator ' . $operator['email']);
            return redirect()->to('/paper')->with('status', 'Delete all data on papers table by the operator ' . $operator['email']);
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/reset_papers_table_error.log'),
            ])->error($e->getMessage());
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
        return view('livewire.paper.delete-all-papers');
    }
}
