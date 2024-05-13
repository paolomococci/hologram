<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index() {
        return Inertia::render('Tabs/Extensions/ExtensionTab');
    }
}
