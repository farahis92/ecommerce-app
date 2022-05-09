<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpPhoneRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\{User, Otp};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Respond;

class AuthController extends Controller
{
    private string $loginToken = "login";
    private string $registerToken = 'register';

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('phone', 'password'))) {
            return response()->json(['message' => 'Phone or Password is Wrong'], 422);
        }
        $user = $request->user();
        $response = [
            'token' => $this->generateToken($request, $this->loginToken),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'isVerified' => $user->isPhoneVerified(),
        ];

        return Respond::respondOk($response, 'Login Successfully');

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'access_token' => $this->generateToken($user, $this->registerToken),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $response = $request->user()->only('name', 'email');
        return response()->json($response);
    }

    public function status(): Response
    {
        return response()->json(["status" => true], 200);
    }

    public function otpPhone(OtpPhoneRequest $request): JsonResponse
    {
        $executed = RateLimiter::attempt(
            'otp-phone:' . $request->device_id,
            2,
            function () use ($request) {
                Otp::create([
                    'device_id' => $request->device_id,
                    'user_id' => $request->user()->id,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'type' => $request->type,
                    'valid_until' => now()->addMinute(5),
                    'token' => random_int(100000, 999999)
                ]);
            }
        );

        if ($executed) {
            return response()->json('OTP Sent Successfully');
        } else {
            return response()->json('too many request, please wait 1 minutes', 422);
        }
    }

    public function otpEmail()
    {
    }

    private function generateToken($request, string $type)
    {
        return match ($type) {
            $this->loginToken => $request->user()->createToken('auth_token')->plainTextToken,
            $this->registerToken => $request->createToken('auth_token')->plainTextToken,
            default => null,
        };
    }

    public function test()
    {
//        throw new ModelNotFoundException('gak ketemu', 404);
        $data = User::findOrFail(1211);
//        return \response()->json($data);

        $user = User::latest()->first()->only("name", "email", "phone");
        return Respond::respondSuccess($user, 'berhasil', 200);
    }
}
