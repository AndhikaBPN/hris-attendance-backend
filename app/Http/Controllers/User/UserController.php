<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Traits\FileUpload;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    use ApiResponse, FileUpload;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('limit', 10); // default 10
        $users = $this->userService->getAllUsers($perPage);

        return $this->successResponse($users, 'List users with pagination');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $result = $this->upload(
                file: $request->file('photo'),
                path: 'image/photos'
            );

            if ($result['success']) {
                $photoPath = $result['path'];
            } else {
                return $this->errorResponse($result['message'], 500);
            }
        }

        if ($photoPath) {
            $data['photo'] = $photoPath;
        }

        return $this->successResponse($user, 'User created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return $this->errorResponse('User not found', 400);
        }

        return $this->successResponse($user, 'User detail');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the user first
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return $this->errorResponse('User not found', 400);
        }

        // Get the ID of the logged-in user (from JWT)
        $updatedBy = auth()->id();

        if($updatedBy == null) {
            $updatedBy = 0; // System or admin ID
        }

        $user = $this->userService->updateUser($user, $request->validated(), $updatedBy);

        if (!$user) {
            return $this->errorResponse('User not found or update failed', 400);
        }

        return $this->successResponse($user, 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return $this->errorResponse('User not found', 400);
        }

        // Get the ID of the logged-in user (from JWT)
        $updatedBy = auth()->id();

        $deleted = $this->userService->deleteUser($user, $updatedBy);

        if (!$deleted) {
            return $this->errorResponse('User not found or already deleted', 400);
        }

        return $this->successResponse(null, 'User deleted successfully');
    }
}
