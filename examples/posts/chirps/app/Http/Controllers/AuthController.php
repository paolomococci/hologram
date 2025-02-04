<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api',
            ['except' => ['login', 'register']]
        );
    }

    /**
     * Register a new user.
     */
    public function register(Request $request): string
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:3|max:255',
                    'email' => 'required|max:36|email|unique:users',
                    'password' => [
                        'required',
                        'confirmed',
                        'unique:users',
                        Password::min(12)->max(24)->letters()->mixedCase()->numbers()->symbols(),
                    ],
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'The credentials provided have failed validation!',
                    'requests' => [
                        'name' => 'The name field is mandatory and must have a minimum of 3 characters and a maximum of 255 characters.',
                        'email' => 'The email field is mandatory, must have a valid format with a maximum of 36 characters and must be unique.',
                        'password' => 'The password field is mandatory, must have a minimum of 12 characters and a maximum of 24 characters, must contain a confirm password, must be unique, must contain lowercase and uppercase letters, numbers and symbols. And the password cannot have the same text as the email.',
                    ],
                ], Response::HTTP_BAD_REQUEST);
            }

            $credentials = $validator->validate();

            // Check that the email provided and the password do not correspond to the same text.
            if ($credentials['email'] == $credentials['password']) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'The credentials provided have failed validation!',
                    'requests' => [
                        'password' => 'The password field is mandatory, must have a minimum of 12 characters and a maximum of 24 characters, must contain a confirm password, must be unique, must contain lowercase and uppercase letters, numbers and symbols. And the password cannot have the same text as the email.',
                    ],
                ], Response::HTTP_BAD_REQUEST);
            }

            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);

            $token = Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);

            return response()->json([
                'status' => 'success',
                'message' => 'User registered correctly.',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Verify the login credentials.
     */
    public function login(Request $request): string
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            $credentials = $request->only('email', 'password');

            $token = Auth::attempt($credentials);
            if (! $token) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Increment the token version
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            $user->token_version += 1;
            $user->save();

            // Generate the token with the new version in the payload
            $token = auth()->attempt($credentials);

            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * To log out an user.
     */
    public function logout(): string
    {
        try {
            Auth::logout();

            return response()->json([
                'status' => 'success',
                'message' => 'Successful logout!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the credentials of the logged-in user.
     */
    public function update(Request $request): string
    {
        try {
            $user = auth()->user();
            $userCanUpdated = false;

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:3|max:255',
                    'email' => 'required|max:36|email',
                    'password' => [
                        'required',
                        'confirmed',
                        'unique:users',
                        Password::min(12)->max(24)->letters()->mixedCase()->numbers()->symbols(),
                    ],
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'The credentials provided have failed validation!',
                    'requests' => [
                        'name' => 'The name field is mandatory and must have a minimum of 3 characters and a maximum of 255 characters.',
                        'email' => 'The email field is mandatory, must have a valid format with a maximum of 36 characters and must be unique.',
                        'password' => 'The password field is mandatory, must have a minimum of 12 characters and a maximum of 24 characters, must contain a confirm password, must be unique, must contain lowercase and uppercase letters, numbers and symbols. And the password cannot have the same text as the email.',
                    ],
                ], Response::HTTP_BAD_REQUEST);
            }

            $credentials = $validator->validate();

            // Check that the email provided and the password do not correspond to the same text.
            if (Hash::check($credentials['email'], $user->password)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'The credentials provided have failed validation!',
                    'requests' => [
                        'password' => 'The password field is mandatory, must have a minimum of 12 characters and a maximum of 24 characters, must contain a confirm password, must be unique, must contain lowercase and uppercase letters, numbers and symbols. And the password cannot have the same text as the email.',
                    ],
                ], Response::HTTP_BAD_REQUEST);
            }

            // Verify that the user name matches what is already registered in the system.
            if ($user->name != $credentials['name']) {
                $userCanUpdated = true;
                $user->update([
                    'name' => $credentials['name'],
                ]);
            }

            // Verify that the email corresponds to the registered email in the system.
            if ($user->email != $credentials['email']) {
                // Verify that the email provided is not already in use.
                $inUse = User::where('email', $credentials['email'])->first();
                if ($inUse === null) {
                    $userCanUpdated = true;
                    $user->update([
                        'email' => $credentials['email'],
                    ]);
                }
            }

            // Check that the new password is not equal to the old password.
            if (! Hash::check($credentials['password'], $user->password)) {
                $userCanUpdated = true;
                $user->update([
                    'password' => Hash::make($credentials['password']),
                ]);
            }

            if ($userCanUpdated) {
                $token = Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'The user credentials have been correctly updated.',
                    'user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ],
                ], Response::HTTP_RESET_CONTENT);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'There are no changes to be made to the user credentials.',
                    'user' => $user,
                ], Response::HTTP_NOT_MODIFIED);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * To refresh the user's token before it expires.
     */
    public function refresh(): string
    {
        try {
            return response()->json([
                'status' => 'success',
                'user' => Auth::user(),
                'authorization' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Method that returns the username or email of a logged-in user.
     */
    public function whoami(): string
    {
        try {
            $user = auth()->user();

            return response()->json([
                'status' => 'success',
                'user' => $user,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
