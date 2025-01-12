<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function registration(Request $request): array
    {
        $fields = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|max:24|email|unique:users',
            'password' => 'required|confirmed|ascii|min:12',
        ]);

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
        $fields = $request->validate([
            'password' => 'required|confirmed|ascii|min:12',
        ]);

        $user = User::where('email', auth('sanctum')->user()->email)->first();
        $user->update($fields);

        return [
            'message' => 'Your password has been successfully updated.',
        ];
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
