<?php

namespace App\Livewire\Contributor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RenumberContrib extends Component
{
    public function renumber()
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
    public function render()
    {
        return view('livewire.contributor.renumber-contrib');
    }
}
