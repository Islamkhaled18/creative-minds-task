<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyMobileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageService;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $twilioService;
    protected $imageService;

    public function __construct(TwilioService $twilioService, ImageService $imageService)
    {
        $this->twilioService = $twilioService;
        $this->imageService  = $imageService;
        $this->middleware('auth:api', ['except' => ['register', 'verifyMobile', 'login']]);
    }

    public function register(RegisterRequest $request)
    {
        if (! $request->hasFile('profile_image') || ! $request->file('profile_image')->isValid()) {
            return response()->json(['error' => 'Invalid image upload'], 422);
        }

        try {

            $verificationCode = (string) rand(100000, 999999);
            $expiresAt        = Carbon::now()->addMinutes(10);

            $user = User::create([
                'username'                     => $request->username,
                'mobile_number'                => $request->mobile_number,
                'password'                     => Hash::make($request->password),
                'verification_code'            => $verificationCode,
                'verification_code_expires_at' => $expiresAt,
                'latitude'                     => $request->latitude,
                'longitude'                    => $request->longitude,
                'location_name'                => $request->location_name,
                'user_type'                    => $request->user_type ?? 'user',
            ]);

            if ($user) {
                $images = $this->imageService->uploadProfileImage($request->file('profile_image'), $user->id);
                $user->update([
                    'profile_image' => $images['profile_image'],
                    'thumbnail'     => $images['thumbnail'],
                ]);

                $smsSent = $this->twilioService->sendVerificationSMS(
                    $request->mobile_number,
                    $verificationCode
                );

                if (! $smsSent) {

                    return response()->json([
                        'message' => 'Account created but verification SMS failed to send.',
                        'user_id' => $user->id,
                    ], 201);
                }

                return response()->json([
                    'message' => 'Registration successful. Please verify your mobile number with the code sent to you.',
                    'user_id' => $user->id,
                ], 201);
            }

            return response()->json(['error' => 'Failed to create user'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    public function verifyMobile(VerifyMobileRequest $request)
    {
        $user = User::where('mobile_number', $request->mobile_number)
            ->where('verification_code', $request->verification_code)
            ->where('verification_code_expires_at', '>', Carbon::now())
            ->first();

        if (! $user) {
            return response()->json([
                'error' => 'Invalid or expired verification code, try again',
            ], 400);
        }

        $user->is_verified                  = true;
        $user->verification_code            = null;
        $user->verification_code_expires_at = null;
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message'    => 'Mobile number verified successfully',
            'token'      => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('mobile_number', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth('api')->user();

        if ($request->has('device_token') && $request->device_token) {

            $user->deviceTokens()->updateOrCreate(
                ['device_token' => $request->device_token],
                [
                    'user_id' => $user->id,
                ]
            );
        }

        if (! $user->is_verified) {

            $verificationCode = (string) rand(100000, 999999);
            $expiresAt        = Carbon::now()->addMinutes(10);

            $user->verification_code            = $verificationCode;
            $user->verification_code_expires_at = $expiresAt;
            $user->save();

            $this->twilioService->sendVerificationSMS($user->mobile_number, $verificationCode);

            return response()->json([
                'message' => 'Your account is not verified. A new verification code has been sent to your mobile.',
                'user_id' => $user->id,
            ], 403);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        return new UserResource(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => new UserResource(auth('api')->user()),
        ]);
    }

}
