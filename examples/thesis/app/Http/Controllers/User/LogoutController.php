<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public static function signOut(string $route): RedirectResponse
    {
        Auth::logout();

        return redirect()->route($route);
    }
}
