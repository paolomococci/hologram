<?php

namespace App\Livewire\Contributor;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class ClearData extends Component
{
    /**
     * resetAllData
     *
     * cleans the contents of the web application database of all dummy data used during development
     * and log this action
     *
     * @return RedirectResponse
     */
    public function resetAllData(): RedirectResponse | Redirector
    {
        try {
            $operator = ['email' => Auth::user()->email];
            DB::statement("SET FOREIGN_KEY_CHECKS = 0");
            DB::statement("TRUNCATE TABLE `quotes_db`.`contributor`");
            DB::statement("TRUNCATE TABLE `quotes_db`.`author_article`");
            DB::statement("TRUNCATE TABLE `quotes_db`.`authors`");
            DB::statement("TRUNCATE TABLE `quotes_db`.`articles`");
            DB::statement("SET FOREIGN_KEY_CHECKS = 1");
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/reset_all_data_table_info.log'),
            ])->info('Reset all data table by the operator ' . $operator['email']);
            return redirect()->to('/tools')->with('clear-data-status', 'Reset all data table by the operator ' . $operator['email']);
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/reset_all_data_table_error.log'),
            ])->error($e->getMessage());
            session()->flash('clear-data-status', $e->getMessage());
            return redirect()->to('/tools')->with('clear-data-status', $e->getMessage());
        }
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.contributor.clear-data');
    }
}
