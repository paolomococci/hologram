<?php

namespace App\Http\Controllers\Rest;

use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleRestController extends Controller
{
    /**
     * store a newly created article in storage
     *
     * @param StoreArticleRequest $request
     * @return string
     */
    public function create(StoreArticleRequest $request): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $request['title'] = $request['title'].' '.date('jS F Y l, h:i:s a');
            $request['title'] = SanitizerUtil::sanitize($request['title']);
            $request['subject'] = SanitizerUtil::sanitize($request['subject']);
            $request['summary'] = SanitizerUtil::sanitize($request['summary']);
            $request['content'] = SanitizerUtil::sanitize($request['content']);

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
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'create',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_create_info.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'Created',
                ],
                201
            );
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'request' => $req,
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
     * display the specified article
     *
     * @param integer $id
     * @return string
     */
    public function read(int $id): string
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
                    'message' => 'Not Found',
                ],
                404
            );
        }
    }

    /**
     * update the specified article
     *
     * @param integer $id
     * @param UpdateArticleRequest $request
     * @return string
     */
    public function update(int $id, UpdateArticleRequest $request): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $request['subject'] = SanitizerUtil::sanitize($request['subject']);
            $request['summary'] = SanitizerUtil::sanitize($request['summary']);
            $request['content'] = SanitizerUtil::sanitize($request['content']);

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
            $req = [
                'title' => $request['title'],
                'subject' => $request['subject'],
                'summary' => $request['summary'],
                'content' => $request['content'],
                'deprecated' => $request['deprecated'],
            ];
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_update_info.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'No Content',
                ],
                204
            );
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'request' => $req,
                'error' => $e->getMessage(),
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_api_update_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json(
                [
                    'message' => 'Not Found',
                ],
                404
            );
        }
    }

    /**
     * display a listing of the articles
     *
     * @return string
     */
    public function index(): string
    {
        try {
            $articles = Article::all();
            foreach ($articles as $article) {
                $article['title'] = SanitizerUtil::rehydrate($article['title']);
                $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
                $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
                $article['content'] = SanitizerUtil::rehydrate($article['content']);
                $article['contributors'] = $article->getRelatedAuthors();
            }

            return json_encode($articles);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
