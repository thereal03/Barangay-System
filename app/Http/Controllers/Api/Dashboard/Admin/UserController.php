<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\User\StoreRequest;
use App\Http\Requests\Dashboard\Admin\User\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        $items = User::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json([
            'items' => UserResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->status = $request->get('status');
        $user->role_id = $request->get('role_id');
        $user->password = bcrypt($request->get('password'));

        // Check if the password is a default password
        if ($this->isDefaultPassword($request->get('password'))) {
            $user->password_expires_at = Carbon::now()->addDays(7); // Expires in 7 days
            $user->default_password = true; // Set the default_password flag
        } else {
            $user->default_password = false; // Ensure the flag is set to false if not a default password
        }

        if ($user->save()) {
            return response()->json(['message' => __('Data saved correctly'), 'user' => new UserResource($user)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $request->validated();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->status = $request->get('status');
        $user->role_id = $request->get('role_id');

        // Check if the password is a default password
        if ($this->isDefaultPassword($request->get('password'))) {
            $user->password_expires_at = Carbon::now()->addDays(7); // Expires in 7 days
            $user->default_password = true; // Set the default_password flag
        } else {
            $user->default_password = false; // Ensure the flag is set to false if not a default password
        }

        if ($user->save()) {
            return response()->json(['message' => 'Data updated correctly', 'user' => new UserResource($user)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($user->id === $authUser->id) {
            return response()->json(['message' => __('You can not delete your own user')], 406);
        }
        if ($user->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }

    public function userRoles(): JsonResponse
    {
        return response()->json(UserRoleResource::collection(UserRole::all()));
    }

    public function getUserCount()
    {
        $userCount = User::count();
        return response()->json(['count' => $userCount]);
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

    /**
     * Get the authenticated user's data.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'user' => new UserResource($user), // Use UserResource here
            'is_default_password' => $user->default_password, // Use the default_password flag
            'password_expires_at' => $user->password_expires_at,
        ]);
    }
}