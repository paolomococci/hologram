<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AuthorController extends Controller
{
    /**
     * returns a list of resources as a json structured string
     *
     * @return string
     */
    public function indexJson(): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $authors = Author::all();
            $jsonArrayData = [
                'operator' => $operator,
                'authors' => $authors,
                'error' => null,
                'performed' => 'index_json',
            ];

            return response()->json($jsonArrayData);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'authors' => null,
                'error' => $e->getMessage(),
                'performed' => 'index_json',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return response()->json($jsonArrayData);
        }
    }

    /**
     * returns a list of authors as a json structured string
     *
     */
    public function filter()
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $authors = Author::all();

            $jsonArrayData = [
                'operator' => $operator,
                'authors' => $authors,
                'error' => null,
                'performed' => 'index_json',
            ];

            return response()->json($jsonArrayData);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'authors' => null,
                'error' => $e->getMessage(),
                'performed' => 'index_json',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return response()->json($jsonArrayData);
        }
    }

    /**
     * returns a list of authors
     *
     * @return Response
     */
    public function index(): Response
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $authors = Author::paginate(10)->through(fn ($author) => [
                'id' => $author->id,
                'name' => $author->name,
                'surname' => $author->surname,
                'email' => $author->email,
            ]);

            return Inertia::render('Tabs/Authors/AuthorTab', [
                'authors' => $authors,
            ]);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'error' => $e->getMessage(),
                'performed' => 'index',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/author_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return Inertia::render('Tabs/Authors/AuthorTab', [
                'feedback' => "An error {$e->getMessage()} occurred while operator {$operator['email']} was trying to paginate the authors.",
            ]);
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
     * store a newly created author in storage
     *
     * @param StoreAuthorRequest $request
     * @return Response
     */
    public function store(StoreAuthorRequest $request): Response
    {
        $operator = ['email' => Auth::user()->email];
        $request['name'] = SanitizerUtil::filtrate($request['name']);
        $request['surname'] = SanitizerUtil::filtrate($request['surname']);
        $request['nickname'] = SanitizerUtil::filtrate($request['nickname']);
        $req = [
            'name' => $request['name'],
            'surname' => $request['surname'],
            'nickname' => $request['nickname'],
            'email' => $request['email'],
            'suspended' => $request['suspended'],
        ];

        try {
            Author::create(
                $request->validate([
                    'name' => ['required', 'min:16', 'max:255'],
                    'surname' => ['required', 'min:16', 'max:255'],
                    'nickname' => ['min:16', 'max:255'],
                    'email' => ['required', 'min:32', 'max:1024', 'email', 'unique:quotesdb.authors,email'],
                    'deprecated' => ['boolean'],
                ])
            );
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
