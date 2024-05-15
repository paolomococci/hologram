<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Utils\SanitizerUtil;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    /**
     * returns a list of articles as a json structured string
     *
     */
    public function filter()
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $articles = Article::all();
            foreach ($articles as $article) {
                $article['title'] = SanitizerUtil::rehydrate($article['title']);
                $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
                $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
                $article['content'] = SanitizerUtil::rehydrate($article['content']);
                $article['deprecated'] = $article['deprecated'];
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
     * returns a list paginated of articles
     *
     * @return Response
     */
    public function index(): Response
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $articles = Article::paginate(10)->through(fn ($article) => [
                'id' => $article->id,
                'title' => SanitizerUtil::rehydrate($article->title),
                'subject' => SanitizerUtil::rehydrate($article->subject),
                'deprecated' => $article->deprecated,
            ]);

            return Inertia::render('Tabs/Articles/ArticleTab', [
                'articles' => $articles
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

            return Inertia::render('Tabs/Articles/ArticleTab');
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
     *
     * @param StoreArticleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $operator = ['email' => Auth::user()->email];

        if (!empty($request['title'])) {
            $request['title'] = $request['title'] . ' ' . date('jS F Y l, h:i:s a');
        }

        $request['title'] = SanitizerUtil::sanitize($request['title']);
        $request['subject'] = SanitizerUtil::sanitize($request['subject']);
        $request['summary'] = SanitizerUtil::sanitize($request['summary']);
        $request['content'] = SanitizerUtil::sanitize($request['content']);

        $req = [
            'title' => $request['title'],
            'subject' => $request['subject'],
            'summary' => $request['summary'],
            'content' => $request['content'],
            'deprecated' => $request['deprecated'],
        ];

        try {
            Article::create(
                $request->validate([
                    'title' => ['required', 'min:16', 'max:255', 'unique:quotesdb.articles,title'],
                    'subject' => ['required', 'min:16', 'max:255'],
                    'summary' => ['min:16', 'max:255'],
                    'content' => ['required', 'min:32', 'max:1024'],
                    'deprecated' => ['boolean'],
                ])
            );
            $jsonArrayData = [
                'operator' => $operator['email'],
                'title' => $req['title'],
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_store_info.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('articles');
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'title' => $req['title'],
                'error' => $e->getMessage(),
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_store_error.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('articles');
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

            $article = Article::find($id);
            $article['title'] = SanitizerUtil::rehydrate($article['title']);
            $article['subject'] = SanitizerUtil::rehydrate($article['subject']);
            $article['summary'] = SanitizerUtil::rehydrate($article['summary']);
            $article['content'] = SanitizerUtil::rehydrate($article['content']);

            $authors = $article->getRelatedAuthors();
            $article['authors'] = $authors;
            // dd($article);

            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'show',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/article_show_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return response()->json($article);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, Article $article)
    {
        //
    }

    /**
     * update the specified resource in storage
     *
     * @param UpdateArticleRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateArticleRequest $request): RedirectResponse
    {
        $operator = ['email' => Auth::user()->email];

        $request['subject'] = SanitizerUtil::sanitize($request['subject']);
        $request['summary'] = SanitizerUtil::sanitize($request['summary']);
        $request['content'] = SanitizerUtil::sanitize($request['content']);

        $req = [
            'id' => $request['id'],
            'title' => $request['title'],
            'subject' => $request['subject'],
            'summary' => $request['summary'],
            'content' => $request['content'],
            'deprecated' => $request['deprecated'],
        ];

        try {
            $article = Article::findOrFail($req['id']);

            $validated = $request->validate([
                'subject' => ['required', 'min:16', 'max:255'],
                'summary' => ['min:16', 'max:255'],
                'content' => ['required', 'min:32', 'max:1024'],
                'deprecated' => ['boolean'],
            ]);
            // dd($validated);

            $article['subject'] = $validated['subject'];
            $article['summary'] = $validated['summary'];
            $article['content'] = $validated['content'];
            $article['deprecated'] = $validated['deprecated'];

            $article->save();

            $jsonArrayData = [
                'operator' => $operator['email'],
                'title' => $req['title'],
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_update_info.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('articles');
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'title' => $req['title'],
                'error' => $e->getMessage(),
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/articles_update_error.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('articles');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
