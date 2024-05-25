<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Paper;
use Inertia\Response;
use App\Utils\SanitizerUtil;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use thiagoalessio\TesseractOCR\TesseractOCR;

class PaperController extends Controller
{
    const IMAGE_PATH_STORE = '/var/www/html/v3/quotes/storage/app/papers/';

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $papers = Paper::paginate(10)->through(fn ($paper) => [
                'id' => $paper->id,
                'title' => SanitizerUtil::rehydrate($paper->title)
            ]);
            // dd($papers);

            return Inertia::render('Tabs/Papers/PaperTab', [
                'papers' => $papers
            ]);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'error' => $e->getMessage(),
                'performed' => 'index',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return Inertia::render('Tabs/Papers/PaperTab');
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
     * store a newly created resource in storage
     * use OCR without having to save the file to disk
     *
     * @param StorePaperRequest $request
     * @return RedirectResponse
     */
    public function store(StorePaperRequest $request): RedirectResponse
    {
        try {
            $operator = ['email' => Auth::user()->email];
            $request->validate([
                'title' => ['required', 'min:8', 'max:255', 'unique:quotesdb.papers,title'],
                'scanned' => ['required', 'mimes:jpg,png', 'max:2048']
            ]);
            $prepared = self::prepared($request);
            // dd('store method', $prepared['title'], $prepared['name'], $prepared['filename']);

            // uses the TesseractOCR class directly on the temporary image file
            $imageTextContent = self::opticalCharacterRecognitionFromImage($operator, $_FILES['scanned']['tmp_name']);
            // dd($imageTextContent);

            $request['title'] = SanitizerUtil::sanitize($prepared['title']);
            $request['name'] = $prepared['name'];
            $request['size'] = $_FILES['scanned']['size'];
            $request['content'] = SanitizerUtil::sanitize($imageTextContent);

            Paper::create(
                $request->validate([
                    'title' => ['required', 'min:8', 'max:255', 'unique:quotesdb.papers,title'],
                    'name' => ['required', 'min:8', 'max:255', 'unique:quotesdb.papers,name'],
                    'size' => ['required', 'numeric'],
                    'content' => ['required'],
                ])
            );

            $jsonArrayData = [
                'operator' => $operator['email'],
                'title' => $request['title'],
                'performed' => 'store',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_store_info.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('papers');
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'store',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_store_error.log'),
            ])->error(json_encode($jsonArrayDataLog));

            return to_route('papers');
        }
    }

    /**
     * upload a newly resource in storage
     *
     * @param StorePaperRequest $request
     * @return RedirectResponse
     */
    public function upload(StorePaperRequest $request): RedirectResponse
    {
        try {
            $operator = ['email' => Auth::user()->email];
            $request->validate([
                'title' => ['required', 'min:8', 'max:255', 'unique:quotesdb.papers,title'],
                'scanned' => ['required', 'mimes:jpg,png', 'max:2048']
            ]);
            $prepared = self::prepared($request);
            dd('upload method', $prepared['title'], $prepared['name'], $prepared['filename']);

            // TODO: actual upload

            $jsonArrayData = [
                'operator' => $operator['email'],
                'title' => $request['title'],
                'performed' => 'upload',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_upload_info.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('papers');
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'upload',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_upload_error.log'),
            ])->error(json_encode($jsonArrayDataLog));

            return to_route('papers');
        }
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
     * prepared
     *
     * @param StorePaperRequest $req
     * @return array
     */
    private function prepared(StorePaperRequest $req): array
    {
        $name = explode('.', $req->file('scanned')->getClientOriginalName());
        $extension = $req->file('scanned')->getClientOriginalExtension();
        $title = preg_replace('/\s+/', '_', $req['title']);
        $title .=  '_' . time();
        $preparedName = $name[0] . '_' . $title;
        $preparedFilename = $preparedName . '.' . $extension;
        return [
            'title' => $title,
            'name' => $preparedName,
            'filename' => $preparedFilename,
        ];
    }

    /**
     * opticalCharacterRecognitionFromImage
     *
     * @param mixed $operator
     * @param string $temporaryPath
     * @return mixed
     */
    private function opticalCharacterRecognitionFromImage(mixed $operator, string $temporaryPath): mixed
    {
        $tesseractOcr = new TesseractOCR();
        $content = '';
        try {
            $tesseractOcr->image($temporaryPath);
            $content = $tesseractOcr->run();
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'ocr_from_image',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_ocr_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
        }
        return $content;
    }

    /**
     * opticalCharacterRecognitionFromStoredFile
     *
     * @param mixed $operator
     * @param string $imageName
     * @return mixed
     */
    private function opticalCharacterRecognitionFromStoredFile(mixed $operator, string $imageName): mixed
    {
        $tesseractOcr = new TesseractOCR();
        $content = '';
        try {
            $tesseractOcr->image(self::IMAGE_PATH_STORE . $imageName);
            $content = $tesseractOcr->run();
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'ocr_from_stored_file',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_ocr_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
        }
        return $content;
    }
}
