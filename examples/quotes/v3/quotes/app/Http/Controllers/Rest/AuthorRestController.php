<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthorRestController extends Controller
{
    /**
     * store a newly created author in storage
     *
     * @param StoreAuthorRequest $request
     * @return string
     */
    public function create(StoreAuthorRequest $request): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $request['name'] = SanitizerUtil::filtrate($request['name']);
            $request['surname'] = SanitizerUtil::filtrate($request['surname']);
            $request['nickname'] = SanitizerUtil::filtrate($request['nickname']);

            $request->validate([
                'name' => ['required', 'min:1', 'max:255'],
                'surname' => ['required', 'min:1', 'max:255'],
                'nickname' => ['min:16', 'max:255'],
                'email' => ['required', 'min:10', 'max:255', 'email', 'unique:quotesdb.authors,email'],
                'suspended' => ['boolean'],
            ]);

            return response()->json($request);

            Author::create(
                $request->validate([
                    'name' => ['required', 'min:1', 'max:255'],
                    'surname' => ['required', 'min:1', 'max:255'],
                    'nickname' => ['min:16', 'max:255'],
                    'email' => ['required', 'min:10', 'max:255', 'email', 'unique:quotesdb.authors,email'],
                    'suspended' => ['boolean'],
                ])
            );
            $req = [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'nickname' => $request['nickname'],
                'email' => $request['email'],
                'suspended' => $request['suspended'],
            ];
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'create',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_api_create_info.log'),
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
                'path' => storage_path('logs/authors_api_create_error.log'),
            ])->info(json_encode($jsonArrayDataLog));

            return response()->json($jsonArrayDataLog, 500);
        }
    }

    /**
     * display the specified author
     *
     * @param integer $id
     * @return string
     */
    public function read(int $id): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $author = Author::findOrFail($id);

            return response()->json($author);
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'authorId' => $id,
                'error' => $e->getMessage(),
                'performed' => 'read',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_api_read_error.log'),
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
     * update the specified author
     *
     * @param integer $id
     * @param StoreAuthorRequest $request
     * @return string
     */
    public function update(int $id, StoreAuthorRequest $request): string
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $request['name'] = SanitizerUtil::filtrate($request['name']);
            $request['surname'] = SanitizerUtil::filtrate($request['surname']);
            $request['nickname'] = SanitizerUtil::filtrate($request['nickname']);

            $author = Author::findOrFail($id);

            $validated = $request->validate([
                'name' => ['required', 'min:1', 'max:255'],
                'surname' => ['required', 'min:1', 'max:255'],
                'nickname' => ['min:1', 'max:255'],
                'suspended' => ['boolean'],
            ]);

            $author['name'] = $validated['name'];
            $author['surname'] = $validated['surname'];
            $author['nickname'] = $validated['nickname'];
            $author['suspended'] = $validated['suspended'];

            $author->save();
            $req = [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'nickname' => $request['nickname'],
                'email' => $request['email'],
                'suspended' => $request['suspended'],
            ];
            $jsonArrayDataLog = [
                'operator' => $operator['email'],
                'request' => $req,
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/authors_api_update_info.log'),
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
                'path' => storage_path('logs/authors_api_update_error.log'),
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
     * display a listing of the authors
     *
     * @return string
     */
    public function index(): string
    {
        try {
            $authors = Author::all();

            return response()->json($authors);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
