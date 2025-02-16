<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Refusal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostsRestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): string
    {
        try {
            $posts = Posts::with('user')->latest()->get();

            // If there are no resources, return an HTTP response of type HTTP_NOT_FOUND.
            if (count($posts) < 1) {
                return json_encode([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'No post elements found!',
                ]);
            }

            return json_encode([
                'status' => Response::HTTP_OK,
                'posts' => $posts,
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): string
    {
        try {
            $fields = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required|max:5000',
            ]);

            $post = $request->user()->posts()->create($fields);

            return json_encode([
                'status' => Response::HTTP_CREATED,
                'message' => 'Post successfully registered!',
                'post' => $post,
                'user' => $post->user,
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): string
    {
        try {
            $post = Posts::find($id);

            // If the resource does not exist, return an HTTP response of type HTTP_NOT_FOUND.
            if ($post === null) {
                return json_encode([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => "Post id: $id either never existed or has been deprecated!",
                ]);
            }

            return json_encode([
                'status' => Response::HTTP_OK,
                'title' => $post->title,
                'content' => $post->content,
                'user' => $post->user['name'],
                'email' => $post->user['email'],
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage only if the one who is trying to modify the resource is also the original creator of the resource.
     */
    public function update(Request $request, int $id): string
    {
        $post = Posts::find($id);
        $user = auth()->user();

        // If the resource does not exist, return an HTTP response of type HTTP_NOT_FOUND.
        if ($post === null) {
            return json_encode([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => "Post id: $id either never existed or has been deprecated!",
            ]);
        }

        // If the user who is trying to edit the resource does not match the creator of the resource,
        // return an HTTP response of type HTTP_UNAUTHORIZED.
        if ($post->user_id != $user->id) {
            return json_encode([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Warning: only the user who created the post can edit it!',
            ]);
        }

        try {
            $fields = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required|max:5000',
            ]);

            $post->update($fields);

            return json_encode([
                'status' => Response::HTTP_OK,
                'message' => 'Post updated successfully',
                'post' => $post,
                'user' => $post->user,
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Deprecate the specified resource from storage,
     * only if the one who is trying to move the resource to refusals table is also the original creator of the resource.
     */
    public function destroy(int $id): string
    {
        try {
            $post = Posts::find($id);
            $user = auth()->user();

            // If the resource does not exist, return an HTTP response of type HTTP_NOT_FOUND.
            if ($post === null) {
                return json_encode([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => "Post id: $id either never existed or has already been deprecated!",
                ]);
            }

            // If the user who is trying to deprecate the resource does not match the creator of the resource,
            // return an HTTP response of type HTTP_UNAUTHORIZED.
            if ($post->user_id != $user->id) {
                return json_encode([
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Warning: only the user who created the post can deprecate it!',
                ]);
            }

            // Create a refusal object to store data from post object
            $refusal = new Refusal;

            $refusal->fill([
                'title' => $post->title,
                'content' => $post->content,
                'user_id' => $user->id,
                'original_created_at' => $post->created_at,
                'original_updated_at' => $post->updated_at,
            ]);
            $refusal->save();

            // Delete the original post object from posts table
            $post->delete();

            return json_encode([
                'status' => Response::HTTP_NO_CONTENT,
                'message' => "Post id: $post->id with title: $post->title was treated as a refusal!",
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
