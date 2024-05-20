<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use thiagoalessio\TesseractOCR\TesseractOCR;

class PaperController extends Controller
{
    const IMAGE_PATH_STORE = '/var/www/html/v3/quotes/storage/app/papers/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePaperRequest $request)
    {
        dd($request['filename'], $request['scanned']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paper $paper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paper $paper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaperRequest $request, Paper $paper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paper $paper)
    {
        //
    }

    /**
     * prepareName
     *
     * @param string $temporaryName
     * @return string
     */
    private function prepareName(string $temporaryName): string
    {
        $subName = explode('.', $temporaryName);
        $indexOfLastElementOfSubName = count($subName) - 1;
        $name = $subName[0];
        $name = preg_replace('/\s+/', '_', $name);
        $name .= ('_' . time());
        $name .= ('_.' . $subName[$indexOfLastElementOfSubName]);
        return $name;
    }

    /**
     * opticalCharacterRecognition
     *
     * @param mixed $operator
     * @param string $imageName
     * @return mixed
     */
    private function opticalCharacterRecognition(mixed $operator, string $imageName): mixed
    {
        $tesseractOcr = new TesseractOCR();
        try {
            $tesseractOcr->image(self::IMAGE_PATH_STORE . $imageName);
            $content = $tesseractOcr->run();
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'creation',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/paper_create_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            $this->resetFields();
            return redirect()->to('/paper')->with('status', $e->getMessage());
        }
        return $content;
    }
}
