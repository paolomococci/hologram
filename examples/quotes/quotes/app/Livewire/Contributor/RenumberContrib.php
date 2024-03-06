<?php

namespace App\Livewire\Contributor;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class RenumberContrib extends Component
{
    /**
     * renumber
     *
     * performs identifier renumbering without destroying data
     * and log this action
     *
     * @return RedirectResponse
     */
    public function renumber(): RedirectResponse | Redirector
    {
        try {
            $operator = ['email' => Auth::user()->email];
            DB::statement("SET SQL_SAFE_UPDATES = 0");
            DB::statement("SET @variableToRenumber := 0");
            DB::statement("UPDATE `quotes_db`.`contributor` SET `id` = (@variableToRenumber := @variableToRenumber + 1)");
            DB::statement("ALTER TABLE `quotes_db`.`contributor` AUTO_INCREMENT = 1");
            DB::statement("SET SQL_SAFE_UPDATES = 1");
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/renumbering_contributor_table_info.log'),
            ])->info('Renumbering contributor table by the operator ' . $operator['email']);
            return redirect()->to('/tools')->with('status', 'Renumbering contributor table by the operator ' . $operator['email']);
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/renumbering_contributor_table_error.log'),
            ])->error($e->getMessage());
            session()->flash('status', $e->getMessage());
            return redirect()->to('/tools')->with('status', $e->getMessage());
        }
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.contributor.renumber-contrib');
    }
}
