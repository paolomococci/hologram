<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ToolController extends Controller
{
    public function renumber()
    {
        try {
            $operator = ['email' => Auth::user()->email];
            $outcome = [
                'message' => "operator: {$operator['email']} has just renumbered correlations",
            ];
            // dd(json_encode($outcome));
            return Inertia::render('Tabs/Tools/ToolTab', ['feedback' => json_encode($outcome)]);
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
