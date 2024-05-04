<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $authors = Author::all();

            return response()->json($authors);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $request['name'] = SanitizerUtil::filtrate($request['name']);
            $request['surname'] = SanitizerUtil::filtrate($request['surname']);
            $request['nickname'] = SanitizerUtil::filtrate($request['nickname']);

            Author::create(
                $request->validate([
                    'name' => ['required', 'min:16', 'max:255'],
                    'surname' => ['required', 'min:16', 'max:255'],
                    'nickname' => ['min:16', 'max:255'],
                    'email' => ['required', 'min:32', 'max:1024', 'email', 'unique:quotesdb.authors,email'],
                    'deprecated' => ['boolean'],
                ])
            );
            $req = [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'nickname' => $request['nickname'],
                'email' => $request['email'],
                'suspended' => $request['suspended'],
            ];
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_store_info.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return Inertia::render('Tabs/Authors/AuthorTab', ['feedback' => "The operator {$operator['email']} just saved the author named {$request['name']}"]);
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'request' => $req,
                'error' => $e->getMessage(),
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_store_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return Inertia::render('Tabs/Authors/AuthorTab', ['feedback' => "An error {$e->getMessage()} occurred while operator {$operator['email']} was trying to save the author named {$request['name']}"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
