<?php

namespace App\Http\Controllers;

use Exception;
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
     * returns a list of papers as a json structured string
     *
     */
    public function filter()
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $papers = Paper::all();
            Paper::rehydrate($papers);
            $jsonArrayData = [
                'operator' => $operator,
                'papers' => $papers,
                'error' => null,
                'performed' => 'index_json',
            ];

            return response()->json($jsonArrayData);
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'papers' => null,
                'error' => $e->getMessage(),
                'performed' => 'index_json',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_index_info.log'),
            ])->info(json_encode($jsonArrayData));

            return response()->json($jsonArrayData);
        }
    }

    /**
     * returns a list paginated of papers
     *
     * @return Response
     */
    public function index(): Response
    {
        $operator = ['email' => Auth::user()->email];

        try {
            $papers = Paper::latest()->paginate(5)->through(fn ($paper) => [
                'id' => $paper->id,
                'title' => SanitizerUtil::rehydrate($paper->title),
                'created_at' => $paper->created_at
            ]);

            return Inertia::render('Tabs/Papers/PaperTab', [
                'papers' => $papers
            ]);
        } catch (Exception $e) {
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

            if (
                array_key_exists('tmp_name', $_FILES['scanned']) &&
                array_key_exists('size', $_FILES['scanned']) &&
                $_FILES['scanned']['size'] > 0
            ) {
                $request->validate([
                    'title' => ['required', 'min:8', 'max:255', 'unique:quotesdb.papers,title'],
                    'scanned' => ['required', 'mimes:jpg,png', 'max:2048']
                ]);
                $prepared = self::prepared($request);

                // uses the TesseractOCR class directly on the temporary image file
                $imageTextContent = self::opticalCharacterRecognitionFromImage(
                    $operator,
                    $_FILES['scanned']['tmp_name']
                );

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
            } else {
                throw new Exception("It appears that a valid file was not selected!");
            }
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
     * display the specified resource
     *
     * @param integer $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        try {
            $operator = ['email' => Auth::user()->email];

            $paper = Paper::find($id);
            $paper['title'] = SanitizerUtil::rehydrate($paper['title']);
            $paper['content'] = SanitizerUtil::rehydrate($paper['content']);

            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'show',
            ];
            return response()->json($paper);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paper $paper)
    {
        //
    }

    /**
     * update the specified resource in storage
     *
     * @param UpdatePaperRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePaperRequest $request): RedirectResponse
    {
        $operator = ['email' => Auth::user()->email];

        $request['content'] = SanitizerUtil::sanitize($request['content']);

        $req = [
            'id' => $request['id'],
            'title' => $request['title'],
            'content' => $request['content'],
        ];

        try {
            $paper = Paper::findOrFail($req['id']);

            $validated = $request->validate([
                'content' => ['required', 'min:32', 'max:1024'],
            ]);

            $paper['content'] = $validated['content'];

            $paper->save();

            $jsonArrayData = [
                'operator' => $operator['email'],
                'title' => $req['title'],
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_update_info.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('papers');
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'title' => $req['title'],
                'error' => $e->getMessage(),
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/papers_update_error.log'),
            ])->info(json_encode($jsonArrayData));

            return to_route('papers');
        }
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
