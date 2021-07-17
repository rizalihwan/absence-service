<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register()
    {
        $attr = $this->validate(request(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'npp' => 'required|min:3|max:13|unique:users,npp',
            'npp_supervisor' => 'nullable|min:3|max:13',
            'password' => ['required', Password::min(8)->letters()->numbers()]
        ]);
        $attr['password'] = bcrypt(request('password'));
        try {
            $user = User::create($attr);
            return response()->json([
                'message' => 'User Created',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json('Register failed ' . $e->getMessage(), 400);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Login Failed!'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
