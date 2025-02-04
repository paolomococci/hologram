<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Refusal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostsController extends Controller
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
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No post elements found!',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => 'success',
                'posts' => $posts,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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

            return response()->json([
                'status' => 'success',
                'message' => 'Post successfully registered!',
                'post' => $post,
                'user' => $post->user,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
                return response()->json([
                    'status' => 'failure',
                    'message' => "Post id: $id either never existed or has been deprecated!",
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => 'success',
                'title' => $post->title,
                'content' => $post->content,
                'username' => $post->user['name'],
                'email' => $post->user['email'],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return response()->json([
                'status' => 'failure',
                'message' => "Post id: $id either never existed or has been deprecated!",
            ], Response::HTTP_NOT_FOUND);
        }

        // If the user who is trying to edit the resource does not match the creator of the resource,
        // return an HTTP response of type HTTP_UNAUTHORIZED.
        if ($post->user_id != $user->id) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Warning: only the user who created the post can edit it!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $fields = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required|max:5000',
            ]);

            $post->update($fields);

            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully',
                'post' => $post,
                'user' => $post->user,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
                return response()->json([
                    'status' => 'failure',
                    'message' => "Post id: $id either never existed or has already been deprecated!",
                ], Response::HTTP_NOT_FOUND);
            }

            // If the user who is trying to deprecate the resource does not match the creator of the resource,
            // return an HTTP response of type HTTP_UNAUTHORIZED.
            if ($post->user_id != $user->id) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Warning: only the user who created the post can deprecate it!',
                ], Response::HTTP_UNAUTHORIZED);
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

            return response()->json([
                'message' => "Post id: $post->id with title: $post->title was treated as a refusal!",
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
