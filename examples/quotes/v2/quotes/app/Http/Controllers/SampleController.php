<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSampleRequest;
use App\Http\Requests\UpdateSampleRequest;
use App\Models\Sample;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $samples = Sample::paginate(10)->through(fn ($sample) => [
            'title' => $sample->title,
            'subject' => $sample->subject,
            'summary' => $sample->summary,
        ]);
        return Inertia::render('Samples/Index', [
            'samples' => $samples,
        ]);
    }

    /**
     * Display a filtered list of the resource.
     */
    public function filter(Request $request): String
    {
        $samples = Sample::all()->map(fn ($sample) => [
            'title' => $sample->title,
            'subject' => $sample->subject,
            'summary' => $sample->summary,
            'content' => $sample->content,
        ]);
        return json_encode($samples);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSampleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sample $sample)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sample $sample)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSampleRequest $request, Sample $sample)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sample $sample)
    {
        //
    }
}
