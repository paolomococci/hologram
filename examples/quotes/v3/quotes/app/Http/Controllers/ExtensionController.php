<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Extensions\EchoExtension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\InsertValueLabelRequest;

class ExtensionController extends Controller
{
    public function index(): Response
    {
        try {
            if (!empty($_GET)) {
                $value = self::isNumeric($_GET['value']) ? $_GET['value'] : 0;
                return Inertia::render('Tabs/Extensions/ExtensionTab', ['value' => $value]);
            }
            throw new \Exception("No valid value was passed!");
        } catch (\Exception $e) {
            return Inertia::render('Tabs/Extensions/ExtensionTab', ['value' => 0]);
        }
    }

    public function echo(InsertValueLabelRequest $request): RedirectResponse
    {
        $value = 0;
        $operator = ['email' => Auth::user()->email];

        try {
            $validate = $request->validate([
                'value' => 'required',
            ]);

            if (self::isNumeric($validate['value'])) {
                $inRange = filter_var(
                    $validate['value'],
                    FILTER_VALIDATE_INT,
                    array(
                        'options' => array(
                            'min_range' => 1,
                            'max_range' => 1000
                        )
                    )
                );

                if (!$inRange) {
                    throw new \Exception("This field requires an integer between one and one-thousand.");
                } else {
                    $value = $validate['value'];
                }

                $valueReceived = EchoExtension::echoInteger($value);

                $jsonArrayData = [
                    'operator' => $operator,
                    'value_received' => $valueReceived,
                    'error' => null,
                    'performed' => 'insert_label_valueReceived',
                ];

                return to_route('extensions', ['value' => $valueReceived]);
            }
        } catch (\Exception $e) {
            $jsonArrayData = [
                'operator' => $operator,
                'value' => null,
                'error' => $e->getMessage(),
                'performed' => 'insert_label_value',
            ];

            return to_route('extensions');
        }
    }

    private function isNumeric(mixed $value): bool
    {
        return is_numeric($value);
    }
}
