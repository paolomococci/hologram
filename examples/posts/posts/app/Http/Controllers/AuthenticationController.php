<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthenticationController extends Controller
{
    public function registration(Request $request): array
    {
        // customize a validator
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|max:24|email|unique:users',
                'password' => [
                    'required',
                    'confirmed',
                    'ascii',
                    // User must enter a strong password!
                    Password::min(12)->letters()->mixedCase()->numbers()->symbols(),
                ],
            ]
        );

        if ($validator->fails()) {
            return [
                'message' => 'Creating a specific validator during user registration failed!',
            ];
        }

        $fields = $validator->validate();
        // if you want to get only part of the validated fields
        // only
        // $fields = $validator->safe()->only(
        //     'email',
        //     'password',
        // );
        // except
        // $fields = $validator->safe()->except(
        //     'name',
        // );

        $user = User::create($fields);
        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function login(Request $request): array
    {
        $request->validate([
            'email' => 'required|max:24|email|exists:users',
            'password' => 'required|ascii|min:12',
        ]);

        // usual method:
        // Auth::attempt(['email' => $email, 'password' => $password]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return [
                'errors' => [
                    'message' => 'You provided incorrect credentials!',
                ],
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function updatePassword(Request $request): array
    {

        // customize a validator
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'password' => [
                        'required',
                        'confirmed',
                        'ascii',
                        // User must enter a strong password!
                        Password::min(12)->letters()->mixedCase()->numbers()->symbols(),
                    ],
                ]
            );

            if ($validator->fails()) {
                return [
                    'message' => 'Creating a specific validator to update the password failed!',
                ];
            }

            $fields = $validator->validate();

            $user = User::where('email', auth('sanctum')->user()->email)->first();
            $user->update($fields);

            return [
                'message' => 'Your password has been successfully updated.',
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
            ];
        }
    }

    public function logout(): array
    {
        try {
            auth('sanctum')->user()->tokens()->delete();

            return [
                'message' => 'You have successfully logged out.',
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
            ];
        }
    }
}
