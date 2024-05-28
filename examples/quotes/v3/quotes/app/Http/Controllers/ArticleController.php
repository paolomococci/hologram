<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Author;
use App\Models\Merit;
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
            Article::rehydrate($articles);
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
            $article = Article::create(
                $request->validate([
                    'title' => ['required', 'min:16', 'max:255', 'unique:quotesdb.articles,title'],
                    'subject' => ['required', 'min:16', 'max:255'],
                    'summary' => ['min:16', 'max:255'],
                    'content' => ['required', 'min:32', 'max:1024'],
                    'deprecated' => ['boolean'],
                ])
            );

            if (isset($request['giver']) && isset($article['id'])) {
                self::setCorrelationByEmail($request['giver'], $article['id'], 1);
            }

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

            // Contributors
            $contributors = $article->getRelatedAuthors();
            $article['contributors'] = $contributors;

            // Authors
            $authors = Author::where('suspended', 0)->get();
            $article['authors'] = $authors;

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

            $article['subject'] = $validated['subject'];
            $article['summary'] = $validated['summary'];
            $article['content'] = $validated['content'];
            $article['deprecated'] = $validated['deprecated'];

            // Check and create correlation
            if (isset($request['correlation']) && !is_null($request['correlation'])) {
                // Set correlation based on the identifier of author.
                // self::setCorrelationById($request['correlation'], $request['id']);

                // Set correlation based on the email of author.
                self::setCorrelationByEmail($request['correlation'], $request['id']);
            }

            // Checks identifiers and delete correlations
            if (isset($request['disrelate']) && !is_null($request['disrelate'])) {
                // dd($request['disrelate']);
                self::unsetCorrelationById($request['disrelate'], $article['id']);
            }

            if (isset($request['mainAuthorIds']) && !is_null($request['mainAuthorIds'])) {
                self::setMainAuthorsById($request['mainAuthorIds'], $article['id']);
            }

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

    /**
     * set a correlation from article to author thanks to the identifier
     *
     * @param integer $authorId
     * @param integer $articleId
     * @return void
     */
    private function setCorrelationById(int $authorId, int $articleId)
    {

        if (is_numeric($authorId)) {
            //Check that `author` is correctly registered.
            $correlation = Author::findOrFail($authorId);
            // Runs a query to see if a previous correlation exists.
            $merit = Merit::where('article_id', $articleId)->where('author_id', $correlation->id)->get();
            // If a correlation already exists, it ignores it and proceeds with any changes to the fields.
            if (!$merit->count()) {
                Merit::create(
                    [
                        // field is_main_author is temporarily set to zero by default
                        'is_main_author' => 0,
                        'article_id' => $articleId,
                        'author_id' => $correlation->id,
                    ]
                );
            }
        }
    }

    /**
     * set a correlation from article to author thanks to the email
     *
     * @param string $email
     * @param integer $articleId
     * @return void
     */
    private function setCorrelationByEmail(string $email, int $articleId, int $mainAuthor = 0)
    {

        if ($email) {
            //Check that `author` is correctly registered.
            $correlation = Author::where('email', $email)->first();
            // Runs a query to see if a previous correlation exists.
            $merit = Merit::where('article_id', $articleId)->where('author_id', $correlation->id)->get();
            // If a correlation already exists, it ignores it and proceeds with any changes to the fields.
            if (!$merit->count()) {
                Merit::create(
                    [
                        // field is_main_author is temporarily set to zero by default
                        'is_main_author' => $mainAuthor,
                        'article_id' => $articleId,
                        'author_id' => $correlation->id,
                    ]
                );
            }
        }
    }

    /**
     * unset a correlation from author to article thanks to the identifier
     *
     * @param mixed $authorIds
     * @param integer $articleId
     * @return void
     */
    private function unsetCorrelationById(mixed $authorIds, int $articleId)
    {
        if (count($authorIds) > 0) {
            foreach ($authorIds as  $authorId) {
                Merit::where('author_id', $authorId)->where('article_id', $articleId)->delete();
            }
        }
    }

    /**
     * set a main authors to article thanks to the identifier
     *
     * @param mixed $mainAuthorIds
     * @param integer $articleId
     * @return void
     */
    private function setMainAuthorsById(mixed $mainAuthorIds, int $articleId)
    {
        if (count($mainAuthorIds) > 0) {
            foreach ($mainAuthorIds as  $mainAuthorId) {
                $merit = Merit::where('author_id', $mainAuthorId)->where('article_id', $articleId)->first();
                $merit['is_main_author'] = 1;
                $merit->save();
            }
        }
    }
}
