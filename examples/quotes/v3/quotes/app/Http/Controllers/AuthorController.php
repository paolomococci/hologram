<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Merit;
use Inertia\Response;
use App\Models\Author;
use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;

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
     * @return mixed
     */
    public function filter(): mixed
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
                'suspended' => $author->suspended,
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
                    'name' => ['required', 'min:1', 'max:255'],
                    'surname' => ['required', 'min:1', 'max:255'],
                    'nickname' => ['max:255'],
                    'email' => ['required', 'min:8', 'max:255', 'email', 'unique:quotesdb.authors,email'],
                    'suspended' => ['boolean'],
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
     * display the specified resource
     *
     * @param integer $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        try {
            $operator = ['email' => Auth::user()->email];

            $author = Author::find($id);

            // Contributions
            $contributions = $author->getRelatedArticles();
            Article::rehydrate($contributions);
            $author['contributions'] = $contributions;

            // Articles
            $articles = Article::where('deprecated', 0)->get();
            Article::rehydrate($articles);
            $author['articles'] = $articles;

            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'show',
            ];
            // Log::build([
            //     'driver' => 'single',
            //     'path' => storage_path('logs/author_show_info.log'),
            // ])->info(json_encode($jsonArrayDataLog));
            return response()->json($author);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * update the specified resource in storage
     *
     * @param UpdateAuthorRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateAuthorRequest $request): RedirectResponse
    {
        $operator = ['email' => Auth::user()->email];

        $req = [
            'id' => $request['id'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'nickname' => $request['nickname'],
            'email' => $request['email'],
            'suspended' => $request['suspended'],
        ];

        try {
            $author = Author::findOrFail($req['id']);

            $validated = $request->validate([
                'name' => ['required', 'min:1', 'max:255'],
                'surname' => ['required', 'min:1', 'max:255'],
                'nickname' => ['max:255'],
                'suspended' => ['boolean'],
            ]);

            $author['name'] = $validated['name'];
            $author['surname'] = $validated['surname'];
            $author['nickname'] = $validated['nickname'];
            $author['suspended'] = $validated['suspended'];

            // Check and create correlation
            if (isset($request['correlation']) && !is_null($request['correlation'])) {
                // Set correlation based on the identifier of article.
                // self::setCorrelationById($request['correlation'], $author['id']);

                // Set correlation based on the title of article.
                self::setCorrelationByTitle($request['correlation'], $author['id']);
            }

            // Checks identifiers and delete correlations
            if (isset($request['disrelate']) && !is_null($request['disrelate'])) {
                self::unsetCorrelationById($request['disrelate'], $author['id']);
            }

            $author->save();

            $jsonArrayData = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_update_info.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('authors');
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'request' => $req,
                'error' => $e->getMessage(),
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_update_error.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('authors');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }

    /**
     * set a correlation from author to article thanks to the identifier
     *
     * @param integer $articleId
     * @param integer $authorId
     * @return void
     */
    private function setCorrelationById(int $articleId, int $authorId)
    {
        if (is_numeric($articleId)) {
            //Check that `author` is correctly registered.
            $correlation = Article::findOrFail($articleId);
            // Runs a query to see if a previous correlation exists.
            $merit = Merit::where('author_id', $authorId)->where('article_id', $correlation->id)->get();
            // If a correlation already exists, it ignores it and proceeds with any changes to the fields.
            if (!$merit->count()) {
                Merit::create(
                    [
                        // field is_main_author is temporarily set to zero by default
                        'is_main_author' => 0,
                        'article_id' => $correlation->id,
                        'author_id' => $authorId,
                    ]
                );
            }
        }
    }

    /**
     * set a correlation from author to article thanks to the title
     *
     * @param string $articleTitle
     * @param integer $authorId
     * @return void
     */
    private function setCorrelationByTitle(string $articleTitle, int $authorId)
    {
        if ($articleTitle) {
            $articleTitle = SanitizerUtil::sanitize($articleTitle);
            //Check that `author` is correctly registered.
            $correlation = Article::where('title', $articleTitle)->first();
            // Runs a query to see if a previous correlation exists.
            $merit = Merit::where('author_id', $authorId)->where('article_id', $correlation->id)->get();
            // If a correlation already exists, it ignores it and proceeds with any changes to the fields.
            if (!$merit->count()) {
                Merit::create(
                    [
                        // field is_main_author is temporarily set to zero by default
                        'is_main_author' => 0,
                        'article_id' => $correlation->id,
                        'author_id' => $authorId,
                    ]
                );
            }
        }
    }

    /**
     * unset a correlation from author to article thanks to the identifier
     *
     * @param mixed $articleIds
     * @param integer $authorId
     * @return void
     */
    private function unsetCorrelationById(mixed $articleIds, int $authorId)
    {
        if (count($articleIds) > 0) {
            foreach ($articleIds as  $articleId) {
                Merit::where('article_id', $articleId)->where('author_id', $authorId)->delete();
            }
        }
    }
}
