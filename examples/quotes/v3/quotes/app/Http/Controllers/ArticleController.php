<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    /**
     * returns a list of articles as a json structured string
     */
    public function indexJson(): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $articles = Article::all();
            foreach ($articles as $article) {
                $article['title'] = SanitizerUtil::rehydrate($article['title']);
                $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
                $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
                $article['content'] = SanitizerUtil::rehydrate($article['content']);
            }
            $jsonArrayData = [
                'operator' => $operator,
                'articles' => $articles,
                'error' => null,
                'performed' => 'index_json',
            ];

            return response()->json($jsonArrayData);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'articles' => null,
                'error' => $e->getMessage(),
                'performed' => 'index_json',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return response()->json($jsonArrayData);
        }
    }

    /**
     * returns a list of articles
     */
    public function index(): Response
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $articles = Article::paginate(10)->through(fn ($article) => [
                'id' => $article->id,
                'title' => SanitizerUtil::rehydrate($article->title),
                'subject' => SanitizerUtil::rehydrate($article->subject),
                'summary' => SanitizerUtil::rehydrate($article->summary),
            ]);

            return Inertia::render('Tabs/Articles/ArticleTab', [
                'articles' => $articles,
            ]);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'error' => $e->getMessage(),
                'performed' => 'index',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return Inertia::render('Tabs/Articles/ArticleTab', [
                'feedback' => "An error {$e->getMessage()} occurred while operator {$operator['email']} was trying to paginate the articles.",
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
     * store a newly created article in storage
     */
    public function store(StoreArticleRequest $request): Response
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $request['title'] = $request['title'].' '.date('jS F Y l, h:i:s a');
            $request['title'] = SanitizerUtil::sanitize($request['title']);
            $request['subject'] = SanitizerUtil::sanitize($request['subject']);
            $request['summary'] = SanitizerUtil::sanitize($request['summary']);
            $request['content'] = SanitizerUtil::sanitize($request['content']);
            // dd('create: ', $request['title'], $request['subject'], $request['summary'], $request['content']);

            Article::create(
                $request->validate([
                    'title' => ['required', 'min:16', 'max:255', 'unique:quotesdb.articles,title'],
                    'subject' => ['required', 'min:16', 'max:255'],
                    'summary' => ['min:16', 'max:255'],
                    'content' => ['required', 'min:32', 'max:1024'],
                    'deprecated' => ['boolean'],
                ])
            );
            $req = [
                'title' => $request['title'],
                'subject' => $request['subject'],
                'summary' => $request['summary'],
                'content' => $request['content'],
                'deprecated' => $request['deprecated'],
            ];
            $jsonArrayData = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_store_info.log'),
            ])->info(json_encode($jsonArrayData));

            return Inertia::render('Tabs/Articles/ArticleTab', ['feedback' => "The operator {$operator['email']} just saved the article titled {$request['title']}"]);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'request' => $req,
                'error' => $e->getMessage(),
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_store_error.log'),
            ])->info(json_encode($jsonArrayData));

            return Inertia::render('Tabs/Articles/ArticleTab', ['feedback' => "An error {$e->getMessage()} occurred while operator {$operator['email']} was trying to save the article titled {$request['title']}"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
