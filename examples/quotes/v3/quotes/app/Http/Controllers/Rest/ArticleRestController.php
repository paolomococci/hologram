<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArticleRestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function create(StoreArticleRequest $request)
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
                'performed' => 'create',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_create_info.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'Created'
                ],
                201
            );
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'request' => $request['title'],
                'error' => $e->getMessage(),
                'performed' => 'create',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_create_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json($jsonArrayDataLog, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function read(int $id)
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $article = Article::findOrFail($id);
            $article['title'] = SanitizerUtil::rehydrate($article['title']);
            $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
            $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
            $article['content'] = SanitizerUtil::rehydrate($article['content']);

            return response()->json($article);
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'articleId' => $id,
                'error' => $e->getMessage(),
                'performed' => 'read',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_read_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'Not Found'
                ],
                404
            );
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(int $id, StoreArticleRequest $request)
    {
        $operator = ['email' => Auth::user()->email];

        $request['subject'] = SanitizerUtil::sanitize($request['subject']);
        $request['summary'] = SanitizerUtil::sanitize($request['summary']);
        $request['content'] = SanitizerUtil::sanitize($request['content']);

        try {
            $article = Article::findOrFail($id);

            $validated = $request->validate([
                'subject' => ['required', 'min:16', 'max:255'],
                'summary' => ['min:16', 'max:255'],
                'content' => ['required', 'min:32', 'max:1024'],
                'deprecated' => ['boolean'],
            ]);

            $article['subject'] = $validated['subject'];
            $article['summary'] = $validated['summary'];
            $article['content'] = $validated['content'];
            $article['deprecated'] = $validated['deprecated'];

            $article->save();
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'article' => $article['title'],
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_update_info.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'No Content'
                ],
                204
            );
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'request' => $request['title'],
                'error' => $e->getMessage(),
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_update_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'Not Found'
                ],
                404
            );
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $articles = Article::all();
            foreach ($articles as $article) {
                $article['title'] = SanitizerUtil::rehydrate($article['title']);
                $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
                $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
                $article['content'] = SanitizerUtil::rehydrate($article['content']);
            }

            return response()->json($articles);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
