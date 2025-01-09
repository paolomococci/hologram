<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public static function signOut(string $route): RedirectResponse
    {
        Auth::logout();

        return redirect()->route($route);
    }
}
