<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ToolController extends Controller
{
    public function renumber()
    {
        try {
            $operator = ['email' => Auth::user()->email];
            DB::statement('SET SQL_SAFE_UPDATES = 0');
            DB::statement('SET @variableToRenumber := 0');
            DB::statement('UPDATE `quotes_v3_db`.`merit` SET `id` = (@variableToRenumber := @variableToRenumber + 1)');
            DB::statement('ALTER TABLE `quotes_v3_db`.`merit` AUTO_INCREMENT = 1');
            DB::statement('SET SQL_SAFE_UPDATES = 1');
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/renumbering_merit_table_info.log'),
            ])->info('Renumbering merit table by the operator '.$operator['email']);
            $outcome = [
                'message' => "Operator {$operator['email']} has just renumbered correlations between authors and articles!",
            ];

            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => json_encode($outcome['message'])]);
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/renumbering_merit_table_error.log'),
            ])->error('Renumbering merit table by the operator '.$operator['email'].'was the cause of the following error: '.$e->getMessage());
            $outcome = [
                'message' => "Operator {$operator['email']} just attempted to renumber the correlations between authors and articles, causing the following error: {$e->getMessage()}",
            ];

            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => json_encode($outcome['message'])]);
        }
    }

    public function clean()
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $operator = ['email' => Auth::user()->email];
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::statement('TRUNCATE TABLE `quotes_v3_db`.`merit`');
            DB::statement('TRUNCATE TABLE `quotes_v3_db`.`authors`');
            DB::statement('TRUNCATE TABLE `quotes_v3_db`.`articles`');
            DB::statement('TRUNCATE TABLE `quotes_v3_db`.`papers`');
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/cleaning_all_data_into_the_quotes_v3_db_database_info.log'),
            ])->info("Cleaning all data in the database quotes_v3_db by the operator {$operator['email']}!");
            $outcome = [
                'message' => "Operator {$operator['email']} has just deleted all data from database quotes_v3_db!",
            ];

            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => "Operator: {$operator['email']} has just deleted all data from database quotes_v3_db"]);
        } catch (\Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/cleaning_all_data_into_the_quotes_v3_db_database_error.log'),
            ])->error('Cleaning all data in the database quotes_v3_db by the operator '.$operator['email'].'was the cause of the following error: '.$e->getMessage());
            $outcome = [
                'message' => "Operator {$operator['email']} just attempted to delete all data from database quotes_v3_db, causing the following error: {$e->getMessage()}",
            ];

            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => json_encode($outcome['message'])]);
        }
    }
}
