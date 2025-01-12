<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefusalRequest;
use App\Http\Requests\UpdateRefusalRequest;
use App\Models\Refusal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class RefusalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Refusal::all();
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
    public function show(Refusal $refusal): Refusal
    {
        return $refusal;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRefusalRequest $request, Refusal $refusal): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refusal $refusal): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
