<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefusalRequest;
use App\Http\Requests\UpdateRefusalRequest;
use App\Models\Refusal;
use Illuminate\Http\Response;

class RefusalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): string
    {
        $refusals = Refusal::all();

        // If there are no resources, return an HTTP response of type HTTP_NOT_FOUND.
        if (count($refusals) < 1) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No deprecated post elements found!',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'refusals' => $refusals,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRefusalRequest $request): int
    {
        return Response::HTTP_NOT_IMPLEMENTED;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): string
    {
        $refusal = Refusal::find($id);

        // If the resource does not exist, return an HTTP response of type HTTP_NOT_FOUND.
        if ($refusal === null) {
            return response()->json([
                'status' => 'failure',
                'message' => "The deprecated post with ID: $id does not exist!",
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'refusal' => $refusal,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRefusalRequest $request, Refusal $refusal): int
    {
        return Response::HTTP_NOT_IMPLEMENTED;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refusal $refusal): int
    {
        return Response::HTTP_NOT_IMPLEMENTED;
    }
}
