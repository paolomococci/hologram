<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    public function renumber()
    {
        try {
            $operator = ['email' => Auth::user()->email];
            // dd($operator);
            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => "operator: {$operator['email']} has just renumbered correlations"]);
        } catch (\Exception $e) {
            // TODO: log this eventually error!
        }
    }

    public function clean()
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $operator = ['email' => Auth::user()->email];
            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => "operator: {$operator['email']} has just deleted all data"]);
        } catch (\Exception $e) {
            // TODO: log this eventually error!
        }
    }
}
