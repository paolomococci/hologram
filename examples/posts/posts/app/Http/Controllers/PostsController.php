<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Refusal;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(
                'auth:sanctum',
                except: [
                    'index',
                    'show',
                ]
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Posts::with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): array
    {
        // super user workflow
        // TODO: superuser token check
        if (isset($request->user_id)) {
            try {
                $user = User::find($request->user_id);
                if ($user->id) {
                    $fields = $request->validate([
                        'user_id' => 'numeric',
                        'title' => 'required|max:255',
                        'content' => 'required|max:5000',
                    ]);

                    $post = Posts::create($fields);

                    return [
                        'post' => $post,
                        'user' => $post->user,
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'message' => 'Warning, a non-existent user ID was passed!',
                ];
            }
        }

        // normal operating flow
        try {
            $fields = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required|max:5000',
            ]);

            $post = $request->user()->posts()->create($fields);

            return [
                'post' => $post,
                'user' => $post->user,
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $post): array
    {
        return [
            'post' => $post,
            'user' => $post->user,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post): array
    {
        // super user workflow
        // TODO: superuser token check
        if (isset($request->user_id)) {
            try {
                $user = User::find($request->user_id);
                if ($user->id) {
                    $fields = $request->validate([
                        'user_id' => 'numeric',
                        'title' => 'required|max:255',
                        'content' => 'required|max:5000',
                    ]);

                    $post->update($fields);

                    return [
                        'post' => $post,
                        'user' => $post->user,
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'message' => 'Warning, a non-existent user ID was passed!',
                ];
            }
        }

        // normal operating flow
        try {
            Gate::authorize(
                'adjust',
                $post
            );

            $fields = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required|max:5000',
            ]);

            $post->update($fields);

            return [
                'post' => $post,
                'user' => $post->user,
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post): array
    {
        try {
            Gate::authorize(
                'adjust',
                $post
            );

            $refusal = new Refusal;
            $refusal->fill([
                'title' => $post->title,
                'content' => $post->content,
            ]);
            $refusal->save();
            $post->delete();

            return [
                'message' => 'As requested the post was treated as a refusal!',
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
            ];
        }
    }
}
