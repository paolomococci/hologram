<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreSampleRequest;
use App\Http\Requests\UpdateSampleRequest;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operator = ['email' => Auth::user()->email];
        // dd($operator);
        $samples = Sample::paginate(10)->through(fn ($sample) => [
            'id' => $sample->id,
            'title' => $sample->title,
            'subject' => $sample->subject,
            'summary' => $sample->summary,
        ]);
        $jsonArrayDataLog = [
            'operator' => $operator,
            'performed' => 'readAll',
        ];
        // dd($jsonArrayDataLog);
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/samples_read_all_info.log'),
        ])->info(json_encode($jsonArrayDataLog));
        return Inertia::render('Samples/Index', [
            'samples' => $samples,
        ]);
    }

    /**
     * Display a filtered list of the resource.
     */
    public function filter(Request $request): String
    {
        $operator = ['email' => Auth::user()->email];
        // dd($operator);
        $samples = Sample::all()->map(fn ($sample) => [
            'id' => $sample->id,
            'title' => $sample->title,
            'subject' => $sample->subject,
            'summary' => $sample->summary,
            'content' => $sample->content,
        ]);
        $jsonArrayDataLog = [
            'operator' => $operator,
            'performed' => 'filter',
        ];
        // dd($jsonArrayDataLog);
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/samples_filter_info.log'),
        ])->info(json_encode($jsonArrayDataLog));
        return json_encode($samples);
    }

    /**
     * Display the identified resource.
     */
    public function read(int $id)
    {
        try {
            $operator = ['email' => Auth::user()->email];
            // dd($operator);
            $sample = Sample::find($id);
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'read',
            ];
            // dd($jsonArrayDataLog);
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/samples_read_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return json_encode($sample);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreSampleRequest $request)
    {
        // dd('create: ', $request);
        try {
            $operator = ['email' => Auth::user()->email];
            // dd($operator);
            $sample = Sample::create(
                $request->validate([
                    'title' => ['required', 'max:255'],
                    'subject' => ['required', 'max:255'],
                    'summary' => ['max:255'],
                    'content' => ['required', 'max:255'],
                ])
            );
            // dd($sample);
            $jsonArrayDataLog = [
                'operator' => $operator,
                'sample' => $sample,
                'performed' => 'create',
            ];
            // dd($jsonArrayDataLog);
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/samples_create_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return to_route('sample');
        } catch (\Exception $e) {
            $e->getMessage();
        }
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
    public function edit(UpdateSampleRequest $request)
    {
        try {
            $operator = ['email' => Auth::user()->email];
            // dd($operator);
            $sample = Sample::find($request['id']);
            $validate = $request->validate([
                'title' => ['required', 'max:255'],
                'subject' => ['required', 'max:255'],
                'summary' => ['max:255'],
                'content' => ['required', 'max:255'],
            ]);
            $sample->title = $validate['title'];
            $sample->subject = $validate['subject'];
            $sample->summary = $validate['summary'];
            $sample->content = $validate['content'];
            $sample->save();
            $jsonArrayDataLog = [
                'operator' => $operator,
                'sample' => $sample,
                'performed' => 'edit',
            ];
            // dd($jsonArrayDataLog);
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/samples_edit_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return to_route('sample');
        } catch (\Exception $e) {
            $e->getMessage();
        }
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
