<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private string $loginToken = "login";
    private string $registerToken = 'register';

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/(62)[0-9]{9}/',
            'password' => 'required|string|min:6|max:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Please Check Input Credential'], 404);
        }

        if (!Auth::attempt($request->only('phone', 'password'))) {
            return response()->json(['message' => 'Phone or Password is Wrong'], 404);
        }

        return response()->json([
            'token' => $this->generateToken($request, $this->loginToken),
            'name' => $request->user()->name,
            'email' => $request->user()->email,
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/(62)[0-9]{9}/|unique:users|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'access_token' => $this->generateToken($user,$this->registerToken),
        ]);
    }

    public function me(Request $request)
    {
        return $request->user()->only('name', 'email');
    }

    public function status()
    {
        return response()->json(["status" => true], 200);
    }

    /**
     * @param $request
     * @param $type
     * return token
     */
    private function generateToken($request, string $type)
    {
        return match ($type) {
            $this->loginToken => $request->user()->createToken('auth_token')->plainTextToken,
            $this->registerToken => $request->createToken('auth_token')->plainTextToken,
            default => null,
        };
    }
}
