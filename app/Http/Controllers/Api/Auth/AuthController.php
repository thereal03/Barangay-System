<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoverRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\Auth\ResetPassword;
use App\Notifications\Auth\UserRegister;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;
use Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('register', ['only' => ['register']]);
        $this->middleware('auth:sanctum', ['except' => ['login', 'register', 'recover', 'reset', 'verify']]);
        $this->middleware('demo', ['only' => ['register', 'recover', 'reset']]);
        $this->middleware('captcha', ['only' => ['login', 'register', 'recover', 'reset']]);
    }

    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();
            if ((int) $user->status !== 1) {
                return response()->json(['message' => __('auth.user_deactivated')], 406);
            }

            // Check if the default password has expired
            if (!is_null($user->password_expires_at) && Carbon::now()->greaterThan($user->password_expires_at)) {
                return response()->json([
                    'message' => __('auth.password_expired'),
                    'password_expired' => true
                ], 403);
            }

            // Check if the password is a default password
            $isDefaultPassword = $this->isDefaultPassword($request->get('password'));

            $token = $this->createToken($user);
            return response()->json([
                'token' => $token,
                'user' => new UserResource($user),
                'is_default_password' => $isDefaultPassword,
                'password_expires_at' => $user->password_expires_at
            ]);
        }

        return response()->json(['message' => __('auth.failed')], 406);
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => __('auth.logout_success')]);
    }

    /**
     * @param  RegisterRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $request->validated();

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->role_id = Setting::getDecoded('app_default_role');

        // Check if the password is a default password
        $defaultPasswords = ['Barangay123', 'Default2024', 'TempPass2025'];
        if (in_array($request->get('password'), $defaultPasswords)) {
            $user->password_expires_at = Carbon::now()->addDays(7); // Expires in 7 days
        }

        $user->save();

        $objNotificationData = new stdClass();
        $objNotificationData->user = $user;
        $user->notify((new UserRegister($objNotificationData))->locale(Setting::getDecoded('app_locale')));

        $token = $this->createToken($user);
        return response()->json(['token' => $token, 'user' => new UserResource($user)]);
    }

    /**
     * @param  RecoverRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function recover(RecoverRequest $request): JsonResponse
    {
        $request->validated();

        $user = User::where('email', $request->get('email'))->first();
        if (!$user) {
            return response()->json(['message' => __('auth.email_not_found')], 406);
        }

        $token = Str::random(60);
        DB::table('password_resets')->where('email', $request->get('email'))->delete();
        DB::table('password_resets')->insert(['email' => $request->get('email'), 'token' => $token, 'created_at' => Carbon::now()]);

        $objNotificationData = new stdClass();
        $objNotificationData->token = $token;
        $objNotificationData->user = $user;
        $user->notify((new ResetPassword($objNotificationData)));

        return response()->json(['message' => __('auth.password_reset_email_sent')]);
    }

    /**
     * @param  ResetRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function reset(ResetRequest $request): JsonResponse
    {
        $request->validated();

        $tokenData = DB::table('password_resets')->where('token', $request->get('token'))->first();
        if ($tokenData) {
            $user = User::where('email', $tokenData->email)->first();
            if (!$user) {
                return response()->json(['message' => __('auth.email_not_found')], 406);
            }

            $user->password = bcrypt($request->get('password'));
            $user->password_expires_at = null; // Reset expiration date
            $user->save();

            DB::table('password_resets')->where('email', $user->email)->delete();

            /** @var User $user */
            $user = Auth::loginUsingId($user->id);
            $token = $this->createToken($user);

            return response()->json(['token' => $token, 'user' => new UserResource($user)]);
        }

        return response()->json(['message' => __('auth.invalid_reset_token')], 406);
    }

    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return response()->json(new UserResource(auth()->user()));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function check(Request $request): JsonResponse
    {
        $dashboardAccess = false;
        $access = Auth::check();
        if ($access) {
            /** @var User $user */
            $user = Auth::user();
            $dashboardAccess = $user->userRole->checkDashboardAccess();
            if ($request->get('controller')) {
                $access = $user->userRole->checkPermission($request->get('controller'));
            }
        }
        return response()->json(['access' => $access, 'dashboard_access' => $dashboardAccess]);
    }

    /**
     * Create a token for the user.
     *
     * @param  User  $user
     * @return string
     */
    private function createToken(User $user): string
    {
        return $user->createToken(Str::slug(config('app.name').'_auth_token', '_'))->plainTextToken;
    }

    /**
     * Check if the user's password is a default password.
     *
     * @param  string  $password
     * @return bool
     */
    private function isDefaultPassword(string $password): bool
    {
        $defaultPasswords = ['Barangay123', 'Default2024', 'TempPass2025'];
        return in_array($password, $defaultPasswords);
    }
}