<?php

namespace App\Livewire\Contributor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearData extends Component
{
    public function resetAllData() {
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
            return redirect()->to('/tools')->with('status', 'Reset all data table by the operator ' . $operator['email']);
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/reset_all_data_table_error.log'),
            ])->error($e->getMessage());
            session()->flash('status', $e->getMessage());
            return redirect()->to('/tools')->with('status', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.contributor.clear-data');
    }
}
