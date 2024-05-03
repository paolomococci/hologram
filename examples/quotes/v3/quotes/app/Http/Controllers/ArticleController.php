<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Article::all();
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
    public function store(StoreArticleRequest $request)
    {
        $operator = ['email' => Auth::user()->email];

        $request['title'] = SanitizerUtil::sanitize($request['title']);
        $request['subject'] = SanitizerUtil::sanitize($request['subject']);
        $request['summary'] = SanitizerUtil::sanitize($request['summary']);
        $request['content'] = SanitizerUtil::sanitize($request['content']);

        try {
            $article = Article::create(
                $request->validate([
                    'title' => ['required', 'min:16', 'max:255', 'unique:quotesdb.articles,title'],
                    'subject' => ['required', 'min:16', 'max:255'],
                    'summary' => ['min:16', 'max:255'],
                    'content' => ['required', 'min:32', 'max:1024'],
                    'deprecated' => ['boolean'],
                ])
            );
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'article' => $article['title'],
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_store_info.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return Inertia::render('Tabs/Articles/ArticleTab', ['feedback' => "The operator {$operator['email']} just saved the article titled {$request['title']}"]);
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'request' => $request['title'],
                'error' => $e->getMessage(),
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_store_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

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
